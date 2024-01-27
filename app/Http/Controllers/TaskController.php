<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Task;

class TaskController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $tasks = Task::where('status', false)->get();
    return view('tasks.index', ['tasks' => $tasks]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //バリデーション作成
    $rules = [
      'task_name' => 'required|max:100',
    ];

    $messages = [
      'required' => '必須項目です',
      'max' => '100文字以内でお願いします'
    ];

    Validator::make($request->all(), $rules, $messages)->validate();

    //新しタスクを作成する。
    $task = new task;
    //task_nameの値を代入
    $task->name = $request->input('task_name');
    //$taskをDBに保存する。
    $task->save();
    //保存した後に最初の画面に戻る
    return redirect('/tasks');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $task = Task::find($id);
    return view('tasks.edit', compact('task'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    // dd($request->status);
    if ($request->status === null) {
    $rules = [
      'task_name' => 'required|max:100',
    ];

    $messages = ['required' => '必須項目です', 'max' => '100文字以下にしてください。'];

    Validator::make($request->all(), $rules, $messages)->validate();


    //該当のタスクを検索。既存のデータベースが存在しているため、新しいインスタンス化はしないようにしています。
    $task = Task::find($id);
    //モデル->カラム名 = 値 で、データを割り当てる
    $task->name = $request->input('task_name');
    //データベースに保存
    $task->save();
  }else{
    //該当のタスクを検索
    $task = Task::find($id);
  
    //モデル->カラム名 = 値 で、データを割り当てる
    $task->status = true; //true:完了、false:未完了

    //データベースに保存
    $task->save();
  }
    //リダイレクト
    return redirect('/tasks');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    Task::find($id)->delete();
  
    return redirect('/tasks');
  }
}
