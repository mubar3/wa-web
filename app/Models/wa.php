<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wa extends Model
{
    use HasFactory; 

    // protected $fillable = ['telpon','code'];
    protected $guarded = [];
    protected $table = 'was';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
