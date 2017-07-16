<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Comment;

class TestCommentsSeeder extends Seeder
{
    public function run()
    {		
	
		/*
		 * Таблица (постов, записей, рубрик и тд.) к которой привязывается каждый комментарий
		 */
		$key_field = config('comments.key_field');
		
	
		/*
		 * id этой связанной таблицы к которому будет привязан комментарий
		 * т.е. вывод комментариев будет осуществлен на странице вывода поста (записи, рубрики и тд.) с данным id
		 */
		$key_id = config('comments.key_id');
		
		
		Comment::create(
		[	
			'id'=>'1',
			'name'=>'Сергей',
			'email'=>'ksl1980@mail.ru',
			'text'=>'Текст WEB-программиста Сергея',
			'created_at'=>'2017-07-02 14:36:33',
			$key_field => $key_id
		]);

	
		Comment::create(
		[
			'name'=>'Даша',
			'email'=>'dasha@mail.ru',
			'text'=>'Текст Даши',
			'created_at'=>'2017-07-08 19:58:15',
			$key_field => $key_id
		]);
		
		
		Comment::create(
		[
			'name'=>'Вася',
			'email'=>'vasia@mail.ru',
			'text'=>'Текст Васи',
			'parent_id'=>'1',
			'created_at'=>'2017-07-14 11:26:14',
			$key_field => $key_id
		]);
    }
}