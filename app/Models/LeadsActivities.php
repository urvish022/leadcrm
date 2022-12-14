<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class LeadsActivities extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['created_at','updated_at','deleted_at'];

    public $fillable = [
        'lead_id',
        'updated_status',
        'reach_type',
        'notes'
    ];

    public function lead_detail()
    {
        return $this->belongsTo(Leads::class,'lead_id','id');
    }

    public function getCreatedAtAttribute($value)
    {
        $dateData = Carbon::createFromFormat('Y-m-d H:i:s',$value);
        $dateData->toAtomString();
        $dateData->setTimezone("Asia/Kolkata");

        $date = $dateData->format('d-m-Y H:i');
        
        return $date;
    }
}
