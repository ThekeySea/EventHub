# ============================================
# EventHub — Laravel 13 Deployment (Railway)
# ============================================

# ---- Stage 1: Build Node Assets ----
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm ci --no-audit --no-fund

COPY vite.config.js* tailwind.config.js* postcss.config.js* ./
COPY resources/ resources/
RUN npm run build


# ---- Stage 2: PHP Production ----
FROM php:8.3-cli AS production

# System dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libzip-dev libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl opcache \
    && pecl install redis && docker-php-ext-enable redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

# Install PHP dependencies (no dev)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy application code
COPY . .

# Create .env if not exists
RUN touch /app/.env

# Create storage directories
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p storage/logs \
    && mkdir -p storage/app/public \
    && chmod -R 775 storage \
    && chmod -R 775 bootstrap/cache

# Generate autoloader & optimize
RUN composer dump-autoload --optimize

# Copy built assets from node stage (AFTER composer install)
COPY --from=node-builder /app/public/build/ /app/public/build/

# Expose port
EXPOSE 8000

# Start command - create storage link at runtime
CMD php artisan key:generate --force && \
    php artisan storage:link --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=$PORT
