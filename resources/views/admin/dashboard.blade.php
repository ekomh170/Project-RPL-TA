@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>

        <!-- Stats Boxes -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box" style="background-color: #f0f8ff; border-radius: 10px;">
                    <div class="inner text-center">
                        <h3>{{ $totalUsers }}</h3>
                        <p>Total Pengguna</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box" style="background-color: #f9fce8; border-radius: 10px;">
                    <div class="inner text-center">
                        <h3>{{ $totalMitra }}</h3>
                        <p>Total Mitra</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box" style="background-color: #fff8dc; border-radius: 10px;">
                    <div class="inner text-center">
                        <h3>{{ $totalJobOrders }}</h3>
                        <p>Total Pesanan</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box" style="background-color: #ffe4e1; border-radius: 10px;">
                    <div class="inner text-center">
                        <h3>{{ $totalCompleted }}</h3>
                        <p>Pesanan Selesai</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Orders Table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="background-color: #f8f9fa;">
                        <h3 class="card-title">Daftar Pesanan</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead style="background-color: #f8f8ff; text-align: center;">
                                <tr>
                                    <th>Jasa</th>
                                    <th>Lokasi</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Pekerja</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jobOrders as $order)
                                    <tr>
                                        <td>{{ $order->nama_jasa }}</td>
                                        <td>{{ $order->location ?? 'Bojong' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->tanggal_pelaksanaan)->format('d M Y') }}</td>
                                        <td>{{ $order->waktu }}</td>
                                        <td>{{ $order->nama_pekerja }}</td>
                                        <td>
                                            <span class="badge"
                                                style="background-color: {{ $order->pembayaran == 'Online' ? '#d4edda' : '#f8d7da' }}; color: #000;">
                                                {{ ucfirst($order->pembayaran) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge"
                                                style="background-color: {{ $order->status == 'completed' ? '#d4edda' : '#fff3cd' }}; color: #000;">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
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
