<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\Drill;
use App\User;
use App\Score;

class OthersController extends Controller
{
    public function index()
    {
        $categories = Category::all();
//        $drills = Drill::with('category', 'user', 'score_user')->latest()->paginate(2);
//
////        dd(json_decode(json_encode($drills)));
////        dd(view('index', compact(['categories', 'drills'])));
//
//        return view('index', compact(['categories', 'drills']));
        return view('index', compact(['categories']));


    }

    public function mypage()
    {
        $user_id = Auth::id();
        $my_drills = Drill::with('category')->where('user_id', $user_id)->latest()->get();
        $my_scores = Score::with('drill:id,title')->where('user_id', $user_id)->latest('updated_at')->get();

//        dd(json_decode(json_encode($my_drills)));
        return view('mypage', compact(['my_drills', 'my_scores']));
    }
}
