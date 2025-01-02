@extends('layouts.admin')

@section('title', 'Transactions')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Transactions</h1>
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
                <h6 class="m-0 font-weight-bold text-primary">Transactions List</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Service Provider</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td>{{ $transaction->penyediaJasa->name }}</td>
                                    <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                    <td>
                                        <span
                                            class="badge
                                        @if ($transaction->status === 'completed') badge-success
                                        @elseif($transaction->status === 'pending') badge-warning
                                        @else badge-danger @endif">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('transactions.show', $transaction->id) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No transactions available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
