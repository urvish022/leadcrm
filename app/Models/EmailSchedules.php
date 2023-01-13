<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use jdavidbakr\MailTracker\Model\SentEmail;

class EmailSchedules extends Model
{
    use HasFactory, SoftDeletes;

     public $fillable = [
        'lead_id',
        'emails',
        'subject',
        'body',
        'schedule_time',
        'status',
        'created_by_id',
        'delivery_status',
        'tracking_id',
        'timezone'
    ];

    public function leads()
    {
        return $this->belongsTo(Leads::class,'lead_id','id');
    }

    public function email_tracking()
    {
        return $this->hasOne(SentEmail::class,'hash','tracking_id');
    }
}
