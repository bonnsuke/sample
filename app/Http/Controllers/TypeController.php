<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Type;
use App\Models\User;

class TypeController extends Controller
{
    public function create()
    {
        // 種別登録画面へ移動
        return view('/stocks/product-type');
    }

    // 種別を登録する
    public function store(Request $request)
    {

        $this->validate($request, [
            'type_name' => 'required',
        ]);
        Type::create([
            'type_name' => $request->type_name,
        ]);
        return redirect('/list');
    }   
}
