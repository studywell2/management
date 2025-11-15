<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TeacherAttendanceController;

// ---------------- Public Routes ----------------
Route::get('/', fn() => view('welcome'));
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ---------------- Authenticated Routes ----------------
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Chatbox (make sure this is outside nested groups)

Route::middleware(['auth'])->group(function () {
    // other dashboard routes...

    // Chatbox routes
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/ask', [ChatController::class, 'ask'])->name('chat.ask');
});


    // School
    Route::get('/school', [SchoolController::class, 'create'])->name('school.create');
    Route::post('/school', [SchoolController::class, 'store'])->name('school.store');

    // Students
    Route::resource('students', StudentController::class);

    // Teachers
    Route::prefix('teachers')->name('teachers.')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index');
        Route::get('/create', [TeacherController::class, 'create'])->name('create');
        Route::post('/', [TeacherController::class, 'store'])->name('store');
        Route::get('/{teacher}/edit', [TeacherController::class, 'edit'])->name('edit');
        Route::put('/{teacher}', [TeacherController::class, 'update'])->name('update');
        Route::delete('/{teacher}', [TeacherController::class, 'destroy'])->name('destroy');

        // Teacher Attendance
Route::get('/{teacherId}/attendance', [TeacherController::class, 'attendanceForm'])
        ->name('attendance.form');

    Route::post('/{teacherId}/attendance', [TeacherController::class, 'attendance'])
        ->name('attendance');
    });

    // Classes
    Route::resource('classes', ClassController::class);

    // Subjects
    Route::resource('subjects', SubjectController::class);

    // Results
    Route::prefix('results')->name('results.')->group(function () {
        Route::get('/', [ResultController::class, 'index'])->name('index');
        Route::get('/create', [ResultController::class, 'create'])->name('create');
        Route::post('/', [ResultController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ResultController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ResultController::class, 'update'])->name('update');
        Route::delete('/{id}', [ResultController::class, 'destroy'])->name('destroy');
        Route::get('/export', [ResultController::class, 'export'])->name('export');
        Route::get('/print-all', [ResultController::class, 'printAll'])->name('printAll');
        Route::get('/print-student/{student_id}', [ResultController::class, 'printStudent'])->name('printStudent');
    });

    // Payments
    Route::get('/pay', [PaymentController::class, 'showForm'])->name('payment.form');
    Route::post('/pay', [PaymentController::class, 'initiate'])->name('payment.initiate');
    Route::get('/pay/callback', [PaymentController::class, 'callback'])->name('payment.callback');
});
