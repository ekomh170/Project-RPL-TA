@extends('layouts.admin')

@section('title', 'Services')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Services</h1>
            <button class="btn btn-primary" data-toggle="modal" data-target="#addServiceModal">
                <i class="fas fa-plus"></i> Add Service
            </button>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Services List</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Service Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $service)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $service->nama_jasa }}</td>
                                    <td>{{ $service->kategori }}</td>
                                    <td>Rp {{ number_format($service->harga, 0, ',', '.') }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editServiceModal{{ $service->id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('services.destroy', $service->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Service Modal -->
                                <div class="modal fade" id="editServiceModal{{ $service->id }}" tabindex="-1"
                                    aria-labelledby="editServiceModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('services.store') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="nama_jasa">Service Name</label>
                                                        <input type="text" class="form-control" name="nama_jasa"
                                                            value="{{ $service->nama_jasa }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="kategori">Category</label>
                                                        <input type="text" class="form-control" name="kategori"
                                                            value="{{ $service->kategori }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="harga">Price</label>
                                                        <input type="number" class="form-control" name="harga"
                                                            value="{{ $service->harga }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No services available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Service Modal -->
    <div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('services.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addServiceModalLabel">Add Service</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_jasa">Service Name</label>
                            <input type="text" class="form-control" name="nama_jasa" placeholder="Enter service name"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Category</label>
                            <input type="text" class="form-control" name="kategori" placeholder="Enter category"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="harga">Price</label>
                            <input type="number" class="form-control" name="harga" placeholder="Enter price"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
