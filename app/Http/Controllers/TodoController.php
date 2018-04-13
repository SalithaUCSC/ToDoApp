<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class TodoController extends Controller
{
    public function index(){
        $items = Item::all();
        return view('list', compact('items'));
    }

    public function create(Request $request){
        $item = new Item;
        $item->item = $request->text;
        $item->save();
    }

    public function delete(Request $request){
        Item::where('id', $request->id)->delete();
        return $request->all();
    }

    public function update(Request $request){
        $item = Item::find($request->id);
        $item->item = $request->value;
        $item->save();
    }
}
