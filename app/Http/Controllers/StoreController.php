<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Store;
use App\Models\StoreCategory;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function viewStore()
    {
        $stores=Store::get();
        $store_categories=StoreCategory::get();
        $cities=City::get();
        return view('Stores.viewStore',compact('stores','store_categories','cities'));
    }

    public function addStore(Request $request)
    {
        $stores = new Store();
        $stores->name = $request->name;
        $stores->place = $request->place;
        $stores->phone = $request->phone;
        if ($request->file('image')) {
                $image_var = $request->file('image');
                $name = $image_var->getClientOriginalName();
                $filename = time() . '.' . $name;
                $image_var->move(public_path('/lists/'), $filename);
                $stores->image = 'lists/' . $filename;

        }

        $stores->store_category_id = $request->store_category_id;
        $stores->city_id=$request->city_id;
        $stores->save();
        return redirect()->back();
    }
    public function toggleStore($id)
    {

        $stores = Store::where('id', $id)->first();
        $stores->is_active = !$stores->is_active;
        $stores->save();
        return redirect()->back();
    }
    public function deleteStore($id)
    {
        $stores = Store::where('id', $id)->first();
        $stores->delete();
        return redirect()->back();
    }
    public function updateStore(Request $request)
    {
        $stores = Store::where('id', $request->id)->first();
        $stores->name = $request->name;
        $stores->place = $request->place;
        $stores->phone = $request->phone;

        if ($request->file('image')) {
            if ($stores->image) {
                @unlink(public_path($stores->image));
                $image_var = $request->file('image');
                $name = $image_var->getClientOriginalName();
                $filename = time() . '.' . $name;
                $image_var->move(public_path('/lists/'), $filename);
                $stores->image = 'lists/' . $filename;
            } else {
                $image_var = $request->file('image');
                $name = $image_var->getClientOriginalName();
                $filename = time() . '.' . $name;
                $image_var->move(public_path('/lists/'), $filename);
                $stores->image = 'lists/' . $filename;
            }
        }

        $stores->store_category_id = $request->store_category_id;
        $stores->city_id=$request->city_id;
        $stores->save();
        return redirect()->back();
    }

    // public function viewEach($id)
    // {
    //     $each = Store::where('store_id',$id)->get();
    //     return view('viewEach', compact('each'));
    // }
    // public function exportStore(Request $request)
    // {
    //     $stores = Excel::download(new StoreExport, 'Store.xlsx');
    //     return $stores;
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
