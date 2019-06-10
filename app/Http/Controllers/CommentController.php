<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Comment;
use App\Post;


class CommentController extends Controller
{
		public function __construct()
    {
        $this->middleware('web');
    }

    /**
     * Обработка формы - AJAX
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
	public function store(Request $request)
    {

		$data = $request->except('_token', 'comment_post_ID', 'comment_parent', 'submit');
		
		//добавляем поля с названиями как в таблице (модели)
		$key_field = config('comments.key_field');
		$data[$key_field] = $request->input('comment_post_ID');
		$data['parent_id'] = $request->input('comment_parent');
		
		//устанавливаем статус в зависимости от настройки
		$data['status'] = config('comments.show_immediately');


		$user = Auth::user();

		if($user) {
			$data['user_id'] = $user->id;
			$data['name'] = (!empty($data['name'])) ? $data['name'] : $user->name;
			$data['email'] = (!empty($data['email'])) ? $data['email'] : $user->email;								
		}

		$validator = Validator::make($data,[
			$key_field => 'integer|required',
			'text' => 'required',
			'name' => 'required',
			'email' => 'required|email',
		]);
		if ($validator->fails()) {
			return response()->json(['error'=>$validator->errors()->all()]);
		}
		
		$comment = new Comment($data); 

		$post = Post::find($data[$key_field]);
		$post->comments()->save($comment);
		
		$data['id'] = $comment->id;
		$data['hash'] = md5($data['email']);
		$data['status'] = config('comments.show_immediately');
		
		$view_comment = view(env('THEME').'.comments.new_comment')->with('data', $data)->render();

    return response()->json(['success'=>true, 'comment'=>$view_comment, 'data'=>$data]);

	}
}
