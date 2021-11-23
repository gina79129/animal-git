<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id()->comment('ID');
            //unsignedBigInteger 無符號的整數類型，只存正整數，可以存取比較大範圍的數字
            $table->unsignedBigInteger('type_id')->nullable()->comment('動物分類');
            $table->string('name')->comment("動物暱稱");
            $table->date('birthday')->nullable()->comment("生日");
            $table->string('area')->nullable()->comment("所在地區");
            $table->boolean('fix')->default(false)->comment("結紮情形");
            $table->text('description')->nullable()->comment("簡單敘述");
            $table->text('personality')->nullable()->comment("動物個性");
            $table->unsignedBigInteger('user_id')->comment("所屬會員");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animals');
    }
}
