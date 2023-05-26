<?php

namespace App\Http\Controllers;

use App\Models\StoreCategory;
use Illuminate\Http\Request;

class StoreCategoryController extends Controller
{
    public function viewStoreCategory()
    {
        $store_categories=StoreCategory::get();
        return view('StoreCategory.viewStoreCategory',compact('store_categories'));
    }

    public function addstore_category(Request $request)
    {
        $store_categories = new StoreCategory();

        $store_categories->name = $request->name;

        if ($request->file('image')) {
                $image_var = $request->file('image');
                $name = $image_var->getClientOriginalName();
                $filename = time() . '.' . $name;
                $image_var->move(public_path('/lists/'), $filename);
                $store_categories->image = 'lists/' . $filename;

        }
        $store_categories->save();
        return redirect()->back();
    }
    public function togglestore_category($id)
    {

        $store_categories = StoreCategory::where('id', $id)->first();
        $store_categories->is_active = !$store_categories->is_active;
        $store_categories->save();
        return redirect()->back();
    }
    public function deletestore_category($id)
    {
        $store_categories = StoreCategory::where('id', $id)->first();
        $store_categories->delete();
        return redirect()->back();
    }
    public function updatestore_category(Request $request)
    {
        $store_categories = StoreCategory::where('id', $request->id)->first();
        $store_categories->name = $request->name;

        if ($request->file('image')) {
            if ($store_categories->image) {
                @unlink(public_path($store_categories->image));
                $image_var = $request->file('image');
                $name = $image_var->getClientOriginalName();
                $filename = time() . '.' . $name;
                $image_var->move(public_path('/lists/'), $filename);
                $store_categories->image = 'lists/' . $filename;
            } else {
                $image_var = $request->file('image');
                $name = $image_var->getClientOriginalName();
                $filename = time() . '.' . $name;
                $image_var->move(public_path('/lists/'), $filename);
                $store_categories->image = 'lists/' . $filename;
            }
        }
        $store_categories->save();
        return redirect()->back();
    }


}
