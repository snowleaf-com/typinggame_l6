@extends('layouts.app')

@section('content')
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-5 text-center">{{ Auth::user()->name . __("のマイページ") }}</h1>
            <section class="tab">
                <ul class="tab__label">
                    <li><a href="#" class="active" data-id="tab__info">作成問題一覧</a></li>
                    <li><a href="#" data-id="tab__product">スコア一覧</a></li>
                </ul>
                <section class="tab__content active" id="tab__info">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">タイトル</th>
                                <th scope="col">ジャンル</th>
                                <th scope="col">難易度</th>
                                <th scope="col">編集</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($my_drills as $my_drill)
                            <tr>
                                <td scope="row"><a href="{{ route('show', ['id' => $my_drill->id ]) }}">{{ $my_drill->title }}</a></td>
                                <td>{{ $my_drill->category->category_name }}</td>
                                <td>
                                    @if($my_drill->difficulty === 5)
                                        ★★★★★
                                    @elseif($my_drill->difficulty === 4)
                                        ★★★★☆
                                    @elseif($my_drill->difficulty === 3)
                                        ★★★☆☆
                                    @elseif($my_drill->difficulty === 2)
                                        ★★☆☆☆
                                    @elseif($my_drill->difficulty === 1)
                                        ★☆☆☆☆
                                    @endif
                                </td>
                                <td><a href="{{ route('edit', ['id' => $my_drill->id]) }}">編集</a></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
                <section class="tab__content" id="tab__product">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">タイトル</th>
                                <th scope="col">スコア</th>
                                <th scope="col">更新日時</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($my_scores as $my_score)
                            <tr>
                                <td scope="row"><a href="{{ route('show', ['id' => $my_score->drill->id ]) }}">{{ $my_score->drill->title }}</a></td>
                                <td>{{ $my_score->score }}</td>
                                <td>{{ $my_score->updated_at }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </section>
        </div>
    </div>

@endsection
