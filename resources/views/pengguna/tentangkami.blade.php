@extends('pengguna.layouts.app')

@section('content')
    {{-- Include styles partial --}}
    @include('pengguna.partials.tentangkami-styles')

    {{-- Include hero section partial --}}
    @include('pengguna.partials.tentangkami-hero')

    {{-- Include mission vision section partial --}}
    @include('pengguna.partials.tentangkami-mission-vision')

    {{-- Include team section partial --}}
    @include('pengguna.partials.tentangkami-team')

    {{-- Include FAQ section partial --}}
    @include('pengguna.partials.tentangkami-faq')

    {{-- Include contact CTA section partial --}}
    @include('pengguna.partials.tentangkami-cta')

    {{-- Include scripts partial --}}
    @include('pengguna.partials.tentangkami-scripts')
@endsection
