<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipe_send extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'tipe_send';
    protected $primaryKey = 'id';
}
