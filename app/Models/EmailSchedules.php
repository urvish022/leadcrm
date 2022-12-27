<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailSchedules extends Model
{
    use HasFactory, SoftDeletes;

     public $fillable = [
        'lead_id',
        'emails',
        'subject',
        'body',
        'schedule_time',
        'status'
    ];
}
