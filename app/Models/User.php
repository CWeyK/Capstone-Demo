<?php

namespace App\Models;

use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'programme_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'   => 'datetime',
            'last_login_at'       => 'datetime',
            'suspended_at'        => 'datetime',
            'promoted_at'         => 'datetime',
            'restrict_withdrawal' => 'boolean',
        ];
    }

    /**
     * User relation to info model
     *
     *
     */
    public function lecturerSubjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'subject_lecturers', 'user_id', 'subject_id');
    }

    public function classGroups(): HasMany
    {
        return $this->hasMany(ClassGroup::class, 'lecturer', 'id');
    }

    public function programme(): HasOne
    {
        return $this->hasOne(Programme::class, 'id', 'programme_id');
    }

    public function studentGroups(): BelongsToMany
    {
        return $this->belongsToMany(ClassGroup::class);
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['email'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
        ->addMediaConversion('profile')
        ->nonQueued()
        ->focalCrop(100, 100);
    }

    public function profileImg(){
        return $this->getFirstMediaUrl('avatar','profile') 
        ?: 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=7F9CF5&background=EBF4FF';
    }

    public function roleName(): Attribute{
        return Attribute::get(fn()=> $this->getRoleNames()->first());
    }

}

