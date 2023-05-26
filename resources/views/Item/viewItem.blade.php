@extends('layout.master')

@section('title')
    ITEM
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
                <th scope="col" class="text-center">Price</th>
                <th scope="col" class="text-center">Description</th>
                <th scope="col" class="text-center">image</th>
                <th scope="col" class="text-center">Store id</th>
                <th scope="col" class="text-center">Action</th>
                <th scope="col" class="text-center">Is active</th>
            </tr>
        </thead>

        {{-- <tbody>
            @foreach ($items as $item)
                <tr>
                    <td scope="row" class="text-center">{{ $item->id }}</td>
                    <td class="text-center">{{ $item->name }}</td>
                    <td class="text-center">{{ $item->price }}</td>
                    <td class="text-center">
                        <img src="{{ asset($item->image) }}" alt="item" style="height:10vw;width:10vw" />
                    </td>
                    <td class="text-center">{{ $item->description }}</td>

                    <td class="text-center">
                        @if ($item->store)
                            {{ $item->store->name }}
                        @else
                            "No store Found"
                        @endif
                    </td>

                    <td class="text-center"> <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#edit_item{{ $item->id }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#delete_item{{ $item->id }}">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.toggleitem', $item->id) }}" type='button'
                            class="@if ($item->is_active == 1) btn btn-success @else btn btn-danger @endif">
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
                ajax: "{{ route('itemDatatable') }}",
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
                        data: 'price',
                        name: 'price',
                        className: 'text-center'
                    },
                    {
                        data: 'description',
                        name: 'description',
                        className: 'text-center'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        className: 'text-center'
                    },

                    {
                        data: 'store',
                        name: 'store.name',
                        className: 'text-center',
                        render: function(data) {
                            return data ? data.name : 'No store Found';
                        }
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

                    <form method="POST" action="{{ route('admin.additem') }}"enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label> Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label> Price </label>
                            <input type="text" name="price" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label> Description</label>
                            <input type="text" name="description" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label> image</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-controll" name="is_active">
                                <option value="0">Available </option>
                                <option value="1">Not available</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Store id</label>
                            <select class="form-select" name="store_id" aria-label="Default select example">
                                @foreach ($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
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

    {{-- edit-modal --}}

    @foreach ($items as $item)
        <div class="modal fade" tabindex="-1" role="dialog" id="edit_item{{ $item->id }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit item Profile</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('admin.updateitem') }}" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <div class="form-group">
                                <label class="text-success-emphasis">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $item->name }}"
                                    placeholder="Edit Name">
                            </div>
                            <div class="form-group">
                                <label class="text-success-emphasis">Price</label>
                                <input type="number" name="price" class="form-control" value="{{ $item->price }}"
                                    placeholder="Enter Department" required>
                            </div>
                            <div class="form-group">
                                <label class="text-success-emphasis">Current Image</label>
                                <img src="{{ asset($item->image) }}" alt="doctor" style="height:10vw;width:10vw" />
                            </div>
                            <div class="form-group">
                                <label class="text-success-emphasis">IMAGE</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="text-success-emphasis">Description</label>
                                <input type="text" name="description" class="form-control"
                                    value="{{ $item->description }}" placeholder="Enter quantity" required>
                            </div>

                            <div class="form-group">
                                <label>Store id</label>
                                <select class="form-select" name="store_id" aria-label="Default select example">
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- delete staff --}}
        {{-- <div class="modal fade" tabindex="-1" role="dialog" id="delete_item{{ $item->id }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        Do you really want to delete
                    </div>
                    <div class="modal-footer">
                        <a type="submit" class="btn btn-primary"
                            href="{{ route('admin.deleteitem', $item->id) }}">Delete
                        </a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div> --}}
        <!-- Modal -->
        <div class="modal fade" id="delete_item{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
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
    {{-- <div class="modal fade" id="import_item" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-danger" id="import_item">Import Item</h1>
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
