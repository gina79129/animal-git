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
     * 取得動物的刊登會員，一對多的反向關聯
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    /**
     * 多對多的關聯animal與user我的最愛關係
     */
    public function likes(){
        return $this->belongsToMany('App\Models\User','animal_user_likes')->withTimestamps();
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
