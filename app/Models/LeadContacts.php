<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class LeadContacts
 * @package App\Models
 * @version November 25, 2022, 12:44 am UTC
 *
 */
class LeadContacts extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'lead_contacts';
    
    protected $dates = ['created_at','updated_at','deleted_at'];

    public $fillable = [
        'lead_id',
        'first_name',
        'last_name',
        'title',
        'email',
        'email_status',
        'phone',
        'linkedin_profile'
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
        
    ];


    public function leads_detail()
    {
        return $this->belongsTo(Leads::class,'lead_id','id');
    }
    
}
