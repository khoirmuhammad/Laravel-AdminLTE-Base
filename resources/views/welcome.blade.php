@extends('layouts.main',['title' => 'Blank Page'])

@section('content-header')
<h1>Selamat Datang, {{ auth()->user()->name }}</h1>
@endsection

@section('content')
<!-- Default box -->

@endsection

@push('css')
<style>
    #btn-try {
        background-color: green;
        color: white;
    }
</style>
@endpush

@push('js')
<script>
    $('#btn-try').on('click', function() {
        alert('OK')
    })
</script>
@endpush