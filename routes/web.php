<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventTypeController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\EventReportController as AdminEventReportController;
use App\Http\Controllers\Organizer\DashboardController as OrganizerDashboardController;
use App\Http\Controllers\Organizer\EventController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\RegistrationController;
use App\Http\Controllers\Member\FavoriteController;
use App\Http\Controllers\Member\ProfileController;
use App\Http\Controllers\Member\NotificationController;
use App\Http\Controllers\Member\EventReportController as MemberEventReportController;
use App\Http\Controllers\Public\CategoryController as PublicCategoryController;
use App\Http\Controllers\Public\EventController as PublicEventController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [PublicEventController::class, 'home'])->name('home');
Route::get('/events', [PublicEventController::class, 'explore'])->name('events.index');
Route::get('/events/calendar', [PublicEventController::class, 'calendar'])->name('events.calendar');
Route::get('/events/{slug}', [PublicEventController::class, 'show'])->name('events.show');
Route::get('/categories', [PublicCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [PublicCategoryController::class, 'show'])->name('categories.show');
Route::get('/about', function () { return view('about'); })->name('about');

Route::middleware('auth')->group(function () {

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->middleware('admin')
        ->name('admin.dashboard');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::patch('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])
            ->name('categories.toggle-status');

        Route::resource('event-types', EventTypeController::class);
        Route::patch('event-types/{eventType}/toggle-status', [EventTypeController::class, 'toggleStatus'])
            ->name('event-types.toggle-status');

        Route::resource('cities', CityController::class);
        Route::patch('cities/{city}/toggle-status', [CityController::class, 'toggleStatus'])
            ->name('cities.toggle-status');

        Route::resource('users', AdminUserController::class)->only(['index', 'edit', 'update']);
        Route::get('/users/export', [AdminUserController::class, 'export'])->name('users.export');

        Route::get('/registrations', [AdminRegistrationController::class, 'index'])->name('registrations.index');

        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');

        Route::get('/organizer-performance', [AdminDashboardController::class, 'organizerPerformance'])->name('organizer-performance');

        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');

        Route::get('/reports', [AdminEventReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{report}', [AdminEventReportController::class, 'show'])->name('reports.show');
        Route::post('/reports/{report}/resolve', [AdminEventReportController::class, 'resolve'])->name('reports.resolve');
        Route::post('/reports/{report}/dismiss', [AdminEventReportController::class, 'dismiss'])->name('reports.dismiss');

        Route::get('/events/pending', [AdminEventController::class, 'pending'])->name('events.pending');
        Route::get('/events', [AdminEventController::class, 'index'])->name('events.index');
        Route::get('/events/{event}', [AdminEventController::class, 'show'])->name('events.show');
        Route::post('/events/{event}/approve', [AdminEventController::class, 'approve'])->name('events.approve');
        Route::post('/events/{event}/reject', [AdminEventController::class, 'reject'])->name('events.reject');
        Route::delete('/events/{event}', [AdminEventController::class, 'destroy'])->name('events.destroy');
    });

    Route::get('/organizer/dashboard', [OrganizerDashboardController::class, 'index'])
        ->middleware('organizer')
        ->name('organizer.dashboard');

    Route::middleware('organizer')->prefix('organizer')->name('organizer.')->group(function () {
        Route::get('/events', [EventController::class, 'index'])->name('events.index');
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::patch('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::post('/events/{event}/submit', [EventController::class, 'submit'])->name('events.submit');
        Route::post('/events/{event}/cancel', [EventController::class, 'cancel'])->name('events.cancel');
        Route::post('/events/{event}/clone', [EventController::class, 'clone'])->name('events.clone');
        Route::get('/events/{event}/analytics', [EventController::class, 'analytics'])->name('events.analytics');
        Route::post('/events/{event}/communicate', [EventController::class, 'communicate'])->name('events.communicate');
        Route::get('/events/{event}/registrations', [EventController::class, 'registrations'])->name('events.registrations');
        Route::get('/events/{event}/export', [EventController::class, 'exportRegistrations'])->name('events.exportRegistrations');
        Route::get('/events/{event}/registrations/{registration}', [EventController::class, 'registrationDetail'])->name('events.registration-detail');
        Route::post('/events/{event}/registrations/{registration}/checkin', [EventController::class, 'checkin'])->name('events.checkin');
        Route::post('/events/{event}/registrations/{registration}/confirm-payment', [EventController::class, 'confirmPayment'])->name('events.confirm-payment');
        
        // Organizer notifications
        Route::get('/notifications', [\App\Http\Controllers\Member\NotificationController::class, 'index'])->name('notifications.index');
        Route::patch('/notifications/{notification}/read', [\App\Http\Controllers\Member\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::patch('/notifications/read-all', [\App\Http\Controllers\Member\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
        Route::delete('/notifications/{notification}', [\App\Http\Controllers\Member\NotificationController::class, 'destroy'])->name('notifications.destroy');
    });

    // Member routes
    Route::get('/member/dashboard', [MemberDashboardController::class, 'index'])
        ->middleware('member')
        ->name('member.dashboard');

    Route::get('/my-registrations', [RegistrationController::class, 'index'])
        ->name('member.registrations');
    Route::post('/events/{event}/register', [RegistrationController::class, 'store'])
        ->name('events.register');
    Route::delete('/registrations/{registration}', [RegistrationController::class, 'destroy'])
        ->name('member.registrations.destroy');

    Route::get('/favorites', [FavoriteController::class, 'index'])
        ->name('member.favorites');
    Route::post('/events/{event}/favorite', [FavoriteController::class, 'store'])
        ->name('events.favorite');
    Route::delete('/events/{event}/favorite', [FavoriteController::class, 'destroy'])
        ->name('events.unfavorite');

    // Event Reports
    Route::post('/events/{event}/report', [MemberEventReportController::class, 'store'])
        ->name('events.report');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('member.profile');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('member.profile.update');
});
