<?php

namespace App\Http\Controllers;

use App\Category;
use App\Drill;
use App\Http\Requests\DrillStore;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DrillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();

        return view('register', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DrillStore $request)
    {
        //ファットコントローラー　リファクタ必須
        $user_id = Auth::id();
        $title = $request->input('title');
        $category_id = $request->input('category_id');
        $difficulty = $request->input('difficulty');

        $drill = Drill::create([
            'user_id' => $user_id,
            'category_id' => $category_id,
            'title' => $title,
            'difficulty' => $difficulty
        ]);
        $drill_id = $drill->id; //LastInsertIdと同義
        $question1 = $request->input('question1');
        $question2 = $request->input('question2');
        $question3 = $request->input('question3');
        $question4 = $request->input('question4');
        $question5 = $request->input('question5');

        if(!empty($request->input('question6'))) {
            $question6 = $request->input('question6');
        } else {
            $question6 = '';
        }
        if(!empty($request->input('question7'))) {
            $question7 = $request->input('question7');
        } else {
            $question7 = '';
        }
        if(!empty($request->input('question8'))) {
            $question8 = $request->input('question8');
        } else {
            $question8 = '';
        }
        if(!empty($request->input('question9'))) {
            $question9 = $request->input('question9');
        } else {
            $question9 = '';
        }
        if(!empty($request->input('question10'))) {
            $question10 = $request->input('question10');
        } else {
            $question10 = '';
        }

        Question::create([
            'drill_id' => $drill_id,
            'question' => $question1,
            'order' => 1
        ]);
        Question::create([
            'drill_id' => $drill_id,
            'question' => $question2,
            'order' => 2
        ]);
        Question::create([
            'drill_id' => $drill_id,
            'question' => $question3,
            'order' => 3
        ]);
        Question::create([
            'drill_id' => $drill_id,
            'question' => $question4,
            'order' => 4
        ]);
        Question::create([
            'drill_id' => $drill_id,
            'question' => $question5,
            'order' => 5
        ]);
        Question::create([
            'drill_id' => $drill_id,
            'question' => $question6,
            'order' => 6
        ]);
        Question::create([
            'drill_id' => $drill_id,
            'question' => $question7,
            'order' => 7
        ]);
        Question::create([
            'drill_id' => $drill_id,
            'question' => $question8,
            'order' => 8
        ]);
        Question::create([
            'drill_id' => $drill_id,
            'question' => $question9,
            'order' => 9
        ]);
        Question::create([
            'drill_id' => $drill_id,
            'question' => $question10,
            'order' => 10
        ]);

        return redirect('/mypage')->with('flash_message', '登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!ctype_digit($id)) {
            return redirect(route('index'))->with('flash_message', __('不正な操作が行われました'));
        }

        $drill = Drill::with(['quenstios', 'category', 'user'])->where('id', $id)->get();

//        dd(json_decode(json_encode($drill)));

        $userId = empty(Auth::user()->id) ? 0 : Auth::user()->id;//ログインすればスコア登録できます用


        return view('question', ['drill' => $drill, 'user_id' => $userId]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!ctype_digit($id)) {
            return redirect(route('index'))->with('flash_message', __('不正な操作が行われました'));
        }
        $categories = Category::all();
        $drill = Drill::with('quenstios')->where('id', $id)->get();

//        dd(json_decode(json_encode($drill)));

        return view('edit' , ['categories' => $categories, 'drill' => $drill]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DrillStore $request, $id)
    {
        //drillのアップデート作業
        $user_id = Auth::id();
        $drill_table = array('user_id' => $user_id, 'title' => $request->input('title'), 'category_id' => $request->input('category_id'), 'difficulty' => $request->input('difficulty'));

        Drill::find($id)->fill($drill_table)->save();

        //quenstionのアップデート作業
        //
        //fill => 'drill_id', 'question', 'order'

        $quenstion_table1 = array('drill_id' => $id, 'question' => $request->input('question1'), 'order' => 1);
        Question::where('drill_id', $id)->where('order', 1)->first()->fill($quenstion_table1)->save();

        $quenstion_table2 = array('drill_id' => $id, 'question' => $request->input('question2'), 'order' => 2);
        Question::where('drill_id', $id)->where('order', 2)->first()->fill($quenstion_table2)->save();

        $quenstion_table3 = array('drill_id' => $id, 'question' => $request->input('question3'), 'order' => 3);
        Question::where('drill_id', $id)->where('order', 3)->first()->fill($quenstion_table3)->save();

        $quenstion_table4 = array('drill_id' => $id, 'question' => $request->input('question4'), 'order' => 4);
        Question::where('drill_id', $id)->where('order', 4)->first()->fill($quenstion_table4)->save();

        $quenstion_table5 = array('drill_id' => $id, 'question' => $request->input('question5'), 'order' => 5);
        Question::where('drill_id', $id)->where('order', 5)->first()->fill($quenstion_table5)->save();


        if(!empty($request->input('question6'))) {
            $quenstion_table6 = array('drill_id' => $id, 'question' => $request->input('question6'), 'order' => 6);
            Question::where('drill_id', $id)->where('order', 6)->first()->fill($quenstion_table6)->save();
        } else {
            $quenstion_table6 = array('drill_id' => $id, 'question' => '', 'order' => 6);
            Question::where('drill_id', $id)->where('order', 6)->first()->fill($quenstion_table6)->save();
        }

        if(!empty($request->input('question7'))) {
            $quenstion_table7 = array('drill_id' => $id, 'question' => $request->input('question7'), 'order' => 7);
            Question::where('drill_id', $id)->where('order', 7)->first()->fill($quenstion_table7)->save();
        } else {
            $quenstion_table7 = array('drill_id' => $id, 'question' => '', 'order' => 7);
            Question::where('drill_id', $id)->where('order', 7)->first()->fill($quenstion_table7)->save();
        }

        if(!empty($request->input('question8'))) {
            $quenstion_table8 = array('drill_id' => $id, 'question' => $request->input('question8'), 'order' => 8);
            Question::where('drill_id', $id)->where('order', 8)->first()->fill($quenstion_table8)->save();
        } else {
            $quenstion_table8 = array('drill_id' => $id, 'question' => '', 'order' => 8);
            Question::where('drill_id', $id)->where('order', 8)->first()->fill($quenstion_table8)->save();
        }

        if(!empty($request->input('question9'))) {
            $quenstion_table9 = array('drill_id' => $id, 'question' => $request->input('question9'), 'order' => 9);
            Question::where('drill_id', $id)->where('order', 9)->first()->fill($quenstion_table9)->save();
        } else {
            $quenstion_table9 = array('drill_id' => $id, 'question' => '', 'order' => 9);
            Question::where('drill_id', $id)->where('order', 9)->first()->fill($quenstion_table9)->save();
        }

        if(!empty($request->input('question10'))) {
            $quenstion_table10 = array('drill_id' => $id, 'question' => $request->input('question10'), 'order' => 10);
            Question::where('drill_id', $id)->where('order', 10)->first()->fill($quenstion_table10)->save();
        } else {
            $quenstion_table10 = array('drill_id' => $id, 'question' => '', 'order' => 10);
            Question::where('drill_id', $id)->where('order', 10)->first()->fill($quenstion_table10)->save();
        }


        return redirect('/mypage')->with('flash_message', '編集しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
