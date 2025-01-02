@extends('layouts.admin')

@section('title', 'Transaction Details')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Transaction Details</h1>
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Transactions
            </a>
        </div>

        <!-- Transaction Details -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Transaction #{{ $transaction->id }}</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>User:</th>
                        <td>{{ $transaction->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Service Provider:</th>
                        <td>{{ $transaction->penyediaJasa->name }}</td>
                    </tr>
                    <tr>
                        <th>Amount:</th>
                        <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <span
                                class="badge
                            @if ($transaction->status === 'completed') badge-success
                            @elseif($transaction->status === 'pending') badge-warning
                            @else badge-danger @endif">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Created At:</th>
                        <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At:</th>
                        <td>{{ $transaction->updated_at->format('d M Y, H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
