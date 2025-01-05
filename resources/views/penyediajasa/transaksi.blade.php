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

            <!-- Job Orders Table -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #f8f9fa;">
                            <h3 class="card-title">Daftar Penyedia jasa</h3>
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
                                        <th>Bukti</th>
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
                                            @if($order->file)
                                                    <td>
                                                        <a href="{{ asset('storage/' . $order->bukti) }}" target="_blank">Lihat Bukti</a>
                                                    </td>
                                                @else
                                                    <td>Tidak ada Bukti yang diunggah.</td>
                                                @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
           
        

    </div>
@endsection
