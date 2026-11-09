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
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\InvoicePdfController;
use App\Http\Controllers\Patient\AuthController as PatientAuthController;
use App\Http\Controllers\Patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\Front\SlotController;
use App\Http\Controllers\Admin\DoctorScheduleController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Front\SearchController;
use App\Http\Controllers\Admin\VideoConsultationController as AdminVideoConsultationController;
use App\Http\Controllers\Front\VideoConsultationController;
use App\Http\Controllers\Admin\BloodBankController as AdminBloodBankController;
use App\Http\Controllers\Front\BloodBankController;
use App\Http\Controllers\Admin\AmbulanceController as AdminAmbulanceController;
use App\Http\Controllers\Admin\AmbulanceRequestController as AdminAmbulanceRequestController;
use App\Http\Controllers\Front\AmbulanceController;
use App\Http\Controllers\Admin\BedCategoryController as AdminBedCategoryController;
use App\Http\Controllers\Admin\QueueDisplayController as AdminQueueDisplayController;
use App\Http\Controllers\Front\QueueController;
use App\Http\Controllers\Admin\MedicineController as AdminMedicineController;
use App\Http\Controllers\Admin\MedicineSaleController;
use App\Http\Controllers\Front\MedicineController;
use App\Http\Controllers\Admin\JobApplicationController;
use App\Http\Controllers\Admin\JobPostingController as AdminJobPostingController;
use App\Http\Controllers\Admin\NoticeController as AdminNoticeController;
use App\Http\Controllers\Front\CareerController;
use App\Http\Controllers\Front\NoticeController;
use App\Http\Controllers\Admin\ShowcaseItemController;
use App\Http\Controllers\Front\ShowcaseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Front-end Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/search/quick', [SearchController::class, 'quick'])->name('search.quick');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// About
Route::get('/about/md-message', [PageController::class, 'mdMessage'])->name('about.md-message');
Route::get('/about/about-us', [PageController::class, 'about'])->name('about.about-us');
Route::get('/about/accreditation', [PageController::class, 'accreditation'])->name('about.accreditation');
Route::get('/about/sister-concerns', [PageController::class, 'sisterConcerns'])->name('about.sister-concerns');
Route::get('/about/corporate-tieup', [ShowcaseController::class, 'corporate'])->name('about.corporate');
Route::get('/about/awards', [ShowcaseController::class, 'awards'])->name('about.awards');
Route::get('/about/csr', [ShowcaseController::class, 'csr'])->name('about.csr');


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

//ambulance
Route::get('/ambulance', [AmbulanceController::class, 'create'])->name('ambulance.create');
Route::post('/ambulance', [AmbulanceController::class, 'store'])->name('ambulance.store');

//pharmacy
Route::get('/pharmacy', [MedicineController::class, 'index'])->name('pharmacy.index');

//bad availability
Route::get('/bed-availability', [QueueController::class, 'beds'])->name('beds.index');
Route::get('/live-queue', [QueueController::class, 'queue'])->name('queue.index');

// Packages
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{package}', [PackageController::class, 'show'])->name('packages.show');

// Individual Tests
Route::get('/tests', [TestController::class, 'index'])->name('tests.index');
Route::get('/tests/{test}', [TestController::class, 'show'])->name('tests.show');

//blood bank
Route::get('/blood-bank', [BloodBankController::class, 'index'])->name('blood-bank.index');
Route::get('/blood-bank/register', [BloodBankController::class, 'createDonor'])->name('blood-bank.register');
Route::post('/blood-bank/register', [BloodBankController::class, 'storeDonor'])->name('blood-bank.register.store');
Route::get('/blood-bank/request', [BloodBankController::class, 'createRequest'])->name('blood-bank.request');
Route::post('/blood-bank/request', [BloodBankController::class, 'storeRequest'])->name('blood-bank.request.store');

// Appointment
Route::get('/book-appointment', [AppointmentController::class, 'create'])->name('appointment.create');
Route::post('/book-appointment', [AppointmentController::class, 'store'])->name('appointment.store');

Route::get('/doctors/{doctor}/available-dates', [SlotController::class, 'availableDates'])->name('slots.dates');
Route::get('/doctors/{doctor}/slots', [SlotController::class, 'slots'])->name('slots.index');

// Career
Route::get('/career', [CareerController::class, 'index'])->name('career.index');
Route::get('/career/{jobPosting}', [CareerController::class, 'show'])->name('career.show');
Route::post('/career/{jobPosting}/apply', [CareerController::class, 'apply'])->name('career.apply');

// Notice
Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
Route::get('/notices/{notice}', [NoticeController::class, 'show'])->name('notices.show');

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

//video
Route::get('/video-consultation', [VideoConsultationController::class, 'create'])->name('video-consultation.create');
Route::post('/video-consultation', [VideoConsultationController::class, 'store'])->name('video-consultation.store');
Route::get('/video-consultation/{videoConsultation}/join', [VideoConsultationController::class, 'joinRoom'])->name('video-consultation.join');


// Dynamic Custom Pages (সবসময় সবার শেষে রাখতে হবে)
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/page/{page:slug}', [CustomPageController::class, 'show'])->name('pages.show');


/*
|--------------------------------------------------------------------------
| Payment Routes
|--------------------------------------------------------------------------
*/

Route::post('/packages/{package}/pay', [PaymentController::class, 'initiatePackagePayment'])->name('payment.package');
Route::get('/invoices/{invoice}/pay', [PaymentController::class, 'initiateInvoicePayment'])->name('payment.invoice');


Route::match(['get', 'post'], '/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::match(['get', 'post'], '/payment/fail', [PaymentController::class, 'fail'])->name('payment.fail');
Route::match(['get', 'post'], '/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/payment/ipn', [PaymentController::class, 'ipn'])->name('payment.ipn');
Route::get('/payment/receipt/{payment}', [PaymentController::class, 'receipt'])->name('payment.receipt');




/*
|--------------------------------------------------------------------------
| Patient Portal Routes
|--------------------------------------------------------------------------
*/

Route::prefix('patient')->name('patient.')->group(function () {
    Route::get('register', [PatientAuthController::class, 'showRegister'])->name('register');
    Route::post('register', [PatientAuthController::class, 'register'])->name('register.submit');
    Route::get('login', [PatientAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [PatientAuthController::class, 'login'])->name('login.submit');

    Route::middleware('patient.auth')->group(function () {
        Route::post('logout', [PatientAuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
        Route::get('appointments', [PatientDashboardController::class, 'appointments'])->name('appointments');
        Route::get('reports', [PatientDashboardController::class, 'reports'])->name('reports');
        Route::get('invoices', [PatientDashboardController::class, 'invoices'])->name('invoices');
        Route::get('profile', [PatientDashboardController::class, 'profile'])->name('profile');
        Route::put('profile', [PatientDashboardController::class, 'updateProfile'])->name('profile.update');
        Route::put('password', [PatientDashboardController::class, 'updatePassword'])->name('password.update');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');

    Route::middleware('admin.auth')->group(function () {

        // Dashboard
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        //doctors
        Route::resource('doctors', AdminDoctorController::class)->except('show');
        Route::get('doctors/{doctor}/schedule', [DoctorScheduleController::class, 'index'])->name('doctors.schedule');
        Route::post('doctors/{doctor}/schedule', [DoctorScheduleController::class, 'store'])->name('doctors.schedule.store');
        Route::delete('doctors/{doctor}/schedule/{schedule}', [DoctorScheduleController::class, 'destroy'])->name('doctors.schedule.destroy');
        Route::patch('doctors/{doctor}/schedule/{schedule}/toggle', [DoctorScheduleController::class, 'toggleActive'])->name('doctors.schedule.toggle');
        Route::post('doctors/{doctor}/leave', [DoctorScheduleController::class, 'storeLeave'])->name('doctors.leave.store');
        Route::delete('doctors/{doctor}/leave/{leave}', [DoctorScheduleController::class, 'destroyLeave'])->name('doctors.leave.destroy');

        //show
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


        //appointments
        Route::get('appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
        Route::patch('appointments/{appointment}', [AdminAppointmentController::class, 'update'])->name('appointments.update');
        Route::delete('appointments/{appointment}', [AdminAppointmentController::class, 'destroy'])->name('appointments.destroy');

        //medicine
        Route::resource('medicines', AdminMedicineController::class)->except('show');
        Route::get('medicine-sales', [MedicineSaleController::class, 'index'])->name('medicine-sales.index');
        Route::get('medicine-sales/create', [MedicineSaleController::class, 'create'])->name('medicine-sales.create');
        Route::post('medicine-sales', [MedicineSaleController::class, 'store'])->name('medicine-sales.store');
        Route::get('medicine-sales/{medicine_sale}', [MedicineSaleController::class, 'show'])->name('medicine-sales.show');

        //ambulance
        Route::resource('ambulances', AdminAmbulanceController::class)->except('show');
        Route::get('ambulance-requests', [AdminAmbulanceRequestController::class, 'index'])->name('ambulance-requests.index');
        Route::put('ambulance-requests/{ambulance_request}', [AdminAmbulanceRequestController::class, 'update'])->name('ambulance-requests.update');
        Route::delete('ambulance-requests/{ambulance_request}', [AdminAmbulanceRequestController::class, 'destroy'])->name('ambulance-requests.destroy');

        //messages
        Route::get('messages', [AdminMessageController::class, 'index'])->name('messages.index');
        Route::patch('messages/{message}/read', [AdminMessageController::class, 'markRead'])->name('messages.read');
        Route::delete('messages/{message}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');

        //settings
        Route::get('settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');

        //showcase
        Route::resource('showcase-items', ShowcaseItemController::class)->except('show');


        //backups
        Route::get('backups', [BackupController::class, 'index'])->name('backups.index');
        Route::post('backups', [BackupController::class, 'create'])->name('backups.create');
        Route::get('backups/{filename}/download', [BackupController::class, 'download'])->name('backups.download');
        Route::delete('backups/{filename}', [BackupController::class, 'destroy'])->name('backups.destroy');

        //online reports
        Route::resource('online-reports', AdminOnlineReportController::class)->except('show');


        //comments
        Route::get('comments', [AdminCommentController::class, 'index'])->name('comments.index');
        Route::post('comments/{comment}/reply', [AdminCommentController::class, 'reply'])->name('comments.reply');
        Route::patch('comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
        Route::patch('comments/{comment}/reject', [AdminCommentController::class, 'reject'])->name('comments.reject');
        Route::delete('comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');

        //bed availability
        Route::get('bed-categories', [AdminBedCategoryController::class, 'index'])->name('bed-categories.index');
        Route::post('bed-categories', [AdminBedCategoryController::class, 'store'])->name('bed-categories.store');
        Route::put('bed-categories/{bed_category}', [AdminBedCategoryController::class, 'update'])->name('bed-categories.update');
        Route::delete('bed-categories/{bed_category}', [AdminBedCategoryController::class, 'destroy'])->name('bed-categories.destroy');


        //queue displays
        Route::get('queue-displays', [AdminQueueDisplayController::class, 'index'])->name('queue-displays.index');
        Route::put('queue-displays/{doctor}', [AdminQueueDisplayController::class, 'update'])->name('queue-displays.update');


        //blood bank
        Route::get('blood-donors', [AdminBloodBankController::class, 'donors'])->name('blood-donors.index');
        Route::patch('blood-donors/{donor}/verify', [AdminBloodBankController::class, 'toggleVerified'])->name('blood-donors.verify');
        Route::patch('blood-donors/{donor}/available', [AdminBloodBankController::class, 'toggleAvailable'])->name('blood-donors.available');
        Route::delete('blood-donors/{donor}', [AdminBloodBankController::class, 'destroyDonor'])->name('blood-donors.destroy');


        //blood requests
        Route::get('blood-requests', [AdminBloodBankController::class, 'requests'])->name('blood-requests.index');
        Route::patch('blood-requests/{request}/fulfill', [AdminBloodBankController::class, 'toggleFulfilled'])->name('blood-requests.fulfill');
        Route::delete('blood-requests/{request}', [AdminBloodBankController::class, 'destroyRequest'])->name('blood-requests.destroy');


        //notifications
        Route::get('notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
        Route::get('notifications/recent', [AdminNotificationController::class, 'recent'])->name('notifications.recent');
        Route::post('notifications/mark-all-read', [AdminNotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
        Route::get('notifications/{notification}/read', [AdminNotificationController::class, 'markRead'])->name('notifications.read');


        //hospital stats
        Route::resource('hospital-stats', HospitalStatController::class)->except('show');
        Route::get('hospital-stats-reports', [HospitalReportController::class, 'index'])->name('hospital-stats.reports');


        //invoices
        Route::resource('invoices', InvoiceController::class);
        Route::get('invoices/{invoice}/pdf', [InvoicePdfController::class, 'download'])->name('invoices.pdf');


        //payments
        Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments.index');


        //about
        Route::get('about-content', [AboutContentController::class, 'edit'])->name('about-content.edit');
        Route::put('about-content', [AboutContentController::class, 'update'])->name('about-content.update');
        Route::resource('accreditations', AccreditationController::class)->except('show');


        //pages
        Route::resource('pages', AdminPageController::class)->except('show');


        //video consultations
        Route::get('video-consultations', [AdminVideoConsultationController::class, 'index'])->name('video-consultations.index');
        Route::get('video-consultations/{video_consultation}/edit', [AdminVideoConsultationController::class, 'edit'])->name('video-consultations.edit');
        Route::put('video-consultations/{video_consultation}', [AdminVideoConsultationController::class, 'update'])->name('video-consultations.update');
        Route::delete('video-consultations/{video_consultation}', [AdminVideoConsultationController::class, 'destroy'])->name('video-consultations.destroy');


        //job postings
        Route::resource('job-postings', AdminJobPostingController::class)->except('show');

        //job applications
        Route::get('job-applications', [JobApplicationController::class, 'index'])->name('job-applications.index');
        Route::patch('job-applications/{job_application}', [JobApplicationController::class, 'updateStatus'])->name('job-applications.update');
        Route::delete('job-applications/{job_application}', [JobApplicationController::class, 'destroy'])->name('job-applications.destroy');


        //notices
        Route::resource('notices', AdminNoticeController::class)->except('show');


        // শুধু Super Admin access করতে পারবে
        Route::middleware('admin.role:super_admin')->group(function () {
            Route::resource('branches', BranchController::class)->except('show');
            Route::resource('admin-users', AdminUserController::class)->except('show');
        });
    });
});
