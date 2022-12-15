<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailHistory extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = ['lead_id','emails','subject','body','status','delivery_status','send_time'];

    public function lead_detail()
    {
        return $this->belongsTo(Leads::class,'lead_id','id');
    }
}
