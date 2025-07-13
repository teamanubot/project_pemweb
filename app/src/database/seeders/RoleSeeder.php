<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleGuardMap = [
            'super_admin'  => 'admin',
            'admin_company'  => 'admin',
            'admin_hrm'      => 'admin',
            'admin_lms'      => 'admin',
            'admin_akademik' => 'admin',
            'admin_hr'       => 'admin',
            'teacher'        => 'instructor',
            'student'        => 'student',
        ];

        $models = [
            \Spatie\Activitylog\Models\Activity::class,
            \App\Models\Attendance::class,
            \App\Models\BlogPost::class,
            \App\Models\BranchOffice::class,
            \App\Models\Certificate::class,
            \App\Models\CompanyProfileSetting::class,
            \App\Models\Course::class,
            \App\Models\CourseEnrollment::class,
            \App\Models\Department::class,
            \App\Models\Grade::class,
            \App\Models\Leave::class,
            \App\Models\Module::class,
            \App\Models\PaymentTransaction::class,
            \App\Models\PayrollSetting::class,
            \App\Models\Quiz::class,
            \Spatie\Permission\Models\Role::class,
            \App\Models\Sallary::class,
            \App\Models\Sesi::class,
            \App\Models\Submission::class,
            \App\Models\Syllabus::class,
            \App\Models\SystemNotification::class,
            \App\Models\User::class,
        ];

        $roleModelPermissionMap = [
            'super_admin' => [
                '*' => ['create', 'view', 'view any', 'update', 'delete', 'delete any'],
            ],

            'admin_company' => [
                \App\Models\CompanyProfileSetting::class => ['create', 'view', 'view any', 'update', 'delete', 'delete any'],
                \App\Models\BlogPost::class => ['create', 'view', 'view any', 'update', 'delete', 'delete any'],
                \App\Models\User::class => ['view', 'view any'],
            ],

            'admin_hrm' => [
                \App\Models\User::class => ['create', 'view', 'view any', 'update', 'delete', 'delete any'],
                \App\Models\Department::class => ['create', 'view', 'view any', 'update', 'delete', 'delete any'],
                \App\Models\BranchOffice::class => ['create', 'view', 'view any', 'update', 'delete', 'delete any'],
                \App\Models\Sesi::class => ['create', 'view', 'view any', 'update'],
                \App\Models\Attendance::class => ['view', 'view any', 'update'],
                \App\Models\Leave::class => ['view', 'view any', 'update'],
                \App\Models\Sallary::class => ['create', 'view', 'view any', 'update'],
                \App\Models\PayrollSetting::class => ['view', 'view any', 'update'],
                \App\Models\SystemNotification::class => ['create', 'view', 'view any'],
                \App\Models\PaymentTransaction::class => ['view', 'view any'],
            ],

            'admin_lms' => [
                \App\Models\Course::class => ['create', 'view', 'view any', 'update', 'delete', 'delete any'],
                \App\Models\CourseEnrollment::class => ['view', 'view any'],
                \App\Models\Syllabus::class => ['create', 'view', 'view any', 'update', 'delete', 'delete any'],
                \App\Models\Module::class => ['create', 'view', 'view any', 'update', 'delete', 'delete any'],
                \App\Models\Quiz::class => ['create', 'view', 'view any', 'update', 'delete', 'delete any'],
                \App\Models\Submission::class => ['view', 'view any'],
                \App\Models\Grade::class => ['view', 'view any'],
                \App\Models\Certificate::class => ['create', 'view', 'view any', 'update', 'delete', 'delete any'],
                \App\Models\SystemNotification::class => ['create', 'view', 'view any'],
            ],

            'admin_akademik' => [
                \App\Models\Sesi::class => ['view', 'view any', 'update'],
                \App\Models\Syllabus::class => ['view', 'view any', 'update'],
                \App\Models\Module::class => ['view', 'view any', 'update'],
                \App\Models\Quiz::class => ['view', 'view any', 'update'],
                \App\Models\Grade::class => ['view', 'view any'],
                \App\Models\Attendance::class => ['view', 'view any'],
                \App\Models\Certificate::class => ['view', 'view any'],
            ],

            'admin_hr' => [
                \App\Models\User::class => ['view', 'view any', 'update'],
                \App\Models\Attendance::class => ['view', 'view any', 'update'],
                \App\Models\Leave::class => ['view', 'view any', 'update'],
                \App\Models\Sallary::class => ['view', 'view any', 'update'],
                \App\Models\PayrollSetting::class => ['view', 'view any'],
                \App\Models\PaymentTransaction::class => ['view', 'view any'],
            ],

            'teacher' => [
                \App\Models\User::class => ['view', 'view any', 'update'],
                \App\Models\Sesi::class => ['view', 'view any'],
                \App\Models\Syllabus::class => ['create', 'view', 'view any', 'update'],
                \App\Models\Module::class => ['create', 'view', 'view any', 'update', 'delete', 'delete any'],
                \App\Models\Quiz::class => ['create', 'view', 'view any', 'update'],
                \App\Models\Submission::class => ['view', 'view any', 'update'],
                \App\Models\Grade::class => ['view', 'view any', 'update'],
                \App\Models\Attendance::class => ['create', 'view', 'view any', 'update'],
                \App\Models\Leave::class => ['create', 'view', 'view any'],
                \App\Models\Sallary::class => ['view', 'view any'],
                \App\Models\Course::class => ['view', 'view any'],
                \App\Models\CourseEnrollment::class => ['view', 'view any'],
            ],

            'student' => [
                \App\Models\User::class => ['view', 'view any', 'update'],
                \App\Models\CourseEnrollment::class => ['create', 'view', 'view any', 'update'],
                \App\Models\Module::class => ['view', 'view any'],
                \App\Models\Quiz::class => ['view', 'view any'],
                \App\Models\Submission::class => ['create', 'view', 'view any', 'update'],
                \App\Models\Grade::class => ['view', 'view any'],
                \App\Models\Attendance::class => ['create', 'view', 'view any'],
                \App\Models\Certificate::class => ['view', 'view any'],
                \App\Models\PaymentTransaction::class => ['create', 'view', 'view any'],
                \App\Models\SystemNotification::class => ['view', 'view any'],
                \App\Models\CompanyProfileSetting::class => ['view', 'view any'],
                \App\Models\BlogPost::class => ['view', 'view any'],
            ],
        ];


        $crudPermissions = ['view', 'view any', 'create', 'update', 'delete', 'delete any'];
        $widgetPermissions = ['overlook widget', 'latest access logs'];

        // Step 1: Create roles
        foreach ($roleGuardMap as $role => $guard) {
            Role::firstOrCreate([
                'name'       => $role,
                'guard_name' => $guard,
            ]);
        }

        // Step 2: Create ALL possible permissions for each guard
        foreach (array_unique(array_values($roleGuardMap)) as $guard) {
            foreach ($models as $model) {
                $modelName = $this->formatModelName($model);
                foreach ($crudPermissions as $perm) {
                    Permission::firstOrCreate([
                        'name'       => str_replace(' ', '_', "{$perm}_{$modelName}"),
                        'guard_name' => $guard,
                    ]);
                }
            }

            foreach ($widgetPermissions as $widgetPerm) {
                Permission::firstOrCreate([
                    'name'       => $widgetPerm,
                    'guard_name' => $guard,
                ]);
            }
        }

        // Step 3: Assign permission to roles as mapped
        foreach ($roleModelPermissionMap as $roleName => $modelPermission) {
            $role = Role::where('name', $roleName)->first();
            $guard = $roleGuardMap[$roleName];

            $permissions = [];

            foreach ($modelPermission as $model => $perms) {
                if ($model === '*') {
                    foreach ($models as $m) {
                        $modelName = $this->formatModelName($m);
                        foreach ($perms as $perm) {
                            $permissions[] = str_replace(' ', '_', "{$perm}_{$modelName}");
                        }
                    }
                } else {
                    $modelName = $this->formatModelName($model);
                    foreach ($perms as $perm) {
                        $permissions[] = str_replace(' ', '_', "{$perm}_{$modelName}");
                    }
                }
            }

            foreach ($widgetPermissions as $widgetPerm) {
                $permissions[] = $widgetPerm;
            }

            $role->syncPermissions(
                Permission::whereIn('name', $permissions)->where('guard_name', $guard)->pluck('name')->toArray()
            );
        }
    }

    protected function formatModelName(string $model): string
    {
        $parts = preg_split('/(?=[A-Z])/', class_basename($model), -1, PREG_SPLIT_NO_EMPTY);
        return implode('::', array_map(fn($p) => Str::snake($p), $parts));
    }
}
