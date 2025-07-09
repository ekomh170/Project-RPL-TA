@extends('pengguna.layouts.app')

@section('content')
    {{-- Include styles partial --}}
    @include('pengguna.partials.payment-styles')

    {{-- Include page header partial --}}
    @include('pengguna.partials.payment-header')

    {{-- Include login required alert for non-authenticated users --}}
    @include('pengguna.partials.login-required-alert')

    {{-- Include payment form partial --}}
    @include('pengguna.partials.payment-form')

    {{-- Include scripts partial --}}
    @include('pengguna.partials.payment-scripts')
@endsection
