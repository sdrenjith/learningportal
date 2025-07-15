<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DayController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('filament.admin.pages.dashboard');
    }
    return redirect()->route('login');
});

// User profile routes (optional, keep if you want user-side features)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/student/courses', [\App\Http\Controllers\StudentCourseController::class, 'index'])->name('filament.student.pages.courses');

    Route::get('/student/questions', [\App\Http\Controllers\StudentCourseController::class, 'questions'])->name('filament.student.pages.questions');
    Route::get('/student/questions/{question}/answer', [\App\Http\Controllers\StudentQuestionController::class, 'answer'])->name('student.questions.answer');
    
    // Explicitly define submit answer route with full path
    Route::post('/student/questions/{id}/submit-answer', function(Illuminate\Http\Request $request, $id) {
        \Log::info('Submit Answer Route Debug', [
            'route_name' => $request->route()->getName(),
            'route_parameters' => $request->route()->parameters(),
            'all_input' => $request->all(),
            'id' => $id
        ]);
        
        $controller = new \App\Http\Controllers\StudentQuestionController();
        return $controller->submitAnswer($request, $id);
    })->name('filament.student.submit_answer')
      ->where('id', '[0-9]+');

    // Remove any redundant routes for submitting answers
    // Route::post('/student/questions/{question}/answer', [\App\Http\Controllers\StudentQuestionController::class, 'submitAnswer'])->name('student.questions.answer.submit');
    // Route::post('/student/questions/{question}/submit', [\App\Http\Controllers\StudentQuestionController::class, 'submitAnswer'])->name('filament.student.pages.questions.submit');
    Route::get('/student/doubt-clearance', function () {
        $doubts = \App\Models\Doubt::where('user_id', auth()->id())->orderBy('created_at')->get();
        return view('filament.student.pages.doubt-clearance', compact('doubts'));
    })->name('filament.student.pages.doubt-clearance');
    Route::post('/student/doubt-clearance', function (\Illuminate\Http\Request $request) {
        $request->validate(['message' => 'required|string|max:1000']);
        \App\Models\Doubt::create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);
        return redirect()->back()->with('success', 'Your doubt has been submitted!');
    })->name('student.doubt.submit');
    
    // Secure file preview routes
    Route::get('/secure-preview/{type}/{id}', [\App\Http\Controllers\SecureFilePreviewController::class, 'previewFile'])->name('secure-file-preview');
    Route::get('/secure-modal/{type}/{id}', [\App\Http\Controllers\SecureFilePreviewController::class, 'previewModal'])->name('secure-file-modal');

    // Explicitly define test routes with full path
    Route::prefix('student/tests')->group(function () {
        Route::get('/', [\App\Http\Controllers\StudentTestController::class, 'index'])
            ->name('filament.student.pages.tests');
        
        Route::get('/{test}', [\App\Http\Controllers\StudentTestController::class, 'show'])
            ->name('filament.student.pages.tests.show');
        
        // Fallback route for tests.detail
        Route::get('/{test}/detail', function($test) {
            return redirect()->route('filament.student.pages.tests.show', $test);
        })->name('filament.student.pages.tests.detail');
        
        Route::get('/{test}/question/{question}', [\App\Http\Controllers\StudentTestController::class, 'question'])
            ->name('filament.student.pages.tests.question');
        
        // Specific route for test question submissions with explicit method
        Route::post('/{test}/question/{question}/submit', [\App\Http\Controllers\StudentTestController::class, 'submitAnswer'])
            ->name('filament.student.pages.tests.question.submit');
        
        Route::get('/test-questions', [\App\Http\Controllers\StudentTestController::class, 'testQuestions'])
            ->name('filament.student.pages.test-questions');
    });
});

Route::post('/admin/set-locale', function (\Illuminate\Http\Request $request) {
    $locale = $request->input('locale', 'en');
    session(['locale' => $locale]);
    app()->setLocale($locale);
    return back();
})->name('admin.set-locale');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Filament handles the dashboard and resource pages
    // Remove custom dashboard route
    // Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // Route::resource('courses', CourseController::class);
    // Route::resource('days', DayController::class);
    // Route::resource('questions', QuestionController::class);
    // Instead, redirect /admin to Filament's dashboard
    Route::redirect('/', '/admin/dashboard');
});

require __DIR__.'/auth.php';
