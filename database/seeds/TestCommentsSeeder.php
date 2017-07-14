<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Comment;

class TestCommentsSeeder extends Seeder
{
    public function run()
    {		
		Comment::create(
		[	
			'id'=>'1',
			'name'=>'Саша',
			'email'=>'sasha@mail.ru',
			'text'=>'Текст Саши',
			'created_at'=>'2017-07-02 14:36:33',
			'post_id'=>'1'
		]);

	
		Comment::create(
		[
			'name'=>'Даша',
			'email'=>'dasha@mail.ru',
			'text'=>'Текст Даши',
			'created_at'=>'2017-07-08 19:58:15',
			'post_id'=>'1'
		]);
		
		
		Comment::create(
		[
			'name'=>'Вася',
			'email'=>'vasia@mail.ru',
			'text'=>'Текст Васи',
			'parent_id'=>'1',
			'created_at'=>'2017-07-14 11:26:14',
			'post_id'=>'1'
		]);
    }
}