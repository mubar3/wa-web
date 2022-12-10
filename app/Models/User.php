<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // protected $fillable     = ['username', 'nama', 'email', 'password', 'sandi'];
    protected $guarded = [];
    protected $primaryKey   = 'id';
    public $timestamps      = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function roles()
    {
        return $this->belongsToMany('App\Models\Roles');
    }
}
