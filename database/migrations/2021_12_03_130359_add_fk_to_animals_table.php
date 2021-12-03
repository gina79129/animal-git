<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
 * 資料庫外鍵約束可以保持資料一致性，避免發生user_id參考不到users資料表主鍵的問題，但有一些
 * 情境不適合，例如儲存操作紀錄或是監測設備的回傳值，用於分析設備收集到的資料，資料量一定相當
 * 龐大，每次寫入資料都要去掃描大量數據是否符合外鍵約束，在大數據的情境下外鍵約束並不是一個好
 * 的選擇，所以並不是所有的情況都一定要加外鍵約束，要視情況而定，此專案要確保資料正確，使用外
 * 鍵約束相當適合
 */
class AddFkToAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 使用Schema的方法table變動animals資料表的結構，以上加入的外鍵約束都是使用刪除時觸發，
         * 並使用到兩種模式，第一種是刪除會員，動物資料也跟著刪除，第二種刪除分類資料時type_id設
         * 為type_id設為null，還有一種可以不需要設定onDelete方法，如果設定在user_id參照欄位，表
         * 示刪除會員時，如果animals有相關資料，不允許刪除會員
         */
        Schema::table('animals', function (Blueprint $table) {
            $table->foreign('user_id') //animals資料表 user_id參照欄位
                  ->references('id')->on('users') //參照users資料表的id
                  ->onDelete('cascade');
                  //若users刪除，動物資料表一起刪除

            $table->foreign('type_id') //animals 資料表 type_id參照欄位
                  ->references('id')->on('types') //參照types資料表的id
                  ->onDelete('set null');
                  //若types刪除，相關動物資料表type_id 設為null
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /**
         * down方法，恢復資料庫的部分，如下範例所示，up方法中做了什麼變動，這邊將所有動作
         * 復原，恢復的動作建議都先刪除資料庫外鍵的設定，然後再做其他復原動作，因為有時候
         * 會因為外鍵約束卡住無法刪除欄位或資料表
         * 刪除資料庫外鍵，預設會使用「這個資料表的名稱_參照欄位名稱_foreign」的方式命名資料庫外鍵
         */
        Schema::table('animals', function (Blueprint $table) {
            $table->dropForeign('animals_user_id_foreign');
            $table->dropForeign('animals_type_id_foreign');
        });
    }
}
