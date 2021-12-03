<?php

namespace App\Http\Controllers\Api\Animal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animal;
use Symfony\Component\HttpFoundation\Response;

class AnimalLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        /**
         * 一定要加入中介層auth，必須要登入才可以使用
         * 另外一方面，沒有加入中介層下方auth()無法讀取到會員登入資訊
         */
        $this->middleware('auth:api');
    }

    //記得傳入網址{animal}參數，Laravel會自動綁定
    public function index(Animal $animal)
    {
        return $animal->likes()->paginate(10);
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
    //記得傳入網址{animal}參數，Laravel會自動綁定
    public function store(Request $request,Animal $animal)
    {
        $result = $animal->likes()->toggle(auth()->user()->id);
        return response($result,Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
