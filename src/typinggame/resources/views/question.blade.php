@extends('layouts.app')

@section('content')
    <drill-play
        :drill="{{ $drill }}"
        :user-id="{{ $user_id }}">
    </drill-play>
@endsection
