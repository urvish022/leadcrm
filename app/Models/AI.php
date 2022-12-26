<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AI
 * @package App\Models
 * @version December 26, 2022, 7:06 am UTC
 *
 * @property id] $[[id
 */
class AI extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'ai';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'title',
        'content'
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
        'title'=>'required',
        'content'=>'required'
    ];


}
