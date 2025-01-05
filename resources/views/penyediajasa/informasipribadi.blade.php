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
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #f8f9fa;">
                            <h3 class="card-title">Daftar Penyedia jasa</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead style="background-color: #f8f8ff; text-align: center;">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No Telpon</th>
                                        <th>Gender</th>
                                        <th>Alamat</th>
                                        <th>Tanggal Lahir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penyediajasa1 as $pekerja)
                                        <tr>
                                            <td>{{ $pekerja->nama }}</td>
                                            <td>{{ $pekerja->email }}</td>
                                            <td>{{ $pekerja->telpon }}</td>
                                            <td>{{ $pekerja->gender }}</td>
                                            <td>{{ $pekerja->alamat }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pekerja->tanggal_lahir)->format('d M Y') }}</td>
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
