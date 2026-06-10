<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Instruktur\ClassController as InstruktorClassController;
use App\Http\Controllers\Instruktur\ClassStreamController as InstruktorClassStreamController;
use App\Http\Controllers\Instruktur\MaterialController as InstruktorMaterialController;
use App\Http\Controllers\Instruktur\AnnouncementController as InstruktorAnnouncementController;
use App\Http\Controllers\Instruktur\AssignmentController as InstruktorAssignmentController;
use App\Http\Controllers\Instruktur\AttendanceController as InstrukturAttendanceController;
use App\Http\Controllers\Peserta\ClassController as PesertaClassController;
use App\Http\Controllers\Peserta\ClassStreamController as PesertaClassStreamController;
use App\Http\Controllers\Peserta\MaterialController as PesertaMaterialController;
use App\Http\Controllers\Peserta\AssignmentController as PesertaAssignmentController;
use App\Http\Controllers\Peserta\AttendanceController as PesertaAttendanceController;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/dashboard', function () {

    $user = auth()->user();

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'instruktur' => redirect()->route('instruktur.dashboard'),
        'peserta' => redirect()->route('peserta.dashboard'),
        default => redirect('/'),
    };

})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role.check:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get(
            '/dashboard',
            [DashboardController::class, 'index']
        )->name('dashboard');

        Route::resource('users', UserController::class);

        Route::patch(
        'users/{user}/status',
        [UserController::class, 'updateStatus']
        )->name('users.update-status');

        Route::resource('programs', ProgramController::class);

        Route::resource('classes', ClassController::class);

    });

/*
|--------------------------------------------------------------------------
| Instructor Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role.check:instruktur'])
    ->prefix('instruktur')
    ->name('instruktur.')
    ->group(function () {

        Route::view(
            '/dashboard',
            'dashboard.instruktur'
        )->name('dashboard');

        Route::get('/classes', [InstruktorClassController::class, 'index'])
            ->name('classes.index');

        Route::get('/classes/{class}/stream', [InstruktorClassStreamController::class, 'stream'])
            ->name('classes.stream');

        Route::get('/classes/{class}/add-student', [InstruktorClassController::class, 'addStudentForm'])
            ->name('classes.add-student');

        Route::post('/classes/{class}/add-student', [InstruktorClassController::class, 'addStudent'])
            ->name('classes.add-student.store');

        Route::delete('/classes/{class}/participants/{participant}', [InstruktorClassController::class, 'removeStudent'])
            ->name('classes.remove-student');

        Route::patch('/classes/{class}/participants/{participant}/status', [InstruktorClassController::class, 'updateStudentStatus'])
            ->name('classes.update-student-status');

        // Materials Routes
        Route::get('/classes/{class}/materials', [InstruktorMaterialController::class, 'index'])
            ->name('materials.index');

        Route::get('/classes/{class}/materials/create', [InstruktorMaterialController::class, 'create'])
            ->name('materials.create');

        Route::post('/classes/{class}/materials', [InstruktorMaterialController::class, 'store'])
            ->name('materials.store');

        Route::get('/classes/{class}/materials/{material}', [InstruktorMaterialController::class, 'show'])
            ->name('materials.show');

        Route::get('/classes/{class}/materials/{material}/edit', [InstruktorMaterialController::class, 'edit'])
            ->name('materials.edit');

        Route::put('/classes/{class}/materials/{material}', [InstruktorMaterialController::class, 'update'])
            ->name('materials.update');

        Route::delete('/classes/{class}/materials/{material}', [InstruktorMaterialController::class, 'destroy'])
            ->name('materials.destroy');

        // Announcement Routes
        Route::post('/classes/{class}/announcements', [InstruktorAnnouncementController::class, 'store'])
            ->name('announcements.store');

        Route::get('/classes/{class}/announcements/{announcement}/edit', [InstruktorAnnouncementController::class, 'edit'])
            ->name('announcements.edit');

        Route::put('/classes/{class}/announcements/{announcement}', [InstruktorAnnouncementController::class, 'update'])
            ->name('announcements.update');

        Route::delete('/classes/{class}/announcements/{announcement}', [InstruktorAnnouncementController::class, 'destroy'])
            ->name('announcements.destroy');

        // Assignment Routes
        Route::get('/classes/{class}/assignments/create', [InstruktorAssignmentController::class, 'create'])
            ->name('assignments.create');

        Route::post('/classes/{class}/assignments', [InstruktorAssignmentController::class, 'store'])
            ->name('assignments.store');

        Route::get('/classes/{class}/assignments/{assignment}/edit', [InstruktorAssignmentController::class, 'edit'])
            ->name('assignments.edit');

        Route::put('/classes/{class}/assignments/{assignment}', [InstruktorAssignmentController::class, 'update'])
            ->name('assignments.update');

        Route::delete('/classes/{class}/assignments/{assignment}', [InstruktorAssignmentController::class, 'destroy'])
            ->name('assignments.destroy');

        // Attendance Routes (di dalam group instruktur)
       Route::get('/classes/{class}/attendances', [InstrukturAttendanceController::class, 'index'])->name('attendances.index');
Route::get('/classes/{class}/attendances/create', [InstrukturAttendanceController::class, 'create'])->name('attendances.create');
Route::post('/classes/{class}/attendances', [InstrukturAttendanceController::class, 'store'])->name('attendances.store');
Route::get('/classes/{class}/attendances/{meetingNumber}', [InstrukturAttendanceController::class, 'show'])->name('attendances.show');
Route::get('/classes/{class}/attendances/{meetingNumber}/edit', [InstrukturAttendanceController::class, 'edit'])->name('attendances.edit');
Route::put('/classes/{class}/attendances/{meetingNumber}', [InstrukturAttendanceController::class, 'update'])->name('attendances.update');
Route::delete('/classes/{class}/attendances/{meetingNumber}', [InstrukturAttendanceController::class, 'destroy'])->name('attendances.destroy');
Route::get('/classes/{class}/attendances-report', [InstrukturAttendanceController::class, 'report'])->name('attendances.report');
    });

/*
|--------------------------------------------------------------------------
| Participant Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role.check:peserta'])
    ->prefix('peserta')
    ->name('peserta.')
    ->group(function () {

        Route::get(
            '/dashboard',
            [PesertaClassController::class, 'index']
        )->name('dashboard');

        Route::get('/classes', [PesertaClassController::class, 'index'])
            ->name('classes.index');

        Route::get('/classes/{class}', [PesertaClassController::class, 'show'])
            ->name('classes.show');

        Route::get('/classes/{class}/stream', [PesertaClassStreamController::class, 'stream'])
            ->name('classes.stream');

        // Materials Routes
        Route::get('/classes/{class}/materials', [PesertaMaterialController::class, 'index'])
            ->name('materials.index');

        Route::get('/classes/{class}/materials/{material}', [PesertaMaterialController::class, 'show'])
            ->name('materials.show');

        // Assignment Routes
        Route::get('/classes/{class}/assignments/{assignment}', [PesertaAssignmentController::class, 'show'])
            ->name('assignments.show');
        
        //Attendance Routes
        Route::get('/classes/{class}/attendances', [PesertaAttendanceController::class, 'index'])->name('attendances.index');
        Route::get('/classes/{class}/attendances/{meetingNumber}', [PesertaAttendanceController::class, 'show'])->name('attendances.show');
        Route::post('/classes/{class}/attendances/{meetingNumber}/submit', [PesertaAttendanceController::class, 'submit'])->name('attendances.submit');

    });

/*
|--------------------------------------------------------------------------
| Forgot Password (Email + NIK)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get(
        '/forgot-password-custom',
        [ForgotPasswordController::class, 'create']
    )->name('password.request.custom');

    Route::post(
        '/forgot-password-custom',
        [ForgotPasswordController::class, 'verify']
    )->name('password.verify.custom');

    Route::get(
        '/reset-password-custom',
        [ForgotPasswordController::class, 'showResetForm']
    )->name('password.form');

    Route::post(
        '/reset-password-custom',
        [ForgotPasswordController::class, 'resetPassword']
    )->name('password.reset.custom');
});

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::patch(
        '/profile/password',
        [ProfileController::class, 'updatePassword']
    )->name('profile.password');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});
require __DIR__.'/auth.php';