<?php

namespace App\Http\Controllers;

use App\Exports\ItemExport;
use App\Http\Controllers\Controller;
use App\Imports\ItemImport;
use App\Models\Item;
use App\Models\Store;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    public function viewItem()
    {
        $items = Item::with('store')->get();
        $stores=Store::get();
        return view('Item.viewItem', compact('items','stores'));
    }
    public function additem(Request $request)
    {
        $items = new Item();
        $items->name = $request->name;
        $items->price = $request->price;
        $items->description = $request->description;

        if ($request->file('image')) {
                $image_var = $request->file('image');
                $name = $image_var->getClientOriginalName();
                $filename = time() . '.' . $name;
                $image_var->move(public_path('/lists/'), $filename);
                $items->image = 'lists/' . $filename;
        }
        $items->store_id = $request->store_id;
        $items->save();
        return redirect()->back();
    }
    public function toggleitem($id)
    {

        $items = Item::where('id', $id)->first();
        $items->is_active = !$items->is_active;
        $items->save();
        return redirect()->back();
    }
    public function deleteitem($id)
    {
        $items = Item::where('id', $id)->first();
        $items->delete();
        return redirect()->back();
    }
    public function updateitem(Request $request)
    {
        $items = Item::where('id', $request->id)->first();
        $items->name = $request->name;
        $items->price = $request->price;
        $items->description = $request->description;

        if ($request->file('image')) {
            if ($items->image) {
                @unlink(public_path($items->image));
                $image_var = $request->file('image');
                $name = $image_var->getClientOriginalName();
                $filename = time() . '.' . $name;
                $image_var->move(public_path('/lists/'), $filename);
                $items->image = 'lists/' . $filename;
            } else {
                $image_var = $request->file('image');
                $name = $image_var->getClientOriginalName();
                $filename = time() . '.' . $name;
                $image_var->move(public_path('/lists/'), $filename);
                $items->image = 'lists/' . $filename;
            }
        }
        $items->store_id = $request->store_id;
        $items->save();
        return redirect()->back();
    }

    public function viewEach($id)
    {
        $each = Item::where('store_id',$id)->get();
        return view('viewEach', compact('each'));
    }
    // public function exportItem(Request $request)
    // {
    //     $items = Excel::download(new ItemExport, 'item.xlsx');
    //     return $items;
    // }
    // public function importItem(Request $request)
    // {
    //     $path = $request->file('file')->store('files');
    //     $filepath = storage_path('app') . '/' . $path;
    //     $import = new ItemImport();
    //     $import->receiveData($request->store_id);
    //     Excel::import($import, $filepath);
    //     return redirect()->back();

    // }

}
