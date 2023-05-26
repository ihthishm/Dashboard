@extends('layout.master')

@section('title')
    City
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
                <th scope="col" class="text-center">Lattitude</th>
                <th scope="col" class="text-center">Longitude</th>
                <th scope="col" class="text-center">Delivery charge</th>
                <th scope="col" class="text-center">Action</th>
                <th scope="col" class="text-center">Is active</th>

            </tr>
        </thead>

        {{-- <tbody>
            @foreach ($cities as $city)
                <tr>
                    <td scope="row">{{ $city->id }}</td>
                    <td class="text-center">{{ $city->name }}</td>
                    <td class="text-center">{{ $city->latitude }}</td>
                    <td class="text-center">{{ $city->longitude }}</td>

                    <td class="text-center">{{ $city->delivery_charge }}</td>


                    <td class="text-center"> <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#edit_City{{ $city->id }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#delete_city{{ $city->id }}">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.toggleCity', $city->id) }}" type='button'
                            class="@if ($city->is_active == 1) btn btn-success @else btn btn-danger @endif">
                            <i class="bi bi-power"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody> --}}
    </table>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" defer></script>
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('cityDatatable') }}",
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
                        data: 'latitude',
                        name: 'latitude',
                        className: 'text-center'
                    },
                    {
                        data: 'longitude',
                        name: 'longitude',
                        className: 'text-center'
                    },
                    {
                        data: 'delivery_charge',
                        name: 'delivery_charge',
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

                    <form method="POST" action="{{ route('admin.addCity') }}"enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label> Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label> Lattitude </label>
                            <input type="integer" name="latitude" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label> Longitude</label>
                            <input type="integer" name="longitude" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label> Fair</label>
                            <input type="integer" name="deliver_charge" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-controll" name="is_active">
                                <option value="0">Available </option>
                                <option value="1">Not available</option>
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
    @foreach ($cities as $city)
    <div class="modal fade" id="edit_City{{ $city->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <form method="POST" action="{{ route('admin.updateCity') }}" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="id" value="{{ $city->id }}">
                            <div class="form-group">
                                <label class="text-success-emphasis">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $city->name }}"
                                    placeholder="Edit Name">
                            </div>
                            <div class="form-group">
                                <label class="text-success-emphasis">Latitude</label>
                                <input type="integer" name="latitude" class="form-control"
                                    value="{{ $city->latitude }}" placeholder="Enter Department" required>
                            </div>

                            <div class="form-group">
                                <label class="text-success-emphasis">Longitude</label>
                                <input type="integer" name="longitude" class="form-control"
                                    value="{{ $city->longitude }}" placeholder="Enter here" required>
                            </div>

                            <div class="form-group">
                                <label class="text-success-emphasis">Fair</label>
                                <input type="integer" name="delivery_charge" class="form-control"
                                    value="{{ $city->delivery_charge }}" placeholder="Enter here" required>
                            </div>



                            {{-- <div class="form-group">
                                <label>city id</label>
                                <select class="form-select" name="store_id" aria-label="Default select example">
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}"
                                            @if ($store->id == $store->store->id) selected @endif>{{ $store->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

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


        @foreach ($cities as $city)
        <div class="modal fade" id="delete_city{{ $city->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
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
