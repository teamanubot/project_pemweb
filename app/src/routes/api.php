<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiForEverything;

Route::get('/', fn() => redirect('/'));
Route::get('/everything', fn() => redirect('/'));

Route::prefix('everything')->group(function () {
    // Departments
    Route::get('/departments', [ApiForEverything::class, 'indexDepartments']);
    Route::post('/departments', [ApiForEverything::class, 'storeDepartment']);
    Route::get('/departments/{id}', [ApiForEverything::class, 'showDepartment']);
    Route::put('/departments/{id}', [ApiForEverything::class, 'updateDepartment']);
    Route::delete('/departments/{id}', [ApiForEverything::class, 'destroyDepartment']);

    // Users
    Route::get('/users', [ApiForEverything::class, 'indexUsers']);
    Route::post('/users', [ApiForEverything::class, 'storeUser']);
    Route::get('/users/{id}', [ApiForEverything::class, 'showUser']);
    Route::put('/users/{id}', [ApiForEverything::class, 'updateUser']);
    Route::delete('/users/{id}', [ApiForEverything::class, 'destroyUser']);

    // Courses
    Route::get('/courses', [ApiForEverything::class, 'indexCourses']);
    Route::post('/courses', [ApiForEverything::class, 'storeCourse']);
    Route::get('/courses/{id}', [ApiForEverything::class, 'showCourse']);
    Route::put('/courses/{id}', [ApiForEverything::class, 'updateCourse']);
    Route::delete('/courses/{id}', [ApiForEverything::class, 'destroyCourse']);

    // Branch Offices
    Route::get('/branch-offices', [ApiForEverything::class, 'indexBranchOffices']);
    Route::post('/branch-offices', [ApiForEverything::class, 'storeBranchOffice']);
    Route::get('/branch-offices/{id}', [ApiForEverything::class, 'showBranchOffice']);
    Route::put('/branch-offices/{id}', [ApiForEverything::class, 'updateBranchOffice']);
    Route::delete('/branch-offices/{id}', [ApiForEverything::class, 'destroyBranchOffice']);

    // Syllabi
    Route::get('/syllabi', [ApiForEverything::class, 'indexSyllabi']);
    Route::post('/syllabi', [ApiForEverything::class, 'storeSyllabus']);
    Route::get('/syllabi/{id}', [ApiForEverything::class, 'showSyllabus']);
    Route::put('/syllabi/{id}', [ApiForEverything::class, 'updateSyllabus']);
    Route::delete('/syllabi/{id}', [ApiForEverything::class, 'destroySyllabus']);

    // Course Enrollments
    Route::get('/course-enrollments', [ApiForEverything::class, 'indexCourseEnrollments']);
    Route::post('/course-enrollments', [ApiForEverything::class, 'storeCourseEnrollment']);
    Route::get('/course-enrollments/{id}', [ApiForEverything::class, 'showCourseEnrollment']);
    Route::put('/course-enrollments/{id}', [ApiForEverything::class, 'updateCourseEnrollment']);
    Route::delete('/course-enrollments/{id}', [ApiForEverything::class, 'destroyCourseEnrollment']);

    // Sesi
    Route::get('/sesi', [ApiForEverything::class, 'indexSesi']);
    Route::post('/sesi', [ApiForEverything::class, 'storeSesi']);
    Route::get('/sesi/{id}', [ApiForEverything::class, 'showSesi']);
    Route::put('/sesi/{id}', [ApiForEverything::class, 'updateSesi']);
    Route::delete('/sesi/{id}', [ApiForEverything::class, 'destroySesi']);

    // Modules
    Route::get('/modules', [ApiForEverything::class, 'indexModules']);
    Route::post('/modules', [ApiForEverything::class, 'storeModule']);
    Route::get('/modules/{id}', [ApiForEverything::class, 'showModule']);
    Route::put('/modules/{id}', [ApiForEverything::class, 'updateModule']);
    Route::delete('/modules/{id}', [ApiForEverything::class, 'destroyModule']);

    // Quizzes
    Route::get('/quizzes', [ApiForEverything::class, 'indexQuizzes']);
    Route::post('/quizzes', [ApiForEverything::class, 'storeQuiz']);
    Route::get('/quizzes/{id}', [ApiForEverything::class, 'showQuiz']);
    Route::put('/quizzes/{id}', [ApiForEverything::class, 'updateQuiz']);
    Route::delete('/quizzes/{id}', [ApiForEverything::class, 'destroyQuiz']);

    // Submissions
    Route::get('/submissions', [ApiForEverything::class, 'indexSubmissions']);
    Route::post('/submissions', [ApiForEverything::class, 'storeSubmission']);
    Route::get('/submissions/{id}', [ApiForEverything::class, 'showSubmission']);
    Route::put('/submissions/{id}', [ApiForEverything::class, 'updateSubmission']);
    Route::delete('/submissions/{id}', [ApiForEverything::class, 'destroySubmission']);

    // Grades
    Route::get('/grades', [ApiForEverything::class, 'indexGrades']);
    Route::post('/grades', [ApiForEverything::class, 'storeGrade']);
    Route::get('/grades/{id}', [ApiForEverything::class, 'showGrade']);
    Route::put('/grades/{id}', [ApiForEverything::class, 'updateGrade']);
    Route::delete('/grades/{id}', [ApiForEverything::class, 'destroyGrade']);

    // Attendances
    Route::get('/attendances', [ApiForEverything::class, 'indexAttendances']);
    Route::post('/attendances', [ApiForEverything::class, 'storeAttendance']);
    Route::get('/attendances/{id}', [ApiForEverything::class, 'showAttendance']);
    Route::put('/attendances/{id}', [ApiForEverything::class, 'updateAttendance']);
    Route::delete('/attendances/{id}', [ApiForEverything::class, 'destroyAttendance']);

    // Leaves
    Route::get('/leaves', [ApiForEverything::class, 'indexLeaves']);
    Route::post('/leaves', [ApiForEverything::class, 'storeLeave']);
    Route::get('/leaves/{id}', [ApiForEverything::class, 'showLeave']);
    Route::put('/leaves/{id}', [ApiForEverything::class, 'updateLeave']);
    Route::delete('/leaves/{id}', [ApiForEverything::class, 'destroyLeave']);

    // Sallaries
    Route::get('/sallaries', [ApiForEverything::class, 'indexSallaries']);
    Route::post('/sallaries', [ApiForEverything::class, 'storeSallary']);
    Route::get('/sallaries/{id}', [ApiForEverything::class, 'showSallary']);
    Route::put('/sallaries/{id}', [ApiForEverything::class, 'updateSallary']);
    Route::delete('/sallaries/{id}', [ApiForEverything::class, 'destroySallary']);

    // Payroll Settings
    Route::get('/payroll-settings', [ApiForEverything::class, 'indexPayrollSettings']);
    Route::post('/payroll-settings', [ApiForEverything::class, 'storePayrollSetting']);
    Route::get('/payroll-settings/{id}', [ApiForEverything::class, 'showPayrollSetting']);
    Route::put('/payroll-settings/{id}', [ApiForEverything::class, 'updatePayrollSetting']);
    Route::delete('/payroll-settings/{id}', [ApiForEverything::class, 'destroyPayrollSetting']);

    // Certificates
    Route::get('/certificates', [ApiForEverything::class, 'indexCertificates']);
    Route::post('/certificates', [ApiForEverything::class, 'storeCertificate']);
    Route::get('/certificates/{id}', [ApiForEverything::class, 'showCertificate']);
    Route::put('/certificates/{id}', [ApiForEverything::class, 'updateCertificate']);
    Route::delete('/certificates/{id}', [ApiForEverything::class, 'destroyCertificate']);

    // System Notifications
    Route::get('/system-notifications', [ApiForEverything::class, 'indexSystemNotifications']);
    Route::post('/system-notifications', [ApiForEverything::class, 'storeSystemNotification']);
    Route::get('/system-notifications/{id}', [ApiForEverything::class, 'showSystemNotification']);
    Route::put('/system-notifications/{id}', [ApiForEverything::class, 'updateSystemNotification']);
    Route::delete('/system-notifications/{id}', [ApiForEverything::class, 'destroySystemNotification']);

    // Company Profile Settings
    Route::get('/company-profile-settings', [ApiForEverything::class, 'indexCompanyProfileSettings']);
    Route::post('/company-profile-settings', [ApiForEverything::class, 'storeCompanyProfileSetting']);
    Route::get('/company-profile-settings/{id}', [ApiForEverything::class, 'showCompanyProfileSetting']);
    Route::put('/company-profile-settings/{id}', [ApiForEverything::class, 'updateCompanyProfileSetting']);
    Route::delete('/company-profile-settings/{id}', [ApiForEverything::class, 'destroyCompanyProfileSetting']);

    // Blog Posts
    Route::get('/blog-posts', [ApiForEverything::class, 'indexBlogPosts']);
    Route::post('/blog-posts', [ApiForEverything::class, 'storeBlogPost']);
    Route::get('/blog-posts/{id}', [ApiForEverything::class, 'showBlogPost']);
    Route::put('/blog-posts/{id}', [ApiForEverything::class, 'updateBlogPost']);
    Route::delete('/blog-posts/{id}', [ApiForEverything::class, 'destroyBlogPost']);

    // Payment Transactions
    Route::get('/payment-transactions', [ApiForEverything::class, 'indexPaymentTransactions']);
    Route::post('/payment-transactions', [ApiForEverything::class, 'storePaymentTransaction']);
    Route::get('/payment-transactions/{id}', [ApiForEverything::class, 'showPaymentTransaction']);
    Route::put('/payment-transactions/{id}', [ApiForEverything::class, 'updatePaymentTransaction']);
    Route::delete('/payment-transactions/{id}', [ApiForEverything::class, 'destroyPaymentTransaction']);
});
