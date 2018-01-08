<?php

namespace Klisl\Comments;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Route;

/**
 * Class CommentsServiceProvider
 * @author Sergey <ksl80@ukr.net>
 * @package Klisl\Comments
 */
class CommentsServiceProvider extends ServiceProvider
{

    /** @return void */
    public function boot()
    {
		/*
		 * Маршрут обрабатывающий POST запрос отправляемый формой с помощью AJAX
		 */
		Route::post('comment', ['uses' => 'App\Http\Controllers\CommentController@store', 'as' => 'comment']);
				
				
		//Публикуем
        $this->publishes([__DIR__ . '/../config/' => config_path()]);

		$this->publishes([__DIR__ . '/../app/' => app_path()]);

		$this->publishes([__DIR__ . '/../database/' => database_path()]);

		$this->publishes([__DIR__ . '/../public/' => public_path()]);

		$this->publishes([__DIR__ . '/../resources/' => resource_path()]);
		
		
		Schema::defaultStringLength(191);
    }

	
    public function register()
    {

	}

}
