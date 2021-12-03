<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 不管新鍵欄位或建立外鍵約束，主要是強調，在更新需求時，不要修改原有的migration檔案，請建立
 * 一個新的migration檔案，up方法做了什麼變更，down方法就要反向過來將它復原
 */
class AddPermissionToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('permission')->default('member')->comment('帳號權限');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //使用dropColumn方法刪除permission欄位
            $table->dropColumn('permission');
        });
    }
}
