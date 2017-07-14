<?php

namespace Klisl\Comments;

use Illuminate\Support\ServiceProvider;
use Route;


class CommentsServiceProvider extends ServiceProvider
{

	
    public function boot()
    {
		/*
		 * Маршрут обрабатывающий POST запрос отправляемый формой с помощью AJAX
		 */
		Route::post('comment', ['uses' => 'App\Http\Controllers\CommentController@store', 'as' => 'comment']);
				
				
		//Публикуем конфигурационный файл (config/comments.php)	
        $this->publishes([__DIR__ . '/../config/' => config_path()]);
		
		//Публикуем CommentController и модель Comment
		$this->publishes([__DIR__ . '/../app/' => app_path()]);

		//Публикуем миграции
		$this->publishes([__DIR__ . '/../database/' => database_path()]);
		
		//Публикуем стили и скрипты
		$this->publishes([__DIR__ . '/../public/' => public_path()]);
		
		//Публикуем шаблоны и языковой файл
		$this->publishes([__DIR__ . '/../resources/' => resource_path()]);
		
    }

	
    public function register()
    {

	}

}
