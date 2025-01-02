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
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalUsers }}</h3>
                        <p>Total Users</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalJobOrders }}</h3>
                        <p>Total Job Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalServices }}</h3>
                        <p>Total Services</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-settings"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $totalTransactions }}</h3>
                        <p>Total Transactions</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Revenue Box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Revenue</h3>
                    </div>
                    <div class="card-body">
                        <h4>Total Revenue: <strong>{{ number_format($totalRevenue, 2) }}</strong></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
