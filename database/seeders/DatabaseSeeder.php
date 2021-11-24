<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal;
use App\Models\User;
use Illuminate\Support\Facades\Schema;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //取消外鍵約束
        Schema::disableForeignKeyConstraints();
        Animal::truncate(); //清空animal資料表 ID歸零
        User::truncate(); //清空users資料表 ID歸零

        //建立5筆會員測試資料
        User::factory(5)->create();
        //建立一萬筆動物測試資料
        Animal::factory(10000)->create();
        //開啟外鍵約束
        Schema::enableForeignKeyConstraints();
    }
}
