<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lead_category';

    public static $rules = [
        'category_name' => 'required|unique:lead_category',
    ];

    public $fillable = [
        'category_name'
    ];

    public function mail_templates()
    {
        return $this->hasMany(LeadEmailTemplate::class,'category_id','id');
    }

    public function leads()
    {
        return $this->hasMany(Leads::class,'category_id','id');
    }
}
