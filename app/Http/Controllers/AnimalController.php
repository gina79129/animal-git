<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //$request 指使用者請求時輸入的資料，表示這個參數要屬於Request類別才可以被方法接受
    public function store(Request $request)
    {
        //把使用者請求資料用all()方式轉為陣列，傳入create()方法中
        $animal = Animal::create($request->all());
        /*
          上面寫入資料庫後不會再對資料庫做一次查詢動作，有些欄位如果沒有填寫，資料庫直接給予預設值，
          程式方面若回傳$animal物件，沒有填寫的欄位就不會顯示，因此如果需要回傳完整的欄位資料，可以
          使用refresh方法，再查詢一次資料庫，得到該筆的完整資料。
        */
        $animal = $animal->refresh();
        /*
          使用Laravel寫好的輔助方法response()。第一個傳入變數$animal，將成功寫入資料庫以後，產生
          出來的實體物件資料，包含在HTTP協定的內容中回傳給客戶端，第二個參數設定的HTTP狀態，可以直
          接輸入HTTP狀態碼201表示「成功建立」的意思或用Symfony套件寫好的常數
        */
        return response($animal,Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function show(Animal $animal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function edit(Animal $animal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Animal $animal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Animal $animal)
    {
        //
    }
}
