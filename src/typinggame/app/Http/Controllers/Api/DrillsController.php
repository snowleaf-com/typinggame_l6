<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Drill;
use App\Http\Controllers\Controller;
use App\Score;
use Illuminate\Http\Request;

class DrillsController extends Controller
{
    public function highScore(Request $request, $id)
    {
        $high_score_user_id = $request->input('high_score_user_id');
        $high_score = $request->input('high_score');

        $score_table = ['high_score' => $high_score, 'high_score_user_id' => $high_score_user_id];


        $score = Drill::find($id);
        if($score->high_score < $high_score) {
            Drill::where('id', $id)->update($score_table);
            return '全体のハイスコア更新されました';
        }
        return '全体のハイスコアは更新できませんでした';
    }

    public function score(Request $request, $id)
    {
        $score = $request->input('score');
        $user_id = $request->input('user_id');
        $drill_id = $id;

        $my_score_table = ['score' => $score, 'user_id' => $user_id, 'drill_id' => $drill_id];

        $my_score = Score::where(['user_id' => $user_id, 'drill_id' => $drill_id])->first();

        if(is_null($my_score)) {
            Score::create($my_score_table);
            return '自身のスコア記録を追加しました';
        } else {
            if($my_score->score < $score) {
                $my_score->update($my_score_table);
                return '自身のハイスコアを更新しました';
            } else {
                return '自身のハイスコアは更新されませんでした';
            }
        }
    }

    public function getDrills()
    {
        $drills = Drill::with('category', 'user', 'score_user')->latest()->paginate(5);
//        dd(json_decode(json_encode($drills)));
//        dd(view('index', compact(['categories', 'drills'])));
        return ['drills' => $drills];
    }
}
