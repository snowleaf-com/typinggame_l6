@extends('layouts.app')

@section('content')
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h2 class="display-7 text-center pb-3">
                メールアドレスを確認してください
            </h2>
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('確認メールがあなたのメールアドレスに送信されました。') }}
                        </div>
                    @endif

                    {{ __('もし、届かない場合は以下から送信してください。') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
		                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('もう1度送信する') }}</button>.
	                </form>
                </div>
            </div>
</div>
@endsection
