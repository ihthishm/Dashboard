<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Item;
use Illuminate\Http\Request;

class CityController extends Controller
{

public function viewCity()
{
    $cities=City::get();
    // dd('hello');
    return view('City.viewCity',compact('cities'));
}

    public function addCity(Request $request)
    {
        $cities = new City();
        $cities->name = $request->name;
        $cities->latitude = $request->latitude;
        $cities->longitude = $request->longitude;
        $cities->delivery_charge = $request->delivery_charge;

        $cities->save();
        return redirect()->back();
    }
    public function toggleCity($id)
    {

        $cities = City::where('id', $id)->first();
        $cities->is_active = !$cities->is_active;
        $cities->save();
        return redirect()->back();
    }
    public function deleteCity($id)
    {
        $cities = City::where('id', $id)->first();
        $cities->delete();
        return redirect()->back();
    }
    public function updateCity(Request $request)
    {
        $cities = City::where('id', $request->id)->first();
        $cities->name = $request->name;
        $cities->latitude = $request->latitude;
        $cities->longitude = $request->longitude;
        $cities->delivery_charge = $request->delivery_charge;

        $cities->save();
        return redirect()->back();
    }

    // public function viewEach($id)
    // {
    //     $each = Item::where('store_id',$id)->get();
    //     return view('viewEach', compact('each'));
    // }
    // public function exportItem(Request $request)
    // {
    //     $cities = Excel::download(new ItemExport, 'item.xlsx');
    //     return $cities;
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
