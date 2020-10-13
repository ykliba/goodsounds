<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\User; 

class CreateReviewController extends Controller
{
  protected $validationRules = [
		"title" => ["required", "string"],
		"artist" => ["required", "string"],
		"desc" => ["required", "string"],
		"image" => ["required", "string"],
		"link" => ["nullable", "string"]
	];

	function __construct(){
		$this->middleware('auth');
		}
		
		function create(){
			return view("review.create_review");
		}

		function store(Request $request){
			//入力値の受け取り
			$validatedData = $request->validate($this->validationRules);
	
			//作成するユーザーIDを設定\
			$validatedData["user_id"] = \Auth::id();
	
			//レビューの保存
			$new = Review::create($validatedData);
			
			//登録後はダッシュボードに遷移
			return redirect()->route("dashboard")
			  ->withStatus("Review: {$new->title}を作成しました");
    }
}
