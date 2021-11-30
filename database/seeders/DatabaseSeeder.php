<?php
//指令 php artisan db:seed 使用模型工廠重新產生資料，每個動物會隨機對應一筆分類資料
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal;
use App\Models\User;
use App\Models\Type;
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
        Type::truncate(); //清空types資料表 ID歸零

        //先產生type資料  
        Type::factory(5)->create();
        //建立5筆會員測試資料
        User::factory(5)->create();
        //建立一萬筆動物測試資料
        Animal::factory(10000)->create();
        //開啟外鍵約束
        Schema::enableForeignKeyConstraints();
    }
}
