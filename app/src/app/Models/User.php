<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'avatar_url',
        'name',
        'email',
        'password',
        'email_verified_at',
        'phone_number',
        'address',
        'nik',
        'job_title',
        'department_id',
        'employment_status',
        'onboarding_date',
        'expertise_area',
        'teaching_status',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'onboarding_date' => 'date',
            'password' => 'hashed',
            'employment_status' => 'string',
            'teaching_status' => 'string',
            'role' => 'string',
        ];
    }

    /**
     * Relasi ke tabel departments
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }


    /**
     * Contoh relasi lain ke enrollments, submissions, dll bisa ditambahkan jika diperlukan
     */

    public function getFilamentAvatarUrl(): ?string
    {
        if ($this->avatar_url) {
            return asset('storage/' . $this->avatar_url);
        } else {
            $hash = md5(strtolower(trim($this->email)));

            return 'https://www.gravatar.com/avatar/' . $hash . '?d=mp&r=g&s=250';
        }
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'instructor' => $this->role === 'teacher',
            'student' => $this->role === 'student',
            'admin' => in_array($this->role, [
                'admin_company',
                'admin_hrm',
                'admin_lms',
                'admin_akademik',
                'admin_hr',
                'adminsuper',
            ]),
            default => false,
        };
    }
}
