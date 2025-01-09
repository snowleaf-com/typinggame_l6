@extends('layouts.app')

@section('content')
        <register :categories="{{ $category }}"
                  :errors="{{ empty($errors) ? '' : $errors }}">
            @csrf
        </register>
@endsection
