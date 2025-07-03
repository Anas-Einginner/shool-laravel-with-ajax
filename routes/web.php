<?php

use App\Http\Controllers\DasboardTeachers\Lectures\LecturesController;
use App\Http\Controllers\DasboardTeachers\Quizzs\QuizzController;
use App\Http\Controllers\Grades\GradeController;
use App\Http\Controllers\Lectures\LectureController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sections\SectionController;
use App\Http\Controllers\Students\StudentController;
use App\Http\Controllers\Subjects\SubjectController;
use App\Http\Controllers\Teachers\TeacherController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});
//url : learnschool/dashboard/grades
// name : dash.grade.index
Route::prefix('learnschool/')->group(function () {
    Route::prefix('dashboard/')->middleware(['auth'])->name('dash.')->group(function () {
        // dashboard/teacher
        Route::middleware('admin')->group(function () {
            Route::prefix('grades/')->controller(GradeController::class)->name('grade.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/getdata', 'getdata')->name('getdata');
                Route::get('/getactive', 'getactive')->name('getactive');
                Route::get('/getactivesection', 'getactivesection')->name('getactive.section');
                Route::get('/getactivestage', 'getactivestage')->name('getactive.stage');
                Route::post('/add', 'add')->name('add');
                Route::post('/changemaster', 'changemaster')->name('changemaster');
                Route::post('/addsection', 'addsection')->name('addsection');
            });

            Route::prefix('teachers/')->controller(TeacherController::class)->name('teacher.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/getdata', 'getdata')->name('getdata');
                Route::post('/add', 'add')->name('add');
                Route::post('/update', 'update')->name('update');
                Route::post('/delete', 'delete')->name('delete');
                Route::post('/active', 'active')->name('active');
            });

            Route::prefix('lectures/')->controller(LectureController::class)->name('lecture.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/getdata', 'getdata')->name('getdata');
                Route::post('/add', 'add')->name('add');
                Route::post('/update', 'update')->name('update');
                Route::post('/delete', 'delete')->name('delete');
                Route::post('/active', 'active')->name('active');
            });


            Route::prefix('subjects/')->controller(SubjectController::class)->name('subject.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/getdata', 'getdata')->name('getdata');
                Route::get('/getdata/lectures', 'getdataLectures')->name('getdata.lectures');
                Route::get('/lectures/{id}', 'lectures')->name('lectures');
                Route::get('/download/{filename}', 'download')->name('download');
                Route::post('/add', 'add')->name('add');
                Route::post('/update', 'update')->name('update');
                Route::post('/delete', 'delete')->name('delete');
                Route::post('/active', 'active')->name('active');
            });

            Route::prefix('students/')->controller(StudentController::class)->name('student.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/getdata', 'getdata')->name('getdata');
                Route::get('/getdata/lectures', 'getdataLectures')->name('getdata.lectures');
                Route::get('/lectures/{id}', 'lectures')->name('lectures');
                Route::get('/download/{filename}', 'download')->name('download');
                Route::get('/export', 'export')->name('export');
                Route::post('/import', 'import')->name('import');
                Route::post('/add', 'add')->name('add');
                Route::post('/update', 'update')->name('update');
                Route::post('/delete', 'delete')->name('delete');
                Route::post('/active', 'active')->name('active');
            });

            Route::prefix('sections/')->controller(SectionController::class)->name('section.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/getdata', 'getdata')->name('getdata');
                Route::post('/add', 'add')->name('add');
                Route::post('/changestatus', 'changestatus')->name('changestatus');
            });
        });

        // dashboard/teachers/panel/lectures
        // dash.teacher.panel.lecture
        Route::prefix('teachers')->name('teacher.')->middleware('teacher')->group(function () {
            Route::prefix('lectures')->controller(LecturesController::class)->name('lecture.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/getdata', 'getdata')->name('getdata');
                Route::post('/add', 'add')->name('add');
                Route::post('/update', 'update')->name('update');
                Route::post('/delete', 'delete')->name('delete');
            });

            Route::prefix('quizzs')->controller(QuizzController::class)->name('quizz.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/getdata', 'getdata')->name('getdata');
                Route::get('/create', 'create')->name('create');
                Route::get('/edit{id}', 'edit')->name('edit');
                Route::post('/update{id}', 'update')->name('update');
                Route::post('/add', 'add')->name('add');
                Route::post('/delete', 'delete')->name('delete');
                
            });
        });
    });
});




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';