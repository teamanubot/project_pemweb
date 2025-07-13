<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;
use App\Models\Course;
use App\Models\Module;
use App\Models\Syllabus;
use App\Models\Quiz;
use App\Models\Submission;
use App\Models\CourseEnrollment;
use App\Models\Attendance;
use App\Models\BranchOffice;
use App\Models\Certificate;
use App\Models\CompanyProfileSetting;
use App\Models\Grade;
use App\Models\Leave;
use App\Models\PaymentTransaction;
use App\Models\PayrollSetting;
use App\Models\Sallary;
use App\Models\Sesi;
use App\Models\SystemNotification;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Hash;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="UEU bootcamp API Documentation",
 *     version="1.0.0",
 *     description="Dokumentasi API untuk semua endpoint di sistem."
 * )
 */

class ApiForEverything extends Controller
{
    // --- Departments ---
    /**
     * @OA\Get(
     *     path="/api/everything/departments",
     *     tags={"Departments"},
     *     summary="List all departments",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexDepartments()
    {
        return Department::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/departments",
     *     tags={"Departments"},
     *     summary="Create new department",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "description"},
     *             @OA\Property(property="name", type="string", enum={"Akademik", "HR & Operasional"}),
     *             @OA\Property(property="description", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storeDepartment(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|in:Akademik,HR & Operasional',
            'description' => 'required|string',
        ]);
        return Department::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/departments/{id}",
     *     tags={"Departments"},
     *     summary="Get a department by ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Not Found")
     * )
     */
    public function showDepartment($id)
    {
        return Department::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/departments/{id}",
     *     tags={"Departments"},
     *     summary="Update a department",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", enum={"Akademik", "HR & Operasional"}),
     *             @OA\Property(property="description", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updateDepartment(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        $validated = $request->validate([
            'name' => 'in:Akademik,HR & Operasional',
            'description' => 'string',
        ]);
        $department->update($validated);
        return $department;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/departments/{id}",
     *     tags={"Departments"},
     *     summary="Delete a department",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroyDepartment($id)
    {
        Department::findOrFail($id)->delete();
        return response()->json(['message' => 'Department deleted']);
    }

    // --- Users ---
    /**
     * @OA\Get(
     *     path="/api/everything/users",
     *     tags={"Users"},
     *     summary="List all users",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexUsers()
    {
        return User::with('department')->get();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/users",
     *     tags={"Users"},
     *     summary="Create new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "phone_number", "address", "nik", "job_title", "department_id", "employment_status", "onboarding_date", "role"},
     *             @OA\Property(property="avatar_url", type="string", format="uri"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password"),
     *             @OA\Property(property="phone_number", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="nik", type="string"),
     *             @OA\Property(property="job_title", type="string"),
     *             @OA\Property(property="department_id", type="integer"),
     *             @OA\Property(property="employment_status", type="string", enum={"active", "inactive"}),
     *             @OA\Property(property="onboarding_date", type="string", format="date"),
     *             @OA\Property(property="expertise_area", type="string"),
     *             @OA\Property(property="teaching_status", type="string", enum={"active", "inactive"}),
     *             @OA\Property(property="role", type="string", enum={"admin_company", "admin_hrm", "admin_lms", "admin_akademik", "admin_hr", "teacher", "student"})
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'avatar_url' => 'nullable|string',
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'nik' => 'required|string',
            'job_title' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'employment_status' => 'required|in:active,inactive',
            'onboarding_date' => 'required|date',
            'expertise_area' => 'nullable|string',
            'teaching_status' => 'nullable|in:active,inactive',
            'role' => 'required|in:admin_company,admin_hrm,admin_lms,admin_akademik,admin_hr,teacher,student',
        ]);
        $validated['password'] = Hash::make($validated['password']);
        return User::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/users/{id}",
     *     tags={"Users"},
     *     summary="Get user by ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Not Found")
     * )
     */
    public function showUser($id)
    {
        return User::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/users/{id}",
     *     tags={"Users"},
     *     summary="Update user",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password"),
     *             @OA\Property(property="phone_number", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="nik", type="string"),
     *             @OA\Property(property="job_title", type="string"),
     *             @OA\Property(property="department_id", type="integer"),
     *             @OA\Property(property="employment_status", type="string", enum={"active", "inactive"}),
     *             @OA\Property(property="onboarding_date", type="string", format="date"),
     *             @OA\Property(property="expertise_area", type="string"),
     *             @OA\Property(property="teaching_status", type="string", enum={"active", "inactive"}),
     *             @OA\Property(property="role", type="string", enum={"admin_company", "admin_hrm", "admin_lms", "admin_akademik", "admin_hr", "teacher", "student"})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'string',
            'email' => 'email|unique:users,email,' . $id,
            'password' => 'nullable|string',
            'phone_number' => 'string',
            'address' => 'string',
            'nik' => 'string',
            'job_title' => 'string',
            'department_id' => 'exists:departments,id',
            'employment_status' => 'in:active,inactive',
            'onboarding_date' => 'date',
            'expertise_area' => 'nullable|string',
            'teaching_status' => 'nullable|in:active,inactive',
            'role' => 'in:admin_company,admin_hrm,admin_lms,admin_akademik,admin_hr,teacher,student',
        ]);
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }
        $user->update($validated);
        return $user;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/users/{id}",
     *     tags={"Users"},
     *     summary="Delete a user",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroyUser($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['message' => 'User deleted']);
    }

    // --- Courses ---
    /**
     * @OA\Get(
     *     path="/api/everything/courses",
     *     tags={"Courses"},
     *     summary="List all courses",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexCourses()
    {
        return Course::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/courses",
     *     tags={"Courses"},
     *     summary="Create new course",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storeCourse(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);
        return Course::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/courses/{id}",
     *     tags={"Courses"},
     *     summary="Get course by ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Not Found")
     * )
     */
    public function showCourse($id)
    {
        return Course::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/courses/{id}",
     *     tags={"Courses"},
     *     summary="Update a course",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updateCourse(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $validated = $request->validate([
            'title' => 'string',
            'description' => 'string',
        ]);
        $course->update($validated);
        return $course;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/courses/{id}",
     *     tags={"Courses"},
     *     summary="Delete a course",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroyCourse($id)
    {
        Course::findOrFail($id)->delete();
        return response()->json(['message' => 'Course deleted']);
    }

    // --- Branch Offices ---
    /**
     * @OA\Get(
     *     path="/api/everything/branch-offices",
     *     tags={"Branch Offices"},
     *     summary="List all branch offices",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexBranchOffices()
    {
        return BranchOffice::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/branch-offices",
     *     tags={"Branch Offices"},
     *     summary="Create new branch office",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "address", "capacity", "contact_person_name", "contact_person_phone"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="capacity", type="integer"),
     *             @OA\Property(property="contact_person_name", type="string"),
     *             @OA\Property(property="contact_person_phone", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storeBranchOffice(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'capacity' => 'required|integer',
            'contact_person_name' => 'required|string',
            'contact_person_phone' => 'required|string',
        ]);
        return BranchOffice::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/branch-offices/{id}",
     *     tags={"Branch Offices"},
     *     summary="Get a branch office by ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Not Found")
     * )
     */
    public function showBranchOffice($id)
    {
        return BranchOffice::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/branch-offices/{id}",
     *     tags={"Branch Offices"},
     *     summary="Update a branch office",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="capacity", type="integer"),
     *             @OA\Property(property="contact_person_name", type="string"),
     *             @OA\Property(property="contact_person_phone", type="string"),
     *             @OA\Property(property="is_active", type="boolean")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updateBranchOffice(Request $request, $id)
    {
        $branch = BranchOffice::findOrFail($id);
        $validated = $request->validate([
            'name' => 'string',
            'address' => 'string',
            'capacity' => 'integer',
            'contact_person_name' => 'string',
            'contact_person_phone' => 'string',
            'is_active' => 'boolean',
        ]);
        $branch->update($validated);
        return $branch;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/branch-offices/{id}",
     *     tags={"Branch Offices"},
     *     summary="Delete a branch office",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroyBranchOffice($id)
    {
        BranchOffice::findOrFail($id)->delete();
        return response()->json(['message' => 'Branch office deleted']);
    }


    // --- Syllabi ---
    /**
     * @OA\Get(
     *     path="/api/everything/syllabi",
     *     tags={"Syllabi"},
     *     summary="List all syllabi",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexSyllabi()
    {
        return Syllabus::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/syllabi",
     *     tags={"Syllabi"},
     *     summary="Create new syllabus",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"course_id", "title", "description", "file_path"},
     *             @OA\Property(property="course_id", type="integer"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="file_path", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storeSyllabus(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'file_path' => 'required|string',
        ]);
        return Syllabus::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/syllabi/{id}",
     *     tags={"Syllabi"},
     *     summary="Get a syllabus by ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Not Found")
     * )
     */
    public function showSyllabus($id)
    {
        return Syllabus::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/syllabi/{id}",
     *     tags={"Syllabi"},
     *     summary="Update a syllabus",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="file_path", type="string"),
     *             @OA\Property(property="is_verified", type="boolean"),
     *             @OA\Property(property="verified_by_user_id", type="integer", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updateSyllabus(Request $request, $id)
    {
        $syllabus = Syllabus::findOrFail($id);
        $validated = $request->validate([
            'title' => 'string',
            'description' => 'string',
            'file_path' => 'string',
            'is_verified' => 'boolean',
            'verified_by_user_id' => 'nullable|exists:users,id',
        ]);
        $syllabus->update($validated);
        return $syllabus;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/syllabi/{id}",
     *     tags={"Syllabi"},
     *     summary="Delete a syllabus",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroySyllabus($id)
    {
        Syllabus::findOrFail($id)->delete();
        return response()->json(['message' => 'Syllabus deleted']);
    }


    // --- Course Enrollments ---
    /**
     * @OA\Get(
     *     path="/api/everything/course-enrollments",
     *     tags={"Course Enrollments"},
     *     summary="List all course enrollments",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexCourseEnrollments()
    {
        return CourseEnrollment::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/course-enrollments",
     *     tags={"Course Enrollments"},
     *     summary="Create new course enrollment",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "course_id", "enrollment_date", "payment_status"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="course_id", type="integer"),
     *             @OA\Property(property="enrollment_date", type="string", format="date"),
     *             @OA\Property(property="payment_status", type="string", enum={"pending", "paid", "failed"})
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storeCourseEnrollment(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'enrollment_date' => 'required|date',
            'payment_status' => 'required|in:pending,paid,failed',
        ]);
        return CourseEnrollment::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/course-enrollments/{id}",
     *     tags={"Course Enrollments"},
     *     summary="Get a course enrollment by ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Not Found")
     * )
     */
    public function showCourseEnrollment($id)
    {
        return CourseEnrollment::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/course-enrollments/{id}",
     *     tags={"Course Enrollments"},
     *     summary="Update a course enrollment",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="payment_status", type="string", enum={"pending", "paid", "failed"}),
     *             @OA\Property(property="access_granted_at", type="string", format="date-time"),
     *             @OA\Property(property="is_completed", type="boolean")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updateCourseEnrollment(Request $request, $id)
    {
        $enrollment = CourseEnrollment::findOrFail($id);
        $validated = $request->validate([
            'payment_status' => 'in:pending,paid,failed',
            'access_granted_at' => 'nullable|date',
            'is_completed' => 'boolean',
        ]);
        $enrollment->update($validated);
        return $enrollment;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/course-enrollments/{id}",
     *     tags={"Course Enrollments"},
     *     summary="Delete a course enrollment",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroyCourseEnrollment($id)
    {
        CourseEnrollment::findOrFail($id)->delete();
        return response()->json(['message' => 'Enrollment deleted']);
    }


    // --- Sesi ---
    /**
     * @OA\Get(
     *     path="/api/everything/sesi",
     *     tags={"Sesi"},
     *     summary="List all sesi",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexSesi()
    {
        return Sesi::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/sesi",
     *     tags={"Sesi"},
     *     summary="Create new sesi",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"course_id", "teacher_id", "session_number", "session_type", "delivery_method", "session_date", "start_time", "end_time", "syllabus_id", "status"},
     *             @OA\Property(property="course_id", type="integer"),
     *             @OA\Property(property="teacher_id", type="integer"),
     *             @OA\Property(property="session_number", type="integer"),
     *             @OA\Property(property="session_type", type="string", enum={"theory", "assignment"}),
     *             @OA\Property(property="delivery_method", type="string", enum={"online", "offline"}),
     *             @OA\Property(property="session_date", type="string", format="date"),
     *             @OA\Property(property="start_time", type="string", format="time"),
     *             @OA\Property(property="end_time", type="string", format="time"),
     *             @OA\Property(property="online_link", type="string", nullable=true),
     *             @OA\Property(property="branch_office_id", type="integer", nullable=true),
     *             @OA\Property(property="syllabus_id", type="integer"),
     *             @OA\Property(property="status", type="string", enum={"scheduled", "completed", "canceled"})
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storeSesi(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:users,id',
            'session_number' => 'required|integer',
            'session_type' => 'required|in:theory,assignment',
            'delivery_method' => 'required|in:online,offline',
            'session_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'online_link' => 'nullable|string',
            'branch_office_id' => 'nullable|exists:branch_offices,id',
            'syllabus_id' => 'required|exists:syllabi,id',
            'status' => 'required|in:scheduled,completed,canceled',
        ]);
        return Sesi::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/sesi/{id}",
     *     tags={"Sesi"},
     *     summary="Get a sesi by ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function showSesi($id)
    {
        return Sesi::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/sesi/{id}",
     *     tags={"Sesi"},
     *     summary="Update a sesi",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="session_number", type="integer"),
     *             @OA\Property(property="status", type="string", enum={"scheduled", "completed", "canceled"})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updateSesi(Request $request, $id)
    {
        $sesi = Sesi::findOrFail($id);
        $validated = $request->validate([
            'session_number' => 'integer',
            'status' => 'in:scheduled,completed,canceled',
        ]);
        $sesi->update($validated);
        return $sesi;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/sesi/{id}",
     *     tags={"Sesi"},
     *     summary="Delete a sesi",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroySesi($id)
    {
        Sesi::findOrFail($id)->delete();
        return response()->json(['message' => 'Sesi deleted']);
    }

    // -- Modules --
    /**
     * @OA\Get(
     *     path="/api/everything/modules",
     *     tags={"Modules"},
     *     summary="List all modules",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexModules()
    {
        return Module::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/modules",
     *     tags={"Modules"},
     *     summary="Create a module",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"sesi_id", "title", "file_path", "file_type", "description", "uploaded_by_user_id"},
     *             @OA\Property(property="sesi_id", type="integer"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="file_path", type="string"),
     *             @OA\Property(property="file_type", type="string"),
     *             @OA\Property(property="link_url", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="uploaded_by_user_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storeModule(Request $request)
    {
        $validated = $request->validate([
            'sesi_id' => 'required|exists:sesi,id',
            'title' => 'required|string',
            'file_path' => 'required|string',
            'file_type' => 'required|string',
            'link_url' => 'nullable|string',
            'description' => 'required|string',
            'uploaded_by_user_id' => 'required|exists:users,id',
        ]);
        return Module::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/modules/{id}",
     *     tags={"Modules"},
     *     summary="Get a module",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Not Found")
     * )
     */
    public function showModule($id)
    {
        return Module::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/modules/{id}",
     *     tags={"Modules"},
     *     summary="Update a module",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="file_path", type="string"),
     *             @OA\Property(property="file_type", type="string"),
     *             @OA\Property(property="link_url", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="is_verified", type="boolean")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updateModule(Request $request, $id)
    {
        $module = Module::findOrFail($id);
        $validated = $request->validate([
            'title' => 'string',
            'file_path' => 'string',
            'file_type' => 'string',
            'link_url' => 'nullable|string',
            'description' => 'string',
            'is_verified' => 'boolean'
        ]);
        $module->update($validated);
        return $module;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/modules/{id}",
     *     tags={"Modules"},
     *     summary="Delete a module",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroyModule($id)
    {
        Module::findOrFail($id)->delete();
        return response()->json(['message' => 'Module deleted']);
    }

    // -- Quizzes --

    /**
     * @OA\Get(
     *     path="/api/everything/quizzes",
     *     tags={"Quizzes"},
     *     summary="List all quizzes",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexQuizzes()
    {
        return Quiz::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/quizzes",
     *     tags={"Quizzes"},
     *     summary="Create a quiz",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description", "type", "due_date", "max_score", "created_by_user_id"},
     *             @OA\Property(property="sesi_id", type="integer", nullable=true),
     *             @OA\Property(property="course_id", type="integer", nullable=true),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="type", type="string", enum={"quiz", "assignment"}),
     *             @OA\Property(property="due_date", type="string", format="date-time"),
     *             @OA\Property(property="max_score", type="integer"),
     *             @OA\Property(property="created_by_user_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storeQuiz(Request $request)
    {
        $validated = $request->validate([
            'sesi_id' => 'nullable|exists:sesi,id',
            'course_id' => 'nullable|exists:courses,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'type' => 'required|in:quiz,assignment',
            'due_date' => 'required|date',
            'max_score' => 'required|integer',
            'created_by_user_id' => 'required|exists:users,id',
        ]);
        return Quiz::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/quizzes/{id}",
     *     tags={"Quizzes"},
     *     summary="Get a specific quiz",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function showQuiz($id)
    {
        return Quiz::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/quizzes/{id}",
     *     tags={"Quizzes"},
     *     summary="Update a quiz",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="type", type="string", enum={"quiz", "assignment"}),
     *             @OA\Property(property="due_date", type="string", format="date-time"),
     *             @OA\Property(property="max_score", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updateQuiz(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);
        $validated = $request->validate([
            'title' => 'string',
            'description' => 'string',
            'type' => 'in:quiz,assignment',
            'due_date' => 'date',
            'max_score' => 'integer',
        ]);
        $quiz->update($validated);
        return $quiz;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/quizzes/{id}",
     *     tags={"Quizzes"},
     *     summary="Delete a quiz",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroyQuiz($id)
    {
        Quiz::findOrFail($id)->delete();
        return response()->json(['message' => 'Quiz deleted']);
    }

    // -- Submissions --

    /**
     * @OA\Get(
     *     path="/api/everything/submissions",
     *     tags={"Submissions"},
     *     summary="List all submissions",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexSubmissions()
    {
        return Submission::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/submissions",
     *     tags={"Submissions"},
     *     summary="Create a submission",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"quiz_id", "user_id", "submitted_at"},
     *             @OA\Property(property="quiz_id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="submitted_at", type="string", format="date-time"),
     *             @OA\Property(property="file_path", type="string"),
     *             @OA\Property(property="text_answer", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storeSubmission(Request $request)
    {
        $validated = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'user_id' => 'required|exists:users,id',
            'submitted_at' => 'required|date',
            'file_path' => 'nullable|string',
            'text_answer' => 'nullable|string',
        ]);
        return Submission::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/submissions/{id}",
     *     tags={"Submissions"},
     *     summary="Get a specific submission",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function showSubmission($id)
    {
        return Submission::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/submissions/{id}",
     *     tags={"Submissions"},
     *     summary="Update a submission (grading)",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="score", type="number", format="float"),
     *             @OA\Property(property="feedback", type="string"),
     *             @OA\Property(property="graded_by_user_id", type="integer"),
     *             @OA\Property(property="graded_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updateSubmission(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);
        $validated = $request->validate([
            'score' => 'nullable|numeric',
            'feedback' => 'nullable|string',
            'graded_by_user_id' => 'nullable|exists:users,id',
            'graded_at' => 'nullable|date',
        ]);
        $submission->update($validated);
        return $submission;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/submissions/{id}",
     *     tags={"Submissions"},
     *     summary="Delete a submission",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroySubmission($id)
    {
        Submission::findOrFail($id)->delete();
        return response()->json(['message' => 'Submission deleted']);
    }

    // -- Grades --

    /**
     * @OA\Get(
     *     path="/api/everything/grades",
     *     tags={"Grades"},
     *     summary="List all grades",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexGrades()
    {
        return Grade::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/grades",
     *     tags={"Grades"},
     *     summary="Create a grade record",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "course_id"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="course_id", type="integer"),
     *             @OA\Property(property="quiz_assignment_score", type="number", format="float"),
     *             @OA\Property(property="attendance_percentage", type="number", format="float"),
     *             @OA\Property(property="mid_eval_score", type="number", format="float"),
     *             @OA\Property(property="final_eval_score", type="number", format="float"),
     *             @OA\Property(property="project_score", type="number", format="float"),
     *             @OA\Property(property="final_grade", type="number", format="float"),
     *             @OA\Property(property="is_passed", type="boolean"),
     *             @OA\Property(property="graded_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storeGrade(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'quiz_assignment_score' => 'nullable|numeric',
            'attendance_percentage' => 'nullable|numeric',
            'mid_eval_score' => 'nullable|numeric',
            'final_eval_score' => 'nullable|numeric',
            'project_score' => 'nullable|numeric',
            'final_grade' => 'nullable|numeric',
            'is_passed' => 'boolean',
            'graded_at' => 'nullable|date',
        ]);
        return Grade::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/grades/{id}",
     *     tags={"Grades"},
     *     summary="Get a grade",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function showGrade($id)
    {
        return Grade::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/grades/{id}",
     *     tags={"Grades"},
     *     summary="Update a grade record",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="quiz_assignment_score", type="number"),
     *             @OA\Property(property="attendance_percentage", type="number"),
     *             @OA\Property(property="mid_eval_score", type="number"),
     *             @OA\Property(property="final_eval_score", type="number"),
     *             @OA\Property(property="project_score", type="number"),
     *             @OA\Property(property="final_grade", type="number"),
     *             @OA\Property(property="is_passed", type="boolean"),
     *             @OA\Property(property="graded_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updateGrade(Request $request, $id)
    {
        $grade = Grade::findOrFail($id);
        $validated = $request->validate([
            'quiz_assignment_score' => 'nullable|numeric',
            'attendance_percentage' => 'nullable|numeric',
            'mid_eval_score' => 'nullable|numeric',
            'final_eval_score' => 'nullable|numeric',
            'project_score' => 'nullable|numeric',
            'final_grade' => 'nullable|numeric',
            'is_passed' => 'boolean',
            'graded_at' => 'nullable|date',
        ]);
        $grade->update($validated);
        return $grade;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/grades/{id}",
     *     tags={"Grades"},
     *     summary="Delete a grade",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroyGrade($id)
    {
        Grade::findOrFail($id)->delete();
        return response()->json(['message' => 'Grade deleted']);
    }

    // --- Attendances ---
    /**
     * @OA\Get(
     *     path="/api/everything/attendances",
     *     tags={"Attendances"},
     *     summary="List all attendances",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexAttendances()
    {
        return Attendance::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/attendances",
     *     tags={"Attendances"},
     *     summary="Create a new attendance record",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "attendance_date", "status"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="sesi_id", type="integer", nullable=true),
     *             @OA\Property(property="attendance_date", type="string", format="date"),
     *             @OA\Property(property="clock_in_time", type="string", format="date-time"),
     *             @OA\Property(property="clock_out_time", type="string", format="date-time"),
     *             @OA\Property(property="status", type="string", enum={"present", "late", "absent", "sick", "leave", "alpha"}),
     *             @OA\Property(property="proof_file_path", type="string"),
     *             @OA\Property(property="notes", type="string"),
     *             @OA\Property(property="verified_by_user_id", type="integer"),
     *             @OA\Property(property="verified_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storeAttendance(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'sesi_id' => 'nullable|exists:sesi,id',
            'attendance_date' => 'required|date',
            'clock_in_time' => 'nullable|date',
            'clock_out_time' => 'nullable|date',
            'status' => 'required|in:present,late,absent,sick,leave,alpha',
            'proof_file_path' => 'nullable|string',
            'notes' => 'nullable|string',
            'verified_by_user_id' => 'nullable|exists:users,id',
            'verified_at' => 'nullable|date',
        ]);
        return Attendance::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/attendances/{id}",
     *     tags={"Attendances"},
     *     summary="Get a single attendance",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Not Found")
     * )
     */
    public function showAttendance($id)
    {
        return Attendance::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/attendances/{id}",
     *     tags={"Attendances"},
     *     summary="Update attendance",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", enum={"present", "late", "absent", "sick", "leave", "alpha"})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updateAttendance(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'exists:users,id',
            'sesi_id' => 'nullable|exists:sesi,id',
            'attendance_date' => 'date',
            'clock_in_time' => 'nullable|date',
            'clock_out_time' => 'nullable|date',
            'status' => 'in:present,late,absent,sick,leave,alpha',
            'proof_file_path' => 'nullable|string',
            'notes' => 'nullable|string',
            'verified_by_user_id' => 'nullable|exists:users,id',
            'verified_at' => 'nullable|date',
        ]);
        $attendance->update($validated);
        return $attendance;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/attendances/{id}",
     *     tags={"Attendances"},
     *     summary="Delete attendance",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroyAttendance($id)
    {
        Attendance::findOrFail($id)->delete();
        return response()->json(['message' => 'Attendance deleted']);
    }

    // ----------------- LEAVES -----------------

    /**
     * @OA\Get(
     *     path="/api/everything/leaves",
     *     tags={"Leaves"},
     *     summary="Get list of all leaves",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexLeaves()
    {
        return Leave::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/leaves",
     *     tags={"Leaves"},
     *     summary="Create a new leave",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "leave_type", "start_date", "end_date", "number_of_days", "reason"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="leave_type", type="string", enum={"annual", "sick", "personal"}),
     *             @OA\Property(property="start_date", type="string", format="date"),
     *             @OA\Property(property="end_date", type="string", format="date"),
     *             @OA\Property(property="number_of_days", type="number", format="float"),
     *             @OA\Property(property="reason", type="string"),
     *             @OA\Property(property="proof_file_path", type="string"),
     *             @OA\Property(property="status", type="string", enum={"pending", "approved", "rejected"}),
     *             @OA\Property(property="approved_by_user_id", type="integer"),
     *             @OA\Property(property="approved_at", type="string", format="date-time"),
     *             @OA\Property(property="replacement_user_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storeLeave(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'leave_type' => 'required|in:annual,sick,personal',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'number_of_days' => 'required|numeric',
            'reason' => 'required|string',
            'proof_file_path' => 'nullable|string',
            'status' => 'nullable|in:pending,approved,rejected',
            'approved_by_user_id' => 'nullable|exists:users,id',
            'approved_at' => 'nullable|date',
            'replacement_user_id' => 'nullable|exists:users,id',
        ]);
        return Leave::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/leaves/{id}",
     *     tags={"Leaves"},
     *     summary="Get single leave detail",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function showLeave($id)
    {
        return Leave::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/leaves/{id}",
     *     tags={"Leaves"},
     *     summary="Update leave data",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", enum={"pending", "approved", "rejected"})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updateLeave(Request $request, $id)
    {
        $leave = Leave::findOrFail($id);
        $validated = $request->validate([
            'leave_type' => 'in:annual,sick,personal',
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date',
            'number_of_days' => 'numeric',
            'reason' => 'string',
            'proof_file_path' => 'nullable|string',
            'status' => 'in:pending,approved,rejected',
            'approved_by_user_id' => 'nullable|exists:users,id',
            'approved_at' => 'nullable|date',
            'replacement_user_id' => 'nullable|exists:users,id',
        ]);
        $leave->update($validated);
        return $leave;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/leaves/{id}",
     *     tags={"Leaves"},
     *     summary="Delete leave record",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroyLeave($id)
    {
        Leave::findOrFail($id)->delete();
        return response()->json(['message' => 'Leave deleted']);
    }

    // ----------------- SALLARIES -----------------

    /**
     * @OA\Get(
     *     path="/api/everything/sallaries",
     *     tags={"Sallaries"},
     *     summary="List all sallaries",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexSallaries()
    {
        return Sallary::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/sallaries",
     *     tags={"Sallaries"},
     *     summary="Create new sallary record",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "month", "year", "base_salary", "total_gross_salary", "total_net_salary", "generated_at", "generated_by_user_id"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="month", type="integer"),
     *             @OA\Property(property="year", type="integer"),
     *             @OA\Property(property="base_salary", type="number", format="float"),
     *             @OA\Property(property="overtime_pay", type="number", format="float"),
     *             @OA\Property(property="alpha_deduction", type="number", format="float"),
     *             @OA\Property(property="excess_leave_deduction", type="number", format="float"),
     *             @OA\Property(property="total_gross_salary", type="number", format="float"),
     *             @OA\Property(property="total_net_salary", type="number", format="float"),
     *             @OA\Property(property="generated_at", type="string", format="date-time"),
     *             @OA\Property(property="generated_by_user_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storeSallary(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'month' => 'required|integer',
            'year' => 'required|integer',
            'base_salary' => 'required|numeric',
            'overtime_pay' => 'nullable|numeric',
            'alpha_deduction' => 'nullable|numeric',
            'excess_leave_deduction' => 'nullable|numeric',
            'total_gross_salary' => 'required|numeric',
            'total_net_salary' => 'required|numeric',
            'generated_at' => 'required|date',
            'generated_by_user_id' => 'required|exists:users,id',
        ]);
        return Sallary::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/sallaries/{id}",
     *     tags={"Sallaries"},
     *     summary="Get single sallary record",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function showSallary($id)
    {
        return Sallary::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/sallaries/{id}",
     *     tags={"Sallaries"},
     *     summary="Update sallary record",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="base_salary", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updateSallary(Request $request, $id)
    {
        $s = Sallary::findOrFail($id);
        $validated = $request->validate([
            'month' => 'integer',
            'year' => 'integer',
            'base_salary' => 'numeric',
            'overtime_pay' => 'numeric',
            'alpha_deduction' => 'numeric',
            'excess_leave_deduction' => 'numeric',
            'total_gross_salary' => 'numeric',
            'total_net_salary' => 'numeric',
            'generated_at' => 'date',
            'generated_by_user_id' => 'exists:users,id',
        ]);
        $s->update($validated);
        return $s;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/sallaries/{id}",
     *     tags={"Sallaries"},
     *     summary="Delete sallary",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroySallary($id)
    {
        Sallary::findOrFail($id)->delete();
        return response()->json(['message' => 'Sallary deleted']);
    }

    // ----------------- PAYROLL SETTINGS -----------------

    /**
     * @OA\Get(
     *     path="/api/everything/payroll-settings",
     *     tags={"Payroll Settings"},
     *     summary="List all payroll settings",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexPayrollSettings()
    {
        return PayrollSetting::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/payroll-settings",
     *     tags={"Payroll Settings"},
     *     summary="Create a new payroll setting",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"setting_key", "setting_value"},
     *             @OA\Property(property="setting_key", type="string"),
     *             @OA\Property(property="setting_value", type="string"),
     *             @OA\Property(property="applies_to_role", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storePayrollSetting(Request $request)
    {
        $validated = $request->validate([
            'setting_key' => 'required|string',
            'setting_value' => 'required|string',
            'applies_to_role' => 'nullable|string',
        ]);
        return PayrollSetting::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/payroll-settings/{id}",
     *     tags={"Payroll Settings"},
     *     summary="Get single payroll setting",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function showPayrollSetting($id)
    {
        return PayrollSetting::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/payroll-settings/{id}",
     *     tags={"Payroll Settings"},
     *     summary="Update payroll setting",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="setting_value", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updatePayrollSetting(Request $request, $id)
    {
        $setting = PayrollSetting::findOrFail($id);
        $validated = $request->validate([
            'setting_key' => 'string',
            'setting_value' => 'string',
            'applies_to_role' => 'nullable|string',
        ]);
        $setting->update($validated);
        return $setting;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/payroll-settings/{id}",
     *     tags={"Payroll Settings"},
     *     summary="Delete payroll setting",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroyPayrollSetting($id)
    {
        PayrollSetting::findOrFail($id)->delete();
        return response()->json(['message' => 'Payroll setting deleted']);
    }

    // ----------------- CERTIFICATES -----------------

    /**
     * @OA\Get(
     *     path="/api/everything/certificates",
     *     tags={"Certificates"},
     *     summary="List all certificates",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexCertificates()
    {
        return Certificate::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/certificates",
     *     tags={"Certificates"},
     *     summary="Create a new certificate",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "course_id", "certificate_number", "issue_date", "qr_code_url", "file_path", "signed_by_user_id"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="course_id", type="integer"),
     *             @OA\Property(property="certificate_number", type="string"),
     *             @OA\Property(property="issue_date", type="string", format="date"),
     *             @OA\Property(property="qr_code_url", type="string"),
     *             @OA\Property(property="file_path", type="string"),
     *             @OA\Property(property="signed_by_user_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storeCertificate(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'certificate_number' => 'required|string|unique:certificates',
            'issue_date' => 'required|date',
            'qr_code_url' => 'required|string',
            'file_path' => 'required|string',
            'signed_by_user_id' => 'required|exists:users,id',
        ]);
        return Certificate::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/certificates/{id}",
     *     tags={"Certificates"},
     *     summary="Get single certificate",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function showCertificate($id)
    {
        return Certificate::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/certificates/{id}",
     *     tags={"Certificates"},
     *     summary="Update certificate",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="certificate_number", type="string"),
     *             @OA\Property(property="issue_date", type="string", format="date"),
     *             @OA\Property(property="qr_code_url", type="string"),
     *             @OA\Property(property="file_path", type="string"),
     *             @OA\Property(property="signed_by_user_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updateCertificate(Request $request, $id)
    {
        $certificate = Certificate::findOrFail($id);
        $validated = $request->validate([
            'certificate_number' => 'string|unique:certificates,certificate_number,' . $id,
            'issue_date' => 'date',
            'qr_code_url' => 'string',
            'file_path' => 'string',
            'signed_by_user_id' => 'exists:users,id',
        ]);
        $certificate->update($validated);
        return $certificate;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/certificates/{id}",
     *     tags={"Certificates"},
     *     summary="Delete certificate",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroyCertificate($id)
    {
        Certificate::findOrFail($id)->delete();
        return response()->json(['message' => 'Certificate deleted']);
    }

    // ----------------- SYSTEM NOTIFICATIONS -----------------

    /**
     * @OA\Get(
     *     path="/api/everything/system-notifications",
     *     tags={"System Notifications"},
     *     summary="List all notifications",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexSystemNotifications()
    {
        return SystemNotification::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/system-notifications",
     *     tags={"System Notifications"},
     *     summary="Create a new notification",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"user_id", "type", "subject", "message", "status", "sent_at"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="type", type="string", enum={"email", "whatsapp"}),
     *             @OA\Property(property="subject", type="string"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="status", type="string", enum={"sent", "failed"}),
     *             @OA\Property(property="sent_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storeSystemNotification(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:email,whatsapp',
            'subject' => 'required|string',
            'message' => 'required|string',
            'status' => 'required|in:sent,failed',
            'sent_at' => 'required|date',
        ]);
        return SystemNotification::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/system-notifications/{id}",
     *     tags={"System Notifications"},
     *     summary="Get single notification",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function showSystemNotification($id)
    {
        return SystemNotification::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/system-notifications/{id}",
     *     tags={"System Notifications"},
     *     summary="Update notification",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", enum={"sent", "failed"})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updateSystemNotification(Request $request, $id)
    {
        $notification = SystemNotification::findOrFail($id);
        $validated = $request->validate([
            'status' => 'in:sent,failed',
        ]);
        $notification->update($validated);
        return $notification;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/system-notifications/{id}",
     *     tags={"System Notifications"},
     *     summary="Delete notification",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroySystemNotification($id)
    {
        SystemNotification::findOrFail($id)->delete();
        return response()->json(['message' => 'Notification deleted']);
    }

    // ----------------- COMPANY PROFILE SETTINGS -----------------

    /**
     * @OA\Get(
     *     path="/api/everything/company-profile-settings",
     *     tags={"Company Profile Settings"},
     *     summary="List all company profile settings",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexCompanyProfileSettings()
    {
        return CompanyProfileSetting::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/company-profile-settings",
     *     tags={"Company Profile Settings"},
     *     summary="Create a new setting",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"setting_key", "setting_value"},
     *             @OA\Property(property="setting_key", type="string"),
     *             @OA\Property(property="setting_value", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storeCompanyProfileSetting(Request $request)
    {
        $validated = $request->validate([
            'setting_key' => 'required|string',
            'setting_value' => 'required|string',
        ]);
        return CompanyProfileSetting::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/company-profile-settings/{id}",
     *     tags={"Company Profile Settings"},
     *     summary="Get single setting",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function showCompanyProfileSetting($id)
    {
        return CompanyProfileSetting::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/company-profile-settings/{id}",
     *     tags={"Company Profile Settings"},
     *     summary="Update setting",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="setting_key", type="string"),
     *             @OA\Property(property="setting_value", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updateCompanyProfileSetting(Request $request, $id)
    {
        $setting = CompanyProfileSetting::findOrFail($id);
        $validated = $request->validate([
            'setting_key' => 'string',
            'setting_value' => 'string',
        ]);
        $setting->update($validated);
        return $setting;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/company-profile-settings/{id}",
     *     tags={"Company Profile Settings"},
     *     summary="Delete setting",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroyCompanyProfileSetting($id)
    {
        CompanyProfileSetting::findOrFail($id)->delete();
        return response()->json(['message' => 'Setting deleted']);
    }

    // ----------------- BLOG POSTS -----------------

    /**
     * @OA\Get(
     *     path="/api/everything/blog-posts",
     *     tags={"Blog Posts"},
     *     summary="List all blog posts",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexBlogPosts()
    {
        return BlogPost::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/blog-posts",
     *     tags={"Blog Posts"},
     *     summary="Create a new blog post",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"title", "slug", "content", "author_id"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="slug", type="string"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="author_id", type="integer"),
     *             @OA\Property(property="published_at", type="string", format="date-time"),
     *             @OA\Property(property="is_published", type="boolean")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storeBlogPost(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string|unique:blog_posts',
            'content' => 'required|string',
            'author_id' => 'required|exists:users,id',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);
        return BlogPost::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/blog-posts/{id}",
     *     tags={"Blog Posts"},
     *     summary="Get single blog post",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function showBlogPost($id)
    {
        return BlogPost::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/blog-posts/{id}",
     *     tags={"Blog Posts"},
     *     summary="Update blog post",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="slug", type="string"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="published_at", type="string", format="date-time"),
     *             @OA\Property(property="is_published", type="boolean")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updateBlogPost(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);
        $validated = $request->validate([
            'title' => 'string',
            'slug' => 'string|unique:blog_posts,slug,' . $id,
            'content' => 'string',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);
        $post->update($validated);
        return $post;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/blog-posts/{id}",
     *     tags={"Blog Posts"},
     *     summary="Delete blog post",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroyBlogPost($id)
    {
        BlogPost::findOrFail($id)->delete();
        return response()->json(['message' => 'Blog post deleted']);
    }

    // ----------------- PAYMENT TRANSACTIONS -----------------

    /**
     * @OA\Get(
     *     path="/api/everything/payment-transactions",
     *     tags={"Payment Transactions"},
     *     summary="List all payment transactions",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function indexPaymentTransactions()
    {
        return PaymentTransaction::all();
    }

    /**
     * @OA\Post(
     *     path="/api/everything/payment-transactions",
     *     tags={"Payment Transactions"},
     *     summary="Create a new payment transaction",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={
     *                 "course_enrollment_id", "midtrans_order_id", "amount", "currency", 
     *                 "payment_method", "transaction_status", "transaction_time"
     *             },
     *             @OA\Property(property="course_enrollment_id", type="integer"),
     *             @OA\Property(property="midtrans_order_id", type="string"),
     *             @OA\Property(property="midtrans_transaction_id", type="string"),
     *             @OA\Property(property="amount", type="number", format="float"),
     *             @OA\Property(property="currency", type="string"),
     *             @OA\Property(property="payment_method", type="string"),
     *             @OA\Property(property="transaction_status", type="string", enum={
     *                 "pending", "settlement", "expire", "cancel", "deny", "refund", 
     *                 "partial_refund", "capture", "authorize"
     *             }),
     *             @OA\Property(property="transaction_time", type="string", format="date-time"),
     *             @OA\Property(property="settlement_time", type="string", format="date-time"),
     *             @OA\Property(property="expiry_time", type="string", format="date-time"),
     *             @OA\Property(property="raw_response", type="object")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function storePaymentTransaction(Request $request)
    {
        $validated = $request->validate([
            'course_enrollment_id' => 'required|exists:course_enrollments,id',
            'midtrans_order_id' => 'required|string|unique:payment_transactions',
            'midtrans_transaction_id' => 'nullable|string|unique:payment_transactions',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'payment_method' => 'required|string',
            'transaction_status' => 'required|string|in:pending,settlement,expire,cancel,deny,refund,partial_refund,capture,authorize',
            'transaction_time' => 'required|date',
            'settlement_time' => 'nullable|date',
            'expiry_time' => 'nullable|date',
            'raw_response' => 'nullable|json',
        ]);
        return PaymentTransaction::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/everything/payment-transactions/{id}",
     *     tags={"Payment Transactions"},
     *     summary="Get single payment transaction",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function showPaymentTransaction($id)
    {
        return PaymentTransaction::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/everything/payment-transactions/{id}",
     *     tags={"Payment Transactions"},
     *     summary="Update payment transaction",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="transaction_status", type="string"),
     *             @OA\Property(property="settlement_time", type="string", format="date-time"),
     *             @OA\Property(property="expiry_time", type="string", format="date-time"),
     *             @OA\Property(property="raw_response", type="object")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function updatePaymentTransaction(Request $request, $id)
    {
        $transaction = PaymentTransaction::findOrFail($id);
        $validated = $request->validate([
            'transaction_status' => 'string|in:pending,settlement,expire,cancel,deny,refund,partial_refund,capture,authorize',
            'settlement_time' => 'nullable|date',
            'expiry_time' => 'nullable|date',
            'raw_response' => 'nullable|json',
        ]);
        $transaction->update($validated);
        return $transaction;
    }

    /**
     * @OA\Delete(
     *     path="/api/everything/payment-transactions/{id}",
     *     tags={"Payment Transactions"},
     *     summary="Delete payment transaction",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroyPaymentTransaction($id)
    {
        PaymentTransaction::findOrFail($id)->delete();
        return response()->json(['message' => 'Payment transaction deleted']);
    }
}

/* REAL API FOR EVERYTHING, NO FEK FEK ASLI BERCAP BADAK */