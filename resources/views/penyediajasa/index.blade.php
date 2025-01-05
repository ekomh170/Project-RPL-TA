@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <!-- Page Title -->
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Penyedia Jasa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Data Penyedia Jasa</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                @foreach($penyediajasa as $jasa)
                    <div class="col-lg-4 col-6">
                        <div class="small-box" style="background-color: #F07423; border-radius: 10px; padding: 10px;">
                            <div class="inner text-white">
                                <h1>Nama : {{ $jasa->nama }}</h1>
                                <p>{{ $jasa->email }}</p>
                                <p>No telp : {{ $jasa->telpon }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-lg-4 col-6">
                    <div class="small-box" style="background-color: #F07423; border-radius: 10px; padding: 10px;">
                        <div class="inner text-white">
                            <h1>Pantau Pesanan</h1>
                        </div>
                    </div>
                </div>
            </div>

            

            <!-- Job Orders Table -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #f8f9fa;">
                            <h3 class="card-title">Daftar Penydia jasa</h3>
                            <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addJobOrderModal">
                                <i class="fas fa-plus"></i> Add Job Order
                            </button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead style="background-color: #f8f8ff; text-align: center;">
                                    <tr>
                                        <th>Nama Pelanggan</th>
                                        <th>Alamat</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Type</th>
                                        <th>Pembayaran</th>
                                        <th>Informasi Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobOrders as $order)
                                        <tr>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->location ?? 'Belum isi alamat' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($order->tanggal_pelaksanaan)->format('d M Y') }}</td>
                                            <td>{{ $order->waktu_kerja }}</td>
                                            <td>{{ $order->nama_jasa ?? 'Isi Penyedia Jasa Terlebih Dahulu' }}</td>
                                            <td>
                                                <span class="badge"
                                                    style="background-color: {{ $order->pembayaran == 'Online' ? '#d4edda' : '#f8d7da' }}; color: #000;">
                                                    {{ ucfirst($order->pembayaran) }}
                                                </span>
                                            </td>
                                            <td>{{ $order->informasi_pembayaran ?? 'Isi Penyedia Jasa Terlebih Dahulu' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal Add Job Order -->
            <div class="modal fade" id="addJobOrderModal" tabindex="-1" role="dialog" aria-labelledby="addJobOrderModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('add-penyediajasa') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addJobOrderModalLabel">Tambah Penyedia Jasa</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="telpon">Telpon</label>
                                    <input type="text" name="telpon" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select name="gender" class="form-control" required>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="foto">Foto</label>
                                    <input type="file" name="foto" class="form-control-file" accept=".jpg,.jpeg,.png" required>
                                </div>
                            </div>
            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        

    </div>
@endsection
