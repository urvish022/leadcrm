<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Leads
 * @package App\Models
 * @version November 24, 2022, 6:27 pm UTC
 *
 */
class Leads extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'leads';

    const status = ['scrapped','initial','followup1','followup2','followup3','followup4','followup5','hold','in','out','invalid'];

    const reach_types = ['email','call','facebook','linkedin','other'];

    protected $dates = ['created_at','updated_at','deleted_at'];

    public $fillable = [
        'created_by_id',
        'category_id',
        'company_name',
        'company_email',
        'company_phone_number',
        'company_website',
        'total_employees',
        'facebook_url',
        'linkedin_url',
        'twitter_url',
        'industry_type',
        'company_origin',
        'company_state',
        'company_city',
        'company_address',
        'annual_revenue',
        'keywords',
        'status',
        'reach_type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company_name' => 'required',
        'company_website' => 'required',
        'company_origin' => 'required',
        'category_id' => 'required',
        'status' => 'required'
    ];

    public static function getAllStatus()
    {
        return self::status;
    }

    public static function getAllReachTypes()
    {
        return self::reach_types;
    }

    public function lead_contacts()
    {
        return $this->hasMany(LeadContacts::class,'lead_id','id');
    }

    public function lead_categories()
    {
        return $this->belongsTo(LeadCategory::class,'category_id','id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class,'created_by_id','id');
    }

    public function lead_activities()
    {
        return $this->hasMany(LeadsActivities::class,'lead_id','id');
    }
}
