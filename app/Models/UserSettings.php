<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    use HasFactory;

    public $fillable = ['followup_interval_days','email_signature','mail_type','mail_host','mail_port','mail_username','mail_password','mail_encryption','mail_from_address','mail_from_name','bcc_name'];
    protected $dates = ['created_at','updated_at'];
}
