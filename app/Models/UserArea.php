<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserArea extends Model
{
    use HasFactory;

    protected $table = 'users_area';
    protected $guarded = [];
    public $timestamps = false;
}
