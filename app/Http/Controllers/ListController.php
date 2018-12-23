<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ListController extends Controller
{

	public function index()
	{
		$item = Item::all(); 
		return view('listtwo', compact('item'));
	}


    public function store(Request $request )
    {
    	$item = new Item;
    	$item->item = $request->text1;
    	//$item->category = $request->cate1;
    	$item->save();
    	
    }

    public function delete(Request $request)
    {
    	Item::where('id',$request->id)->delete();
    	//return $request::all();
    }

    public function update(Request $request)
    {   //return $request->all();
        $item = Item::find($request->id);
        $item->item = $request->items;
        $item->update();

    }

    public function search(Request $request)
    {
        $term = $request->term;
        $items = Item::where('item', 'LIKE', '%'.$term.'%')->get();
        //return $item;
        if (count($items) == 0) {
            $searchResult[] = 'Search Item does ';
        }else{
            foreach ($items as $item) {
                $searchResult[] = $item->item;
            }
        }
        return $searchResult;
    }


}
