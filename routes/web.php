<?php

use App\Models\occupancy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ajaxController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\PatienController;
use App\Http\Controllers\reportController;
use App\Http\Controllers\MedicalController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\OccupancyController;
use App\Http\Controllers\DailyVisitController;
use App\Http\Controllers\settings\RoleController;
use App\Http\Controllers\settings\userController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\UserPreferenceController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\DailyVisitPatientController;
use Symfony\Component\HttpKernel\DataCollector\AjaxDataCollector;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();



Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [BillingController::class, 'create'])->name('home');
    Route::get('/', [BillingController::class, 'create'])->name('dashbord');
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    //Route::get('/print', [App\Http\Controllers\HomeController::class, 'print'])->name('print');

    Route::post('ui/theme', [UserPreferenceController::class, 'updateTheme'])->name('ui.theme');
    Route::post('ui/status', [UserPreferenceController::class, 'updateStatus'])->name('ui.status');

    Route::get('ajax/patient', [ajaxController::class, 'getPetion'])->name('ajax.getPetion');
    Route::get('ajax/guardiants', [ajaxController::class, 'getGuardiants'])->name('ajax.guardiants');
    Route::get('ajax/room', [ajaxController::class, 'roomItems'])->name('ajax.room-item');
    Route::get('ajax/admission', [ajaxController::class, 'admissionItems'])->name('ajax.admission-item');





    Route::resource('patient', \App\Http\Controllers\PatientController::class);
    Route::resource('billing', BillingController::class);
    Route::post('billing/save-client-details', [BillingController::class, 'saveClientDetails'])->name('billing.save-client-details');
    Route::post('billing/{id}/email', [BillingController::class, 'emailBill'])->name('billing.email');
    Route::resource('doctor', DoctorController::class);
    Route::get('ajax/petdetails', [ajaxController::class, 'getPatientDetails'])->name('ajax.getPetDetails');
    Route::get('billing/print/{id}', [BillingController::class, 'print'])->name('billing.print');
    Route::get('billing/print-prescription/{id}', [BillingController::class, 'printPrescription'])->name('billing.print-prescription');
    Route::get('/autocomplete/drugs', [DrugController::class, 'autocomplete']);
    Route::get('/get-service-price/{id}', [ServiceController::class, 'getServicePrice']);
    Route::get('/get-treatment-details', [TreatmentController::class, 'getTreatmentDetails']);

    Route::get('/medical-history/{id}', [TreatmentController::class, 'show'])->name('medical-history.show');



    // Route::get('admission/{id}/editt', [AdmissionController::class,'edit'])->name('admission.editt');
    // Route::get('admission/{id}/editt', [AdmissionController::class, function ($id) {
    //     dd($id);
    // }])->name('admission.editt');

    Route::get('/visit/{id}', [DailyVisitPatientController::class, 'getVisitDetails']);

    Route::prefix('patient/{patient}')->group(function () {
        Route::resource('visit', DailyVisitPatientController::class);
    });

    Route::put('admission/checkout', [AdmissionController::class, 'checkout'])->name('admission.checkout');
    Route::get('/admission/checkout/{id}', [AdmissionController::class, 'getCheckoutInformation'])->name('admission.checkout-information');
    Route::get('admission/checkout', [AdmissionController::class, 'checkoutList'])->name('admission.checkout-list');
    Route::get('/admission/undocheckout/{id}', [AdmissionController::class, 'undoCheckout'])->name('admission.undo-discharge');
    // Route::get('admission/room-occupancey', [AdmissionController::class, 'roomOccupancey'])->name('admission.room-occupancey');
    Route::resource('admission', AdmissionController::class);
    Route::get('admission/{id}', [AdmissionController::class, 'show'])->name('admission.show');


    Route::resource('occupancy', OccupancyController::class);
    // Route::get('occupancy/show/{id}', [OccupancyController::class, 'show'])->name('occupancy.show');
    // Route::get('admission/{id}', [AdmissionController::class, 'show'])->name('admission.show');



    Route::prefix('admission/{admission}')->group(function () {
        Route::resource('medical', MedicalController::class);
        Route::resource('daily-visit', DailyVisitController::class);
    });
    // Route::resource('admission/{admission}/medical',MedicalController::class);
    // Route::resource('admission/{admission}/daily-visit',dailyVisit::class);

    Route::prefix('reports')->group(function () {

        // Route::get('age-group', [reportController::class, 'age_group'])->name('report.age-group');
        // Route::get('district-wise', [reportController::class, 'districtWise'])->name('report.district-wise');
        // Route::get('province-wise', [reportController::class, 'provinceWise'])->name('report.province-wise');
        Route::get('monthly-report', [reportController::class, 'monthlyReport'])->name('report.monthly-report');
        Route::get('monthly-report-data', [reportController::class, 'billingReport'])->name('report.monthly-report-data');
        Route::get('doctor-report', [reportController::class, 'doctorReport'])->name('report.doctor-report');
        Route::get('doctor-report/{doctor}', [reportController::class, 'doctorReportDetail'])->name('report.doctor-report-detail');
        // Route::get('served-periodes', [reportController::class, 'serve'])->name('report.served-periodes');
        Route::get('served-periodes', [reportController::class, 'servedPeriodes'])->name('report.served-periodes');
        Route::get('served-periodes-data', [reportController::class, 'servedPeriodesReport'])->name('report.served-periodes-data');
        Route::get('upcoming-discharges', [reportController::class, 'upcomingDischarges'])->name('report.upcoming-discharges');
        Route::get('upcoming-discharges-data', [reportController::class, 'upcomingDischargesReport'])->name('report.upcoming-discharges-data');
        Route::get('district-admissions', [reportController::class, 'districtAdmissionsReport'])->name('report.district-admissions');
        Route::post('district-admissions-search', [reportController::class, 'districtAdmissionsSearchReport'])->name('report.district-admissions-search');
        Route::get('avg-len-of-stay', [reportController::class, 'avgLenOfStayReport'])->name('report.avg-len-of-stay');
        Route::get('avg-len-of-stay-search', [reportController::class, 'avgLenOfStayReport'])->name('report.avg-len-of-stay-search');
        Route::post('avg-len-of-stay-search', [reportController::class, 'avgLenOfStaySearchReport'])->name('report.avg-len-of-stay-search');

        Route::get('admission-chart', [reportController::class, 'admissionChart'])->name('report.admission-chart');
        Route::post('admission-chart-data', [reportController::class, 'getAdmissionData'])->name('reports.admissionChartData');

    });

    Route::prefix('patient-reports')->group(function () {

        Route::get('age-group', [reportController::class, 'age_group'])->name('report.age-group');
        Route::get('district-wise', [reportController::class, 'districtWise'])->name('report.district-wise');
        Route::get('province-wise', [reportController::class, 'provinceWise'])->name('report.province-wise');


    });



    Route::prefix('settings')->group(function () {

        Route::resource('room', RoomController::class);
        Route::resource('item', ItemController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('drug', DrugController::class);

        Route::post('/change-password', [ChangePasswordController::class, 'store'])->name('change.password');
        Route::get('/users/profile/', [userController::class, 'profile'])->name('users.profile');
        Route::get('/users/react/{id}', [userController::class, 'react'])->name('users.activate');
        Route::get('/users/suspendusers/', [userController::class, 'suspendusers'])->name('users.suspendusers');
        Route::get('/users/resetpass/{user}', [userController::class, 'resetpass'])->name('users.resetpass');
        Route::resource('users', userController::class);

        Route::resource('role', RoleController::class);
        Route::get('reminders', [\App\Http\Controllers\ReminderSettingsController::class, 'index'])->name('settings.reminders.index');
        Route::post('reminders', [\App\Http\Controllers\ReminderSettingsController::class, 'update'])->name('settings.reminders.update');
    });


});
