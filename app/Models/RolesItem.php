<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesItem extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];
    public $timestamps  = false;
}
