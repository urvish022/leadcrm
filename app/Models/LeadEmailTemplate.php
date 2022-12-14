<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadEmailTemplate extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['created_at','updated_at','deleted_at'];

    public $fillable = [
        'category_id',
        'title',
        'subject',
        'body',
        'keywords',
        'email_type'
    ];

    const EMAIL_TYPES = ['initial','followup1','followup2','followup3','followup4','followup5','thankyou'];

    public static function getEmailTypesOptions()
    {
        return self::EMAIL_TYPES;
    }

    public function lead_category()
    {
        return $this->belongsTo(LeadCategory::class,'category_id','id');
    }
}
