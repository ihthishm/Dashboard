@extends('layout.master')

@section('title')
    Store
@endsection
@section('content')
    <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" data-bs-target="#addDetails">
        Add Details
    </button>
    {{-- <a href="{{ route('admin.exportItem') }}" class="btn btn-success">
        export Item
    </a> --}}
    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#import_item">
        Import Item
    </button> --}}
    <table class="table" id="datatable">
        <thead class="thead-dark">
            <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Name</th>
                <th scope="col" class="text-center">Place</th>
                <th scope="col" class="text-center">Phone</th>
                <th scope="col" class="text-center">image</th>
                <th scope="col" class="text-center">Action</th>
                <th scope="col" class="text-center">Is active</th>
                <th scope="col" class="text-center">Store Category</th>
                <th scope="col" class="text-center">City Name</th>
            </tr>
        </thead>
{{--
        <tbody>
            @foreach ($stores as $store)
                <tr>
                    <td scope="row">{{ $store->id }}</td>
                    <td class="text-center">{{ $store->name }}</td>
                    <td class="text-center">{{ $store->place }}</td>
                    <td class="text-center">
                        <img src="{{ asset($store->image) }}" alt="store" style="height:10vw;width:10vw" />
                    </td>
                    <td class="text-center">{{ $store->phone }}</td>

                    <td class="text-center"> <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#edit_store{{ $store->id }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#delete_store{{ $store->id }}">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.toggleStore', $store->id) }}" type='button'
                            class="@if ($store->is_active == 1) btn btn-success @else btn btn-danger @endif">
                            <i class="bi bi-power"></i>
                        </a>
                    </td>

                    <td class="text-center">
                        @if ($store->store_category_id)
                            {{ $store->store_category->name }}
                        @else
                            "No category Found"
                        @endif
                    </td>

                    <td class="text-center">
                        @if ($store->city_id)
                            {{ $store->city->name }}
                        @else
                            "No city Found"
                        @endif
                    </td>

                </tr>
            @endforeach
        </tbody> --}}
    </table>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" defer></script>
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('storeDatatable') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        className: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'text-center'
                    },
                    {
                        data: 'place',
                        name: 'place',
                        className: 'text-center'
                    },

                    {
                        data: 'phone',
                        name: 'phone',
                        className: 'text-center'
                    },

                    {
                        data: 'image',
                        name: 'image',
                        className: 'text-center'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        className: 'text-center'
                    },

                    {
                        data: 'store_category',
                        name: 'store_category.name',
                        className: 'text-center',
                        render: function(data) {
                            return data ? data.name : 'No store_category Found';
                        }
                    },
                    {
                        data: 'city',
                        name: 'city.name',
                        className: 'text-center',
                        render: function(data) {
                            return data ? data.name : 'No city Found';
                        }
                    },

                ]
            });
        });
    </script>

    {{-- Add-modal --}}

    <div class="modal fade" id="addDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="{{ route('admin.addStore') }}"enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label> Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label> Place </label>
                            <input type="text" name="place" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label> Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label> Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-controll" name="is_active">
                                <option value="0">Available </option>
                                <option value="1">Not available</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Store category id</label>
                            <select class="form-select" name="store_category_id" aria-label="Default select example">
                                @foreach ($store_categories as $store_category)
                                    <option value="{{ $store_category->id }}">{{ $store_category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>City id</label>
                            <select class="form-select" name="city_id" aria-label="Default select example">
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit-modal --}}

    @foreach ($stores as $store)
        <div class="modal fade" tabindex="-1" role="dialog" id="edit_store{{ $store->id }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit store Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <form method="POST" action="{{ route('admin.updateStore') }}" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="id" value="{{ $store->id }}">
                            <div class="form-group">
                                <label class="text-success-emphasis">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $store->name }}"
                                    placeholder="Edit Name">
                            </div>
                            <div class="form-group">
                                <label class="text-success-emphasis">Place</label>
                                <input type="text" name="place" class="form-control" value="{{ $store->place }}"
                                    placeholder="Enter Department" required>
                            </div>
                            <div class="form-group">
                                <label class="text-success-emphasis">Current Image</label>
                                <img src="{{ asset($store->image) }}" alt="doctor" style="height:10vw;width:10vw" />
                            </div>
                            <div class="form-group">
                                <label class="text-success-emphasis">Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="text-success-emphasis">Phone</label>
                                <input type="integer" name="phone" class="form-control" value="{{ $store->phone }}"
                                    placeholder="Enter here" required>
                            </div>

                            <div class="form-group">
                                <label>Store category id</label>
                                <select class="form-select" name="store_category_id" aria-label="Default select example">
                                    @foreach ($store_categories as $store_category)
                                        <option value="{{ $store_category->id }}">{{ $store_category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>City id</label>
                                <select class="form-select" name="city_id" aria-label="Default select example">
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- delete staff --}}
        {{-- <div class="modal fade" tabindex="-1" role="dialog" id="delete_store{{ $store->id }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete store</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        Do you really want to delete
                    </div>
                    <div class="modal-footer">
                        <a type="submit" class="btn btn-primary"
                            href="{{ route('admin.deletestore', $store->id) }}">Delete
                        </a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div> --}}


        <!-- Delete-Modal -->


        <div class="modal fade" id="delete_store{{ $store->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- import store --}}
    {{-- <div class="modal fade" id="import_store" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-danger" id="import_store">Import Item</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.importItem') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Store id</label>
                            <select class="form-select" name="store_id" aria-label="Default select example">
                                @foreach ($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label >Upload file</label>
                            <input type="file" name="file" class="form-control" >
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
