<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Department;
use App\Models\Quiz;
use Livewire\Component;
use App\Models\BranchOffice;

class MainPage extends Component
{
    public function render()
{
    $branchCount = BranchOffice::count();
    $courseCount = Course::count();
    $departmentCount = Department::count();
    $quizCount = Quiz::count();
    $courses = Course::where('is_active', true)->get();

    return view('livewire.main-page', [
        'branchCount' => $branchCount,
        'courseCount' => $courseCount,
        'departmentCount' => $departmentCount,
        'quizCount' => $quizCount,
        'courses' => $courses,
    ]);
}

}