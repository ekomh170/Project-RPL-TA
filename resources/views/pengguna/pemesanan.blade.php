@extends('pengguna.layouts.app')

@section('content')
    {{-- Include styles partial --}}
    @include('pengguna.partials.pemesanan-styles')

    {{-- Include login required alert for non-authenticated users --}}
    @include('pengguna.partials.login-required-alert')

    {{-- Include flash messages --}}
    @include('pengguna.partials.flash-messages')

    {{-- Include page header partial --}}
    @include('pengguna.partials.pemesanan-header')

    {{-- Include add order modal partial --}}
    @include('pengguna.partials.pemesanan-add-modal')

    {{-- Include active orders section partial --}}
    @include('pengguna.partials.pemesanan-active-orders')

    {{-- Include scripts partial --}}
    @include('pengguna.partials.pemesanan-scripts')
@endsection
