@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">User Details</h1>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>

        <!-- User Details -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">User #{{ $user->id }}</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Name:</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Role:</th>
                        <td>{{ ucfirst($user->role) }}</td>
                    </tr>
                    <tr>
                        <th>Created At:</th>
                        <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At:</th>
                        <td>{{ $user->updated_at->format('d M Y, H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
