<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Carbon\Carbon; //操作時間的套鍵  

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
        // 'user_id',
    ];

    public function type(){
        //belongsTo(類別名稱，參照欄位，主鍵)
        return $this->belongsTo('App\Models\Type');
    }

    /**
     * 這是一個Laravel方便的功能，可以在Model寫一個方法，名稱命名為「get某某某Attribute」
     * 如下範例getAgeAttribute方法，必須用駝峰式的命名方式，設定完成後可以使用$animal->age
     * 程式碼，Animal Model的實體物件，會自動訪問這個方法，運行完方法中的商業邏輯程式回傳結果
     */
    public function getAgeAttribute(){
        $diff = Carbon::now()->diff($this->birthday);
        return "{$diff->y}歲{$diff->m}月";
    }

}
