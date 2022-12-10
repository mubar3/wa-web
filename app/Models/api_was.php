<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class api_was extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'api_was';
    protected $primaryKey = 'id';
}
