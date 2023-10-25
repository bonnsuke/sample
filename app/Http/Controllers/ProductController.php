<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Type;
use App\Models\User;

class ProductController extends Controller
{
    // product-listでデータを取得する
    public function index(Request $request )
    { 
        $query = Item::query();
        $keyword = $request->input('keyword');
        if(!empty($keyword)) { 
           // もしも、$keywordの中身が空ではない場合に検索処理実行
            $query->where('name', 'LIKE', "%{$keyword}%")
            ->orWhere('detail', 'LIKE', "%{$keyword}%")
            // 種別名による絞り込みは、関連するテーブルを使用
            ->orWhereHas('type', function ($query) use ($keyword) {
                $query->where('type_name', 'LIKE', "%{$keyword}%");
            });
        }
        $items= $query->get();
        return view('/stocks/product-list', [
            'items' => $items,
        ]);
        
    }

    // 登録画面へ
    public function create()
    {
        $types = Type::all();
        return view('/stocks/product-registration')->with(['types'=>$types]);
    }

    // home画面へ
    public function show()
    {
        return view('/stocks/product-home');
    }


    // 商品を登録する
    public function store(Request $request)
    {

    $this->validate($request, [
        'name' => 'required',
        'type_id' => 'required',
        'detail' => 'required',
    ]);
    Item::create([
        'user_id' => 1,
        'name' => $request->name,
        'type_id' => $request->type_id,
        'detail' => $request->detail,
    ]);
    
    return redirect('/list');
    }  

    // 会員編集
    public function edit($id)
    {
    // リクエストで渡されたidをもとにメンバーの取得をする
    // 一覧からして指定されたidと同じidを取得する
    $items =Item::where('id', '=', $id)->first();
    $types = Type::all();    
    //編集画面に持っていく
    return view('/stocks/product-edit')->with([
        'items' => $items,
        'types'=>$types,

    ]);
    }
    // 編集登録
    public function update(Request $request)
    {
        $items =Item::where('id', '=', $request->id)->first();
        $items->name=$request->name;
        $items->type_id=$request->type_id;
        $items->detail=$request->detail;
        $items->save();
        return redirect('/list');
    }

   // 商品削除
    public function destroy(Request $request, Item $items)
    {
        $item =Item::where('id', '=', $request->id)->first();
        $item->delete();
        return redirect("/list");
        
    }
	
}
