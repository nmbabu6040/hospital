<?php

use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartmentController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\HospitalController as AdminHospitalController;
use App\Http\Controllers\Admin\JournalController as AdminJournalController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\OfferController as AdminOfferController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\SisterConcernController as AdminSisterConcernController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Front\AppointmentController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\DepartmentController;
use App\Http\Controllers\Front\DoctorController;
use App\Http\Controllers\Front\GalleryController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\HospitalController;
use App\Http\Controllers\Front\JournalController;
use App\Http\Controllers\Front\LanguageController;
use App\Http\Controllers\Front\NewsController;
use App\Http\Controllers\Front\OfferController;
use App\Http\Controllers\Front\PackageController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\VideoController;
use App\Http\Controllers\Front\SitemapController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\DiagnosticController as AdminDiagnosticController;
use App\Http\Controllers\Front\DiagnosticController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\OnlineReportController as AdminOnlineReportController;
use App\Http\Controllers\Front\OnlineReportController;
use App\Http\Controllers\Admin\AboutContentController;
use App\Http\Controllers\Admin\AccreditationController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Front\CustomPageController;
use App\Http\Controllers\Admin\TestController as AdminTestController;
use App\Http\Controllers\Front\TestController;
use App\Http\Controllers\Front\LocationController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Front\CommentController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\HospitalReportController;
use App\Http\Controllers\Admin\HospitalStatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Front-end Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// About
Route::get('/about/md-message', [PageController::class, 'mdMessage'])->name('about.md-message');
Route::get('/about/about-us', [PageController::class, 'about'])->name('about.about-us');
Route::get('/about/accreditation', [PageController::class, 'accreditation'])->name('about.accreditation');
Route::get('/about/sister-concerns', [PageController::class, 'sisterConcerns'])->name('about.sister-concerns');

// Doctors
Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');

// Departments
Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');

// Hospitals
Route::get('/hospitals', [HospitalController::class, 'index'])->name('hospitals.index');
Route::get('/hospitals/{hospital}', [HospitalController::class, 'show'])->name('hospitals.show');

Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');

// Diagnostics
Route::get('/diagnostics', [DiagnosticController::class, 'index'])->name('diagnostics.index');
Route::get('/diagnostics/{diagnostic}', [DiagnosticController::class, 'show'])->name('diagnostics.show');

// Packages
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{package}', [PackageController::class, 'show'])->name('packages.show');

// Individual Tests
Route::get('/tests', [TestController::class, 'index'])->name('tests.index');
Route::get('/tests/{test}', [TestController::class, 'show'])->name('tests.show');

// Appointment
Route::get('/book-appointment', [AppointmentController::class, 'create'])->name('appointment.create');
Route::post('/book-appointment', [AppointmentController::class, 'store'])->name('appointment.store');

// Online Report
// Online Report
Route::get('/online-report', [OnlineReportController::class, 'index'])->name('online-report.index');
Route::post('/online-report', [OnlineReportController::class, 'search'])->name('online-report.search');
Route::get('/online-report/{online_report}/download', [OnlineReportController::class, 'download'])->name('online-report.download');
Route::get('/online-report/{online_report}/pdf', [OnlineReportController::class, 'generatedPdf'])->name('online-report.pdf');

// Contact
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');

// Media
Route::get('/media/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/media/news/{news}', [NewsController::class, 'show'])->name('news.show');
Route::post('/media/news/{news}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/media/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/media/offers', [OfferController::class, 'index'])->name('offers.index');
Route::get('/media/videos', [VideoController::class, 'index'])->name('videos.index');
Route::get('/media/journal', [JournalController::class, 'index'])->name('journals.index');

// Dynamic Custom Pages (সবসময় সবার শেষে রাখতে হবে)
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/page/{page:slug}', [CustomPageController::class, 'show'])->name('pages.show');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');

    Route::middleware('admin.auth')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('doctors', AdminDoctorController::class)->except('show');
        Route::resource('departments', AdminDepartmentController::class)->except('show');
        Route::resource('hospitals', AdminHospitalController::class)->except('show');
        Route::resource('diagnostics', AdminDiagnosticController::class)->except('show');
        Route::resource('packages', AdminPackageController::class)->except('show');
        Route::resource('tests', AdminTestController::class)->except('show');
        Route::resource('news', AdminNewsController::class)->except('show');
        Route::resource('gallery', AdminGalleryController::class)->except('show');
        Route::resource('offers', AdminOfferController::class)->except('show');
        Route::resource('videos', AdminVideoController::class)->except('show');
        Route::resource('journals', AdminJournalController::class)->except('show');
        Route::resource('sliders', AdminSliderController::class)->except('show');
        Route::resource('sister-concerns', AdminSisterConcernController::class)->except('show');

        Route::get('appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
        Route::patch('appointments/{appointment}', [AdminAppointmentController::class, 'update'])->name('appointments.update');
        Route::delete('appointments/{appointment}', [AdminAppointmentController::class, 'destroy'])->name('appointments.destroy');

        Route::get('messages', [AdminMessageController::class, 'index'])->name('messages.index');
        Route::patch('messages/{message}/read', [AdminMessageController::class, 'markRead'])->name('messages.read');
        Route::delete('messages/{message}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');

        Route::get('backups', [BackupController::class, 'index'])->name('backups.index');
        Route::post('backups', [BackupController::class, 'create'])->name('backups.create');
        Route::get('backups/{filename}/download', [BackupController::class, 'download'])->name('backups.download');
        Route::delete('backups/{filename}', [BackupController::class, 'destroy'])->name('backups.destroy');

        Route::resource('online-reports', AdminOnlineReportController::class)->except('show');

        Route::get('comments', [AdminCommentController::class, 'index'])->name('comments.index');
        Route::post('comments/{comment}/reply', [AdminCommentController::class, 'reply'])->name('comments.reply');
        Route::patch('comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
        Route::patch('comments/{comment}/reject', [AdminCommentController::class, 'reject'])->name('comments.reject');
        Route::delete('comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');


        Route::get('notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
        Route::get('notifications/recent', [AdminNotificationController::class, 'recent'])->name('notifications.recent');
        Route::post('notifications/mark-all-read', [AdminNotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
        Route::get('notifications/{notification}/read', [AdminNotificationController::class, 'markRead'])->name('notifications.read');


        Route::resource('hospital-stats', HospitalStatController::class)->except('show');
        Route::get('hospital-stats-reports', [HospitalReportController::class, 'index'])->name('hospital-stats.reports');

        Route::get('about-content', [AboutContentController::class, 'edit'])->name('about-content.edit');
        Route::put('about-content', [AboutContentController::class, 'update'])->name('about-content.update');
        Route::resource('accreditations', AccreditationController::class)->except('show');

        Route::resource('pages', AdminPageController::class)->except('show');

        // শুধু Super Admin access করতে পারবে
        Route::middleware('admin.role:super_admin')->group(function () {
            Route::resource('branches', BranchController::class)->except('show');
            Route::resource('admin-users', AdminUserController::class)->except('show');
        });
    });
});
