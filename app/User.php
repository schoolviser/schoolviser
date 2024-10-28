<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


use Delgont\Armor\Concerns\HasUserTypes;
use Delgont\Armor\Concerns\ModelHasPermissions;
use Delgont\Armor\Concerns\ModelHasSingleRole;

use App\Models\Concerns\ModelHasSettings;

use Modules\User\Entities\Concerns\AuthenticationLoggable;

use App\Models\Master;
use App\Models\Employee\Employee;


class User extends Authenticatable
{
    use Notifiable, HasUserTypes, ModelHasSingleRole, ModelHasPermissions, AuthenticationLoggable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'last_seen_at',
        'last_ip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Get Employee Users
     */
    public function scopeEmployee($query)
    {
        $query->whereUserType(Employee::class);
    }

    /**
     * Get supper user accounts
     */

     public function scopeSuper($query)
     {
        $query->whereUserType(Master::class);
     }
}

