<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Comment;
use App\Post;


class CommentController extends Controller
{
    
	public function store(Request $request){
		
		/*
		 * Cоставляем массив данных кроме указанных полей формы 
		 * (т.к. в БД данные поля называются по-другому)
		 */
		$data = $request->except('_token', 'comment_post_ID', 'comment_parent');
		
		//добавляем поля с названиями как в таблице (модели)
		$data['post_id'] = $request->input('comment_post_ID');
		$data['parent_id'] = $request->input('comment_parent');
		
		
		/*
		 * Если активен аутентифицированный пользователь
		 * то эти данные берем из таблицы users	
		 */
		$user = Auth::user(); //аутентиф.пользователь

		if($user) {
			$data['user_id'] = $user->id;
			$data['name'] = (!empty($data['name'])) ? $data['name'] : $user->name;
			$data['email'] = (!empty($data['email'])) ? $data['email'] : $user->email;								
		}
		
		
		//Проверка
		$validator = Validator::make($data,[
			'post_id' => 'integer|required',
			'text' => 'required',
			'name' => 'required',
			'email' => 'required|email',
		]);
//		/*
//		 * Дополнительная проверка при выполнении условия.
//		 * Для аутентифицированного пользователя можно не заполнять данные поля
//		 */
//		$validator->sometimes(['name','email'], 'required|max:255', function(){
//			return !Auth::check();
//		});
		
		
		/*
		 * Создаем объект для сохранения, передаем ему массив данных
		 */
		$comment = new Comment($data); 


				
		//Ошибки
		if ($validator->fails()) {	
			/*
			 * Возвращаем ответ в формате json.
			 * Метод all() переводит в массив т.к. данный формат работает или
			 * с объектами или с массивами
			 */
			return \Response::json(['error'=>$validator->errors()->all()]);
		}
		
			
		//получаем модель записи к которой принадлежит комментарий
		$post = Post::find($data['post_id']);
		/*
		 * Сохраняем данные в БД
		 * Используем связывающий метод comments()
		 * для того, чтобы автоматически заполнилось поле post_id
		 */
		$post->comments()->save($comment);
		
		
		/*
		 * Формируем массив данных для вывода нового комментария с помощью AJAX
		 * сразу после его добавления (без перезагрузки)
		 */
		$comment->load('user');
		$data['id'] = $comment->id;
		$data['hash'] = md5($data['email']);
		//Вывод шаблона сохраняем в переменную
		$view_comment = view(env('THEME').'.new_comment')->with('data', $data)->render();
		//Возвращаем AJAX вывод шаблона  с данными
		return \Response::json(['success'=>true, 'comment'=>$view_comment, 'data'=>$data]);
		
		exit;
	}
}
