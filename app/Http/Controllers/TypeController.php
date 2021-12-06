<?php

namespace App\Http\Controllers;

use App\Http\Resources\TypeCollection;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\TypeResource;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;


class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * $this->middleware() 方法使用Laravel 功能中介層，第一個參數傳入系統註冊的中介層名稱auth，
     * 第二個參數傳入一個陣列，使用except當key值，表示這個Controller中除了index(查詢清單)、
     * show(查詢單一資源)不需要驗證身分，其他必需認證才可以操作，反之還有only的key可以使用。
     */ 
    public function __construct(){
        $this->middleware('auth:api',['except'=>['index','show']]);
    }

    public function index()
    {
        //考量到分類少直接全部輸出
        // $types = Type::get();
        $types = Type::select('id','name','sort')->get();
        
        // return response(['data'=>$types],Response::HTTP_OK);
        return new TypeCollection($types);
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
    public function store(StoreTypeRequest $request)
    {
        // $this->validate($request,[ //另外一種驗證的寫法，使用陣列傳入驗證關鍵字
        //     'name' =>['required','max:50',Rule::unique('types','name')],  //types資料表中name欄位資料是唯一值
        //     'sort' => 'nullable|integer',
        // ]);

        //如果沒有傳入sort欄位內容
        if(!isset($request->sort)){
            //找到目前資料表的排序欄位最大值
            $max = Type::max('sort');
            $request['sort'] = $max + 1; //最大值加1寫入請求的資料表
        }

        $type = Type::create($request->all()); //寫入資料庫
        // return response(['data'=>$type],Response::HTTP_CREATED);
        return new TypeResource($type);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        // return response(['data'=>$type],Response::HTTP_OK);
        return new TypeResource($type);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTypeRequest $request, Type $type)
    {
        // $this->validate($request,[
        //                         //更新時排除自己自己的名稱後，檢查是否為唯一值
        //     'name' =>['max:50',Rule::unique('types','name')->ignore($type->name,'name')],
        //     'sort' => 'nullable|integer',
        // ]);

        $type->update($request->all());
        // return response(['data'=>$type],Response::HTTP_OK);
        return new TypeResource($type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $type->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
