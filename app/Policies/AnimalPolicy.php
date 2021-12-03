<?php

namespace App\Policies;

use App\Models\Animal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnimalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    /**
     * before 判斷原則之前都會先經過這一個地方 column:回傳false表示無權限，回傳true表示允許操作，沒有回傳值開始執行相關的原則
     * viewAny 查看所有資源資料 column:不需要登入就可以請求API
     * view 看單一資源詳細資料 column:不需要登入就可以請求API
     * 
     * 以下備註:判斷user的id是不是等於animal的user_id，只讓會員自己修改、刪除、復原刪除、強制刪除自己的動物資料
     * create 建立資源資料 全部會員都可以建立動物資料，回傳true即可
     * update 修改資源資料
     * delete 刪除資源資料
     * restore 復原軟體刪除，類似資料丟到垃圾桶後，要再把資源救回來時的邏輯判斷
     * forceDelete 軟體刪除後，強制刪除資料表的動物資料，類似資源丟到垃圾桶後，要永久刪除資料時的邏輯判斷
     */

    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Animal $animal)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Animal $animal)
    {
        //只有刊登動物的會員可以更新自己的動物資料
        return $user->id === $animal->user_id;
        /**
         * 如上所示簡單的判斷，會傳入兩個參數，第一個參數是會員的實體物件，會自動綁定並傳入
         * 方法中，第二個參數為檢查權限，傳入要變更的資料庫資料，user的id要和目前要編輯的動
         * 物資料user_id相同，才回傳true反之回傳false
         */
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Animal $animal)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Animal $animal)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Animal $animal)
    {
        //
    }

    /**
     * 新增before方法後，可以在檔案中所有原則方法之前檢查，讓管理員可以操作動物資源的
     * 所有功能，如果不是管理員不回傳任何回傳值，繼續判斷其他原則，如果回傳false將禁止
     * 所有操作，其中使用Model定義的方法，isAdmin減少$user->permission=='admin'的使
     * 用，降低耦合以免日後需要修改admin字串時每個地方都需要更改，也有可能發生漏改的問題
     * 因而產生系統錯誤
     */
    public function before($user,$ability){
        //利用User Model定義的isAdmin方法判斷
        if($user->isAdmin()){
            return true;
        }
    }
}
