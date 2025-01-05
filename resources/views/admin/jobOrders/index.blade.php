@extends('layouts.admin')

@section('title', 'Job Orders')

@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-md-12">
                <h1 class="h3">Job Orders</h1>
            </div>
        </div>

        <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Job Orders Table -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Job Orders List</h3>
                <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addJobOrderModal">
                    <i class="fas fa-plus"></i> Add Job Order
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pembayaran</th>
                            <th>Nama Pekerja</th>
                            <th>Waktu Kerja</th>
                            <th>Nama Jasa</th>
                            <th>Harga Penawaran</th>
                            <th>Tanggal Pelaksanaan</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobOrders as $jobOrder)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $jobOrder->pembayaran }}</td>
                                <td>{{ $jobOrder->penyediajasa->nama }}</td>
                                <td>{{ $jobOrder->waktu_kerja }}</td>
                                <td>{{ $jobOrder->nama_jasa }}</td>
                                <td>{{ number_format($jobOrder->harga_penawaran, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($jobOrder->tanggal_pelaksanaan)->format('d-m-Y') }}</td>
                                <td>
                                    <form action="{{ route('jobOrders.destroy', $jobOrder->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this job order?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No Job Orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Add Job Order -->
    <div class="modal fade" id="addJobOrderModal" tabindex="-1" role="dialog" aria-labelledby="addJobOrderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('jobOrders.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addJobOrderModalLabel">Add Job Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="pembayaran">Pembayaran</label>
                            <input type="text" name="pembayaran" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="informasi_pembayaran">Informasi Pembayaran</label>
                            <textarea name="informasi_pembayaran" class="form-control" required placeholder="Masukkan informasi pembayaran"></textarea>
                        </div>
                        <div class="col-12 mb-15">
                            <label for="pekerja">Pilih Pekerja</label>
                            <select class="form-control" name="nama_pekerja" required>
                                <option hidden>Pilih Pekerja</option>
                                @foreach ($pekerja as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="waktu_kerja">Waktu Kerja </label>
                            <input type="text" name="waktu_kerja" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_jasa">Nama Jasa</label>
                            <input type="text" name="nama_jasa" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="harga_penawaran">Harga Penawaran</label>
                            <input type="number" name="harga_penawaran" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_pelaksanaan">Tanggal Pelaksanaan</label>
                            <input type="date" name="tanggal_pelaksanaan" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" name="gender" required>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Pekerjaan</label>
                            <textarea name="deskripsi" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
