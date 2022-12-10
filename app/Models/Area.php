<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table        = 'work_area';
    protected $fillable     = ['area','area_status','userinput','area_singkatan'];
    protected $primaryKey   = 'workarea_id';
    public $timestamps      = false;

    public function region(){
        return $this->belongsTo(Region::class, 'region_id');
    }
}
