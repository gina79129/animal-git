<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;   

class Animal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'type_id',
        'name',
        'birthday',
        'area',
        'fix',
        'description',
        'personality',
        'user_id',
    ];

    public function type(){
        //belongsTo(類別名稱，參照欄位，主鍵)
        return $this->belongsTo('App\Models\Type');
    }

}
