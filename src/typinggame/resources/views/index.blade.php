@extends('layouts.app')

@section('content')
    <top-page :categories="{{ $categories }}"></top-page>
@endsection
