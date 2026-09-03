# Prompt OpenCode 1 — Footer: Warna + Isi + Responsive

File: resources/views/components/footer.blade.php

## PERUBAHAN
1. WARNA: bg-[#635BFF] -> bg-[#4338CA] (ungu lebih gelap)
2. ISI: 4 kolom (Brand, Explore dynamic, Akun, EventHub)
3. RESPONSIVE: grid 1 kolom mobile, 2 tablet, 4 desktop

## LINK FOOTER
- Explore: Semua Event + 5 kategori dari DB (dynamic)
- Akun: Masuk, Daftar, Dashboard, Profil
- EventHub: Tentang Kami, Bantuan, Privasi, Syarat

## ATURAN
- Ganti SELURUH isi file
- Dynamic categories: Category::where(is_active, true)->limit(5)
- Responsive grid