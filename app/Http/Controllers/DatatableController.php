<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Item;
use App\Models\Store;
use App\Models\StoreCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DatatableController extends Controller
{
    public function cityDatatable()
    {
        $cities = City::get();
        return DataTables::of($cities)->addIndexColumn()
            ->addColumn('name', function ($city) {
                return $city->name;
            })
            ->addColumn('latitude', function ($city) {
                return $city->latitude;
            })
            ->addColumn('longitude', function ($city) {
                return $city->longitude;
            })

            ->addColumn('delivery_charge', function ($city) {
                return $city->delivery_charge;
            })

            ->addColumn('action', function ($city) {
                $btn = '<button type="button" class="btn btn-danger mr-1" data-bs-toggle="modal" data-bs-target="#delete_city' . $city->id . '"><i class="bi bi-trash-fill"></i></button>
                <button type="button" class="btn btn-primary" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit_City' . $city->id . '"><i class="bi bi-pencil-square"></i></button>';
                return $btn;
            })

            ->addColumn('is_active', function ($city) {
                if ($city->is_active) {
                    $stat = '<a href="' . route('admin.toggleCity', $city->id) . '" class="btn btn-success"><i class="bi bi-power"></i></a>';
                } else {
                    $stat = '<a href="' . route('admin.toggleCity', $city->id) . '" class="btn btn-danger"><i class="bi bi-power"></i></a>';
                }
                return $stat;
            })

            ->rawColumns(['name', 'latitude', 'longitude', 'delivery_charge', 'action', 'is_active'])
            ->make(true);
    }


    public function itemDatatable()
    {
        $items = Item::get();
        return DataTables::of($items)->addIndexColumn()
            ->addColumn('name', function ($item) {
                return $item->name;
            })
            ->addColumn('price', function ($item) {
                return $item->price;
            })
            ->addColumn('description', function ($item) {
                return $item->description;
            })

            ->addColumn('image', function ($item) {
                return $item->image;
            })

            ->editColumn('store.name', function ($item) {
                return $item->store ? $item->store->name : 'No store Found';
            })

            ->addColumn('action', function ($item) {
                $btn = '<button type="button" class="btn btn-danger mr-1" data-bs-toggle="modal" data-bs-target="#delete_item' . $item->id . '"><i class="bi bi-trash-fill"></i></button>
                <button type="button" class="btn btn-primary" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit_item' . $item->id . '"><i class="bi bi-pencil-square"></i></button>';
                return $btn;
            })

            ->addColumn('is_active', function ($item) {
                if ($item->is_active) {
                    $stat = '<a href="' . route('admin.toggleitem', $item->id) . '" class="btn btn-success"><i class="bi bi-power"></i></a>';
                } else {
                    $stat = '<a href="' . route('admin.toggleitem', $item->id) . '" class="btn btn-danger"><i class="bi bi-power"></i></a>';
                }
                return $stat;
            })

            ->rawColumns(['name', 'price', 'description', 'image', 'action', 'is_active'])
            ->make(true);
    }

    public function storeCategoryDatatable()
    {
        $store_categories = StoreCategory::get();
        return DataTables::of($store_categories)->addIndexColumn()
            ->addColumn('name', function ($store_category) {
                return $store_category->name;
            })

            ->addColumn('image', function ($store_category) {
                return $store_category->image;
            })

            ->addColumn('action', function ($store_category) {
                $btn = '<button type="button" class="btn btn-danger mr-1" data-bs-toggle="modal" data-bs-target="#delete_store_category' . $store_category->id . '"><i class="bi bi-trash-fill"></i></button>
                <button type="button" class="btn btn-primary" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit_store_category' . $store_category->id . '"><i class="bi bi-pencil-square"></i></button>';
                return $btn;
            })

            ->addColumn('is_active', function ($store_category) {
                if ($store_category->is_active) {
                    $stat = '<a href="' . route('admin.togglestore_category', $store_category->id) . '" class="btn btn-success"><i class="bi bi-power"></i></a>';
                } else {
                    $stat = '<a href="' . route('admin.togglestore_category', $store_category->id) . '" class="btn btn-danger"><i class="bi bi-power"></i></a>';
                }
                return $stat;
            })

            ->rawColumns(['name', 'image', 'action', 'is_active'])
            ->make(true);
    }

    public function storeDatatable()
    {
        $stores = Store::with('store_category')->get();
        return DataTables::of($stores)->addIndexColumn()
            ->addColumn('name', function ($store) {
                return $store->name;
            })
            ->addColumn('place', function ($store) {
                return $store->place;
            })

            ->addColumn('phone', function ($store) {
                return $store->phone;
            })

            ->addColumn('image', function ($store) {
                return $store->image;
            })

            ->addColumn('action', function ($store) {
                $btn = '<button type="button" class="btn btn-danger mr-1" data-bs-toggle="modal" data-bs-target="#delete_store' . $store->id . '"><i class="bi bi-trash-fill"></i></button>
                <button type="button" class="btn btn-primary" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit_store' . $store->id . '"><i class="bi bi-pencil-square"></i></button>';
                return $btn;
            })

            ->addColumn('is_active', function ($store) {
                if ($store->is_active) {
                    $stat = '<a href="' . route('admin.toggleStore', $store->id) . '" class="btn btn-success"><i class="bi bi-power"></i></a>';
                } else {
                    $stat = '<a href="' . route('admin.toggleStore', $store->id) . '" class="btn btn-danger"><i class="bi bi-power"></i></a>';
                }
                return $stat;
            })

            ->addColumn('store_category', function ($store) {
                return $store->store_category ? $store->store_category : null;
            })
            ->editColumn('store_category.name', function ($store) {
                return $store->store_category ? $store->store_category->name : 'No store_category Found';
            })
            ->addColumn('city', function ($store) {
                return $store->city ? $store->city : null;
            })
            ->editColumn('city.name', function ($store) {
                return $store->city ? $store->city->name : 'No city Found';
            })

            ->rawColumns(['name', 'place','phone', 'image', 'action', 'is_active', 'store_category_id', 'city_id'])
            ->make(true);
    }


}
