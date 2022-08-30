<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $doctors=\App\Models\Doctor::all();
    return view('welcome',['doctors'=>$doctors]);
});
Route::group(['prefix'=>'patient'],function(){
    Auth::routes();
    Route::group(['middleware'=>'auth'],function(){
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/make_appointment_view', [App\Http\Controllers\HomeController::class, 'appointmentView']);
        Route::post('/appointment', [App\Http\Controllers\HomeController::class, 'appointment']);
        Route::get('/myappointment', [App\Http\Controllers\HomeController::class, 'myappointment']);
        Route::get('/cancel_appoint/{id}', [App\Http\Controllers\HomeController::class, 'cancelappoint']);
        Route::get('/viewreports', [App\Http\Controllers\HomeController::class, 'viewreports']);
        Route::post('/user/logout', [App\Http\Controllers\Auth\LoginController::class, 'userLogout'])->name('user.logout');
    });
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::post('/user/logout', [App\Http\Controllers\Auth\LoginController::class, 'userLogout'])->name('user.logout');

Route::group(['prefix'=>'admin'],function(){
    Route::group(['middleware'=>'guest:admin'],function(){
        Route::view('/register','admin.register')->name('admin.register');
        Route::post('/register',[App\Http\Controllers\AdminController::class,'add'])->name('admin.add');
        Route::view('/login','admin.login')->name('admin.login');
        Route::post('/login',[App\Http\Controllers\AdminController::class,'authenticate'])->name('admin.authenticate');
    });
    Route::group(['middleware'=>'auth:admin'],function(){
        Route::get('/dashboard',[App\Http\Controllers\DashboardController::class,'dashboardAdmin'])->name('admin.dashboard');
        Route::get('/add_doctor_view',[App\Http\Controllers\AdminController::class,'addDoctorView']);
        Route::post('/upload_doctor',[App\Http\Controllers\AdminController::class,'upload'])->name('admin.upload_doctor');
        
        Route::get('/doctors',[App\Http\Controllers\AdminController::class,'index']);
        Route::get('/doctorget',[App\Http\Controllers\AdminController::class,'getDoctor'])->name('doctor.get');
        Route::post('/add-doctor',[App\Http\Controllers\AdminController::class,'addDoctor'])->name('doctor.addajax');
        Route::get('/doctors/{id}',[App\Http\Controllers\AdminController::class,'getDoctorById']);
        Route::put('/doctor',[App\Http\Controllers\AdminController::class,'updateDoctor'])->name('doctor.update');
        Route::delete('/doctor/{id}',[App\Http\Controllers\AdminController::class,'deleteDoctor'])->name('doctor.delete');
        Route::delete('/selected-doctors',[App\Http\Controllers\AdminController::class,'deleteCheckedDoctors'])->name('doctor.deleteSelected');
        
        Route::get('/add_medicine_view',[App\Http\Controllers\AdminController::class,'addMedicineView']);

        Route::get('/medicines',[App\Http\Controllers\AdminController::class,'indexMedicine']);
        Route::get('/medicineget',[App\Http\Controllers\AdminController::class,'getMedicine'])->name('medicine.get');
        Route::post('/add-medicine',[App\Http\Controllers\AdminController::class,'addMedicine'])->name('medicine.addajax');
        Route::get('/medicines/{id}',[App\Http\Controllers\AdminController::class,'getMedicineById']);
        Route::put('/medicine',[App\Http\Controllers\AdminController::class,'updateMedicine'])->name('medicine.update');
        Route::delete('/medicine/{id}',[App\Http\Controllers\AdminController::class,'deleteMedicine'])->name('medicine.delete');
        Route::delete('/selected-medicines',[App\Http\Controllers\AdminController::class,'deleteCheckedMedicines'])->name('medicine.deleteSelected');
        
        Route::get('/showappointments',[App\Http\Controllers\AdminController::class,'showappointments']);
        Route::get('/approved/{id}', [App\Http\Controllers\AdminController::class, 'approve']);
        Route::get('/canceled/{id}', [App\Http\Controllers\AdminController::class, 'cancel']);

        Route::get('/add_laboratory_view',[App\Http\Controllers\AdminController::class,'addLaboratoryView']);

        Route::get('/laboratorys',[App\Http\Controllers\AdminController::class,'indexLaboratory']);
        Route::get('/laboratoryget',[App\Http\Controllers\AdminController::class,'getLaboratory'])->name('laboratory.get');
        Route::post('/add-laboratory',[App\Http\Controllers\AdminController::class,'addLaboratory'])->name('laboratoryTech.addajax');
        Route::get('/laboratorys/{id}',[App\Http\Controllers\AdminController::class,'getLaboratoryById']);
        Route::put('/laboratory',[App\Http\Controllers\AdminController::class,'updateLaboratory'])->name('laboratory.update');
        Route::delete('/laboratory/{id}',[App\Http\Controllers\AdminController::class,'deleteLaboratory'])->name('laboratory.delete');
        Route::delete('/selected-laboratorys',[App\Http\Controllers\AdminController::class,'deleteCheckedLaboratorys'])->name('laboratory.deleteSelected');

        Route::post('/logout',[App\Http\Controllers\AdminController::class,'logout'])->name('admin.logout');
    });
});

Route::group(['prefix'=>'doctor'],function(){
    Route::group(['middleware'=>'guest:doctor'],function(){
        Route::view('/register','doctor.register')->name('doctor.register');
        Route::post('/register',[App\Http\Controllers\DoctorController::class,'add'])->name('doctor.add');
        Route::view('/login','doctor.login')->name('doctor.login');
        Route::post('/login',[App\Http\Controllers\DoctorController::class,'authenticate'])->name('doctor.authenticate');
    });
    Route::group(['middleware'=>'auth:doctor'],function(){
        Route::get('/dashboard',[App\Http\Controllers\DashboardController::class,'dashboardDoctor'])->name('doctor.dashboard');
        Route::get('/make_treatment_view', [App\Http\Controllers\DoctorController::class, 'treatmentView']);
        Route::post('/treatment', [App\Http\Controllers\DoctorController::class, 'treatment']);
        Route::get('/mytreatment', [App\Http\Controllers\DoctorController::class, 'mytreatment']);
        Route::get('/try', [App\Http\Controllers\DoctorController::class, 'try']);
        Route::post('/logout',[App\Http\Controllers\DoctorController::class,'logout'])->name('doctor.logout');
    });
});


Route::group(['prefix'=>'laboratory'],function(){
    Route::group(['middleware'=>'guest:laboratory'],function(){
        Route::view('/register','laboratory.register')->name('laboratory.register');
        Route::post('/register',[App\Http\Controllers\LaboratoryController::class,'add'])->name('laboratory.add');
        Route::view('/login','laboratory.login')->name('laboratory.login');
        Route::post('/login',[App\Http\Controllers\LaboratoryController::class,'authenticate'])->name('laboratory.authenticate');
    });
    Route::group(['middleware'=>'auth:laboratory'],function(){
        Route::get('/dashboard',[App\Http\Controllers\DashboardController::class,'dashboardLaboratory'])->name('laboratory.dashboard');
        Route::get('/make_reports_view', [App\Http\Controllers\LaboratoryController::class, 'reportsView']);
        Route::post('/reports', [App\Http\Controllers\LaboratoryController::class, 'reports']);
        Route::get('/myreports', [App\Http\Controllers\LaboratoryController::class, 'myreports']);
        Route::post('/logout',[App\Http\Controllers\LaboratoryController::class,'logout'])->name('laboratory.logout');
    });
});