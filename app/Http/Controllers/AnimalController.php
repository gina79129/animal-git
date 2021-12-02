<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\AnimalResource;
use App\Http\Resources\AnimalCollection;


class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware('scopes:create-animals',['only'=>['store']]);
        $this->middleware('auth:api',['except'=>['index','show']]);
    }

    public function index(Request $request)
    {
        //參考網址:https://laravel.com/docs/8.x/queries
        //以下Model查詢建構器的程式碼
        // $data = Animal::where('area','高雄')->where('name','like','%小%')->get();
        //等於在資料庫中執行下方sql語法
        //select * from `animals` where area='高雄' and name like '%小%';

        //使用集合類別Illuminate\Support\Collection  pluck可以把集合中的key取出
        // $collection = collect([
        //     ['id'=>'1','name'=>'伍怡'],
        //     ['id'=>'2','name'=>'文庭淑']
        // ]);
        
        // $plucked = $collection->pluck('name');
        // $plucked->all();

        //從資料庫讀取資料之後，想如何整理資料可以參考Laravel集合官方文件，各種方法及範例都有
        //https://laravel.com/docs/8.x/collections#the-enumerable-contract

        //設定預設值
        $limit = $request->limit ?? 10; //未設定預設值為10

        //使用網址設定為快取檔案名稱
        //取得網址
        $url = $request->url();
        //取得query的參數， 例如:?limit=5&page=2 網址問號後面的參數
        $queryParams = $request->query();
        //每個人請求的query參數順序可能不同，使用參數第一個英文字排序
        ksort($queryParams);
        //利用http_build_query方法將查詢參數轉為字串
        $queryString = http_build_query($queryParams);
        //組合成完整網址
        $fullUrl = "{$url}?{$queryString}";

        //使用Laravel的快取方法檢查是否有快取紀錄
        if(Cache::has($fullUrl)){
            //使用return直接回傳快取資料，不做其他程式邏輯
            return Cache::get($fullUrl);
        }

        //建立查詢建構器，分段的方式撰寫SQL語句
        $query = Animal::query()->with('type');

        //查詢條件
        if(isset($request->filters)){
            $filters = explode(',',$request->filters);
            foreach($filters as $k =>$filter){
                list($k,$v) = explode(':',$filter);
                $query->where($k,'like',"%$v%");
            }
        }

        //排序方式
        if(isset($request->sorts)){
            $sorts = explode(',',$request->sorts);
            foreach($sorts as $k=>$sort){
                list($k,$v) = explode(':',$sort);
                if($v == 'asc' || $v == 'desc'){
                    $query->orderBy($k,$v);
                }
            }
        }else{
            $query->orderBy('id','desc');
        }

        //使用Model orderBy方法加入SQL語法排序條件，依照 id 由大到小排序
        $animals = $query->paginate($limit) //使用分頁方法，最多回傳$limit筆資料
                         ->appends($request->query()); //appends主要是可以將使用者請求的參數附加在分頁資訊中，
                                                         //如first_page_url網址後會包含limit參數，表示使用者請
                                                         //求時，設定?limit=10限制，回傳分頁訊息時自動加上limit
                                                         //參數方便客戶端下次再執行請求，不會忘記加篩選規則 
        
        //沒有快取記錄記住資料，並設定60秒過期，快取名稱使用網址命名
        return Cache::remember($fullUrl,60,function() use ($animals){
            // return response(['data'=>$animals,'message'=>''],Response::HTTP_OK);
            return new AnimalCollection($animals);
        });
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

        /*表單驗證的功能使用$this->validate方法撰寫，方法中傳入第一個值為使用者請求的資料$request
          第二個值是一個陣列，key指的是客戶端請求時的欄位名稱，value就是laravel表單驗證定義的驗證規則字串
          可以使用多個驗證規則，每個驗證規則使用「|」符號分隔開，串成一串文字，參考官網網址如下
          https://laravel.com/docs/8.x/validation#available-validation-rules
        */
        $this->validate($request,[
            'type_id' =>'nullable|exists:types,id', //客戶端的type_id必須存在分類資料表中，反之不存在types資料表將不允許新增以及修改，並回應type_id不是有效的資料
            'name' =>'required|string|max:255', //必填文字最多255字元
            'birthday' => 'nullable|date', //允許null或日期格式，使用PHP strtotime檢查傳入的日期字串
            'area' => 'nullable|string|max:255', //允許null或文字最多255字元
            'fix' => 'required|boolean', //必填並且為布林值
            'description' => 'nullable', //允許null
            'personality' => 'nullable' //允許null
        ]);

        /*
           一般會員不需要會員輸入自己的ID建立動物資源，而是使用登入狀態判斷，後續將於身分
           驗證章節修改這邊的內容，先將user_id強制寫成1寫入資料庫
         */
        $request['user_id'] = 1;

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
        return new AnimalResource($animal);

        // return response($animal,Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function show(Animal $animal)
    {
        return new AnimalResource($animal);
        // return response($animal,Response::HTTP_OK);
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
        $this->validate($request,[
            'type_id' =>'nullable|exists:types,id', //客戶端的type_id必須存在分類資料表中，反之不存在types資料表將不允許新增以及修改，並回應type_id不是有效的資料
            'name' =>'string|max:255', //文字類型最多255字元
            'birthday' => 'nullable|date', //允許null或日期格式
            'area' => 'nullable|string|max:255', //允許null或文字最多255字元
            'fix' => 'boolean', //若填寫並須是布林值
            'description' => 'nullable|string', //允許null或文字
            'personality' => 'nullable|string' //允許null或文字
        ]);

        $request['user_id'] = 1;

        $animal->update($request->all());

        return new AnimalResource($animal);
        // return response($animal,Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Animal $animal)
    {
        $animal->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
