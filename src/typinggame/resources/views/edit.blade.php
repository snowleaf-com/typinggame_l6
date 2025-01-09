@extends('layouts.app')

@section('content')
    <edit :drill="{{ $drill }}"
          :categories="{{ $categories }}">
        @csrf
    </edit>
@endsection
