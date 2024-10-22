<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;
    use HasPanelShield;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'country_id',
        'state_id',
        'city_id',
        'address',
        'postal_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function state() : BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city() : BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function calendars(){
        return $this->belongsToMany(Calendar::class);
    }

    public function departments(){
        return $this->belongsToMany(Department::class);
    }

    public function holidays(){
        return $this->hasMany(Holiday::class);
    }

    public function timesheets(){
        return $this->hasMany(Timesheet::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if(str_ends_with($this->email, '@whitemind.es') && $this->hasVerifiedEmail()){
            return true;
        }
        else{
            //abort(403, 'User does not have verified email.');
        }
        if ($panel->getId() === 'admin') {
            if($this->isAdmin()){
                return true;
            }
            else{
                abort(403, 'User does not have the right roles.');
            }
        }

        return true;
    }

    public function isAdmin(){
        if($this->hasRole(['super_admin'])){
                return true;
        }
        else{
            return false;
        }
    }
}
