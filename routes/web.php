<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Instruktur\ClassController as InstruktorClassController;
use App\Http\Controllers\Instruktur\ClassStreamController as InstruktorClassStreamController;
use App\Http\Controllers\Instruktur\MaterialController as InstruktorMaterialController;
use App\Http\Controllers\Instruktur\AnnouncementController as InstruktorAnnouncementController;
use App\Http\Controllers\Instruktur\AssignmentController as InstruktorAssignmentController;
use App\Http\Controllers\Instruktur\AttendanceController as InstrukturAttendanceController;
use App\Http\Controllers\Instruktur\GradeController as InstrukturGradeController;
use App\Http\Controllers\Instruktur\CertificateController as InstrukturCertificateController;
use App\Http\Controllers\Instruktur\DashboardController as InstrukturDashboardController;
use App\Http\Controllers\Peserta\DashboardController as PesertaDashboardController;
use App\Http\Controllers\Peserta\ClassController as PesertaClassController;
use App\Http\Controllers\Peserta\ClassStreamController as PesertaClassStreamController;
use App\Http\Controllers\Peserta\MaterialController as PesertaMaterialController;
use App\Http\Controllers\Peserta\AssignmentController as PesertaAssignmentController;
use App\Http\Controllers\Peserta\AttendanceController as PesertaAttendanceController;
use App\Http\Controllers\Peserta\SubmissionController as PesertaSubmissionController;
use App\Http\Controllers\Peserta\CertificateController as PesertaCertificateController;
use App\Http\Controllers\CertificateVerifyController;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/verify/certificate/{number}', [CertificateVerifyController::class, 'show'])->name('certificates.verify');

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

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', UserController::class);
        Route::patch('users/{user}/status', [UserController::class, 'updateStatus'])->name('users.update-status');

        Route::resource('programs', ProgramController::class);
        Route::get('classes/preview-code', [ClassController::class, 'previewCode'])->name('classes.preview-code');
        Route::resource('classes', ClassController::class);

        Route::get('/announcements', [AdminAnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('/classes/{class}/announcements', [AdminAnnouncementController::class, 'show'])->name('announcements.show');
        Route::post('/classes/{class}/announcements', [AdminAnnouncementController::class, 'store'])->name('announcements.store');
        Route::put('/classes/{class}/announcements/{announcement}', [AdminAnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('/classes/{class}/announcements/{announcement}', [AdminAnnouncementController::class, 'destroy'])->name('announcements.destroy');

        Route::get('/certificates', [AdminCertificateController::class, 'index'])->name('certificates.index');
        Route::get('/classes/{class}/certificates', [AdminCertificateController::class, 'show'])->name('certificates.show');
        Route::post('/classes/{class}/certificates/statuses', [AdminCertificateController::class, 'saveStatuses'])->name('certificates.save-statuses');
        Route::post('/classes/{class}/certificates/bulk-issue', [AdminCertificateController::class, 'bulkIssue'])->name('certificates.bulk-issue');
        Route::get('/classes/{class}/certificates/export', [AdminCertificateController::class, 'exportExcel'])->name('certificates.export');
        Route::get('/certificates/{certificate}/download', [AdminCertificateController::class, 'download'])->name('certificates.download');
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

        // Dashboard dinamis
        Route::get('/dashboard', [InstrukturDashboardController::class, 'index'])->name('dashboard');

        // Classes
        Route::get('/classes', [InstruktorClassController::class, 'index'])->name('classes.index');
        Route::get('/classes/{class}/stream', [InstruktorClassStreamController::class, 'stream'])->name('classes.stream');
        Route::get('/classes/{class}/add-student', [InstruktorClassController::class, 'addStudentForm'])->name('classes.add-student');
        Route::post('/classes/{class}/add-student', [InstruktorClassController::class, 'addStudent'])->name('classes.add-student.store');
        Route::delete('/classes/{class}/participants/{participant}', [InstruktorClassController::class, 'removeStudent'])->name('classes.remove-student');
        Route::patch('/classes/{class}/participants/{participant}/status', [InstruktorClassController::class, 'updateStudentStatus'])->name('classes.update-student-status');

        // Materials
        Route::get('/classes/{class}/materials', [InstruktorMaterialController::class, 'index'])->name('materials.index');
        Route::get('/classes/{class}/materials/create', [InstruktorMaterialController::class, 'create'])->name('materials.create');
        Route::post('/classes/{class}/materials', [InstruktorMaterialController::class, 'store'])->name('materials.store');
        Route::get('/classes/{class}/materials/{material}', [InstruktorMaterialController::class, 'show'])->name('materials.show');
        Route::get('/classes/{class}/materials/{material}/edit', [InstruktorMaterialController::class, 'edit'])->name('materials.edit');
        Route::put('/classes/{class}/materials/{material}', [InstruktorMaterialController::class, 'update'])->name('materials.update');
        Route::delete('/classes/{class}/materials/{material}', [InstruktorMaterialController::class, 'destroy'])->name('materials.destroy');

        // Announcements
        Route::post('/classes/{class}/announcements', [InstruktorAnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('/classes/{class}/announcements/{announcement}/edit', [InstruktorAnnouncementController::class, 'edit'])->name('announcements.edit');
        Route::put('/classes/{class}/announcements/{announcement}', [InstruktorAnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('/classes/{class}/announcements/{announcement}', [InstruktorAnnouncementController::class, 'destroy'])->name('announcements.destroy');

        // Assignments (CRUD)
        Route::get('/classes/{class}/assignments/create', [InstruktorAssignmentController::class, 'create'])->name('assignments.create');
        Route::post('/classes/{class}/assignments', [InstruktorAssignmentController::class, 'store'])->name('assignments.store');
        Route::get('/classes/{class}/assignments/{assignment}/edit', [InstruktorAssignmentController::class, 'edit'])->name('assignments.edit');
        Route::put('/classes/{class}/assignments/{assignment}', [InstruktorAssignmentController::class, 'update'])->name('assignments.update');
        Route::delete('/classes/{class}/assignments/{assignment}', [InstruktorAssignmentController::class, 'destroy'])->name('assignments.destroy');

        // Grading (nilai assignment)
        Route::get('/classes/{class}/assignments/{assignment}/grades', [InstrukturGradeController::class, 'index'])->name('grades.index');
        Route::get('/classes/{class}/assignments/{assignment}/grades/{submission}', [InstrukturGradeController::class, 'show'])->name('grades.show');
        Route::post('/classes/{class}/assignments/{assignment}/grades/{submission}', [InstrukturGradeController::class, 'storeGrade'])->name('grades.store');

        // Attendance
        Route::get('/classes/{class}/attendances', [InstrukturAttendanceController::class, 'index'])->name('attendances.index');
        Route::get('/classes/{class}/attendances/create', [InstrukturAttendanceController::class, 'create'])->name('attendances.create');
        Route::post('/classes/{class}/attendances', [InstrukturAttendanceController::class, 'store'])->name('attendances.store');
        Route::get('/classes/{class}/attendances/{meetingNumber}', [InstrukturAttendanceController::class, 'show'])->name('attendances.show');
        Route::get('/classes/{class}/attendances/{meetingNumber}/edit', [InstrukturAttendanceController::class, 'edit'])->name('attendances.edit');
        Route::put('/classes/{class}/attendances/{meetingNumber}', [InstrukturAttendanceController::class, 'update'])->name('attendances.update');
        Route::delete('/classes/{class}/attendances/{meetingNumber}', [InstrukturAttendanceController::class, 'destroy'])->name('attendances.destroy');
        Route::get('/classes/{class}/attendances-report', [InstrukturAttendanceController::class, 'report'])->name('attendances.report');

        Route::get('/certificates', [InstrukturCertificateController::class, 'index'])->name('certificates.index');
        Route::get('/classes/{class}/certificates', [InstrukturCertificateController::class, 'show'])->name('certificates.show');
        Route::post('/classes/{class}/certificates/statuses', [InstrukturCertificateController::class, 'saveStatuses'])->name('certificates.save-statuses');
        Route::post('/classes/{class}/certificates/bulk-issue', [InstrukturCertificateController::class, 'bulkIssue'])->name('certificates.bulk-issue');
        Route::get('/classes/{class}/certificates/export', [InstrukturCertificateController::class, 'exportExcel'])->name('certificates.export');
        Route::get('/certificates/{certificate}/download', [InstrukturCertificateController::class, 'download'])->name('certificates.download');
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

        // Dashboard (sama dengan daftar kelas)
        Route::get('/dashboard', [PesertaDashboardController::class, 'index'])->name('dashboard');

        // Classes
        Route::get('/classes', [PesertaClassController::class, 'index'])->name('classes.index');
        Route::get('/classes/{class}', [PesertaClassController::class, 'show'])->name('classes.show');
        Route::get('/classes/{class}/stream', [PesertaClassStreamController::class, 'stream'])->name('classes.stream');

        // Materials
        Route::get('/classes/{class}/materials', [PesertaMaterialController::class, 'index'])->name('materials.index');
        Route::get('/classes/{class}/materials/{material}', [PesertaMaterialController::class, 'show'])->name('materials.show');

        // Assignments (daftar assignment dan detail)
        Route::get('/classes/{class}/assignments', [PesertaAssignmentController::class, 'index'])->name('assignments.index');
        Route::get('/classes/{class}/assignments/{assignment}', [PesertaAssignmentController::class, 'show'])->name('assignments.show');

        // Submission (peserta mengumpulkan tugas)
        Route::get('/classes/{class}/assignments/{assignment}/submit', [PesertaSubmissionController::class, 'create'])->name('submissions.create');
        Route::post('/classes/{class}/assignments/{assignment}/submit', [PesertaSubmissionController::class, 'store'])->name('submissions.store');
        Route::get('/classes/{class}/assignments/{assignment}/submissions/{submission}/edit', [PesertaSubmissionController::class, 'edit'])->name('submissions.edit');
        Route::put('/classes/{class}/assignments/{assignment}/submissions/{submission}', [PesertaSubmissionController::class, 'update'])->name('submissions.update');
        Route::delete('/classes/{class}/assignments/{assignment}/submissions/{submission}', [PesertaSubmissionController::class, 'destroy'])->name('submissions.destroy');

        // Attendance
        Route::get('/classes/{class}/attendances', [PesertaAttendanceController::class, 'index'])->name('attendances.index');
        Route::get('/classes/{class}/attendances/{meetingNumber}', [PesertaAttendanceController::class, 'show'])->name('attendances.show');
        Route::post('/classes/{class}/attendances/{meetingNumber}/submit', [PesertaAttendanceController::class, 'submit'])->name('attendances.submit');

        Route::get('/certificates', [PesertaCertificateController::class, 'index'])->name('certificates.index');
        Route::get('/certificates/{certificate}/download', [PesertaCertificateController::class, 'download'])->name('certificates.download');
    });

/*
|--------------------------------------------------------------------------
| Forgot Password (Email + NIK)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/forgot-password-custom', [ForgotPasswordController::class, 'create'])->name('password.request.custom');
    Route::post('/forgot-password-custom', [ForgotPasswordController::class, 'verify'])->name('password.verify.custom');
    Route::get('/reset-password-custom', [ForgotPasswordController::class, 'showResetForm'])->name('password.form');
    Route::post('/reset-password-custom', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset.custom');
});

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';