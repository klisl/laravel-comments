laravel-widgets
=================
[![Laravel 5.4](https://img.shields.io/badge/Laravel-5.4-orange.svg?style=flat-square)](http://laravel.com)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

Пакет для создания блока комментариев в Laravel-5.

Особенности и преимущества данного пакета:

*	Комментарии выводятся в виде древовидной структуры. Дочерние комментарии смещаются вправо от родительских (при ответе на другой комментарий).
*	Форма добавления нового комментария обрабатывается с помощью AJAX (без перезагрузки страницы).
*	При нажатии кнопки ответить, форма вставляется сразу после соответствующего (родительского) комментария.
*	При отправке формы, сразу формируется и выводится новый добавленный комментарий перед формой (можно отключить в настройках).
*	Комментарий может добавить незарегистрированный пользователь. При этом зарегистрированному пользователю можно не заполнять данные про имя автора и электронный адрес.
*	При отправке комментария в всплывающем окне пишется статус отправки и возможные ошибки.


  
Установка
------------------
Установка пакета с помощью Composer.

```
composer require klisl/laravel-comments
```

По завершении этой операции, добавьте в файл `config/app.php` вашего проекта в конец массива `providers` :

```php
Klisl\Comments\CommentsServiceProvider::class,
```

После этого выполните в консоли команду публикации нужных ресурсов:
```
php artisan vendor:publish --provider="Klisl\Comments\CommentsServiceProvider"
```

Проверить, возможно изменить настройки пакета в файле config\comments.php.

Выполнить миграции для создания нужных таблиц (консоль):
```
php artisan migrate
```

При желании, можно заполнить таблицу комментариев данными для тестирования  (консоль):
```
composer dump-autoload
php artisan db:seed --class=TestCommentsSeeder
```


Использование
-------------

Вывод дерева комментариев вместе с формой осуществляется в шаблоне выводящем отдельный пост (статью/рубрику и тд.) с которым связаны комментарии. Для этого в шаблон нужно вставить секцию:
```
@section('comments')
	@include('comments.comments_block', ['essence' => $post])
@endsection
```
 где  $post содержит объект модели отдельного поста.

На равне с другими секциями, секция 'comments' должна быть подключена в макете, который наследует данный шаблон:
```
@yield('content')
```

В макете так же нужно подключить стили и скрипты указанные в примере:
```
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		
		<link rel="stylesheet" type="text/css" media="all" href="{{asset('css')}}/app.css" />
		<link rel="stylesheet" type="text/css" media="all" href="{{asset('comments/css')}}/comments.css" />
		
		
		<script type="text/javascript" src="{{asset('js')}}/app.js" /></script>
		<script type="text/javascript" src="{{asset('comments/js')}}/comment-reply.js" /></script>
		<script type="text/javascript" src="{{asset('comments/js')}}/comment-scripts.js" /></script>

	</head>
	<body>
	
	…
	
	@yield('comments')	
	
	…

	</body>
</html>
```

Весь код тщательно прокомментирован. 
Контроллер, обрабатывающий данные по добавлению комментариев, доступен для редактирования в файле app\Http\Controllers\CommentController.php. 
Файл отправляющий запрос с помощью AJAX на сервер и отвечающий за вывод всплывающих окон с уведомлениями - public\comments\js\comment-scripts.js
Настройка стилей блока комментариев осуществляется в файле public\comments\css\comments.css

![enter image description here](http://klisl.com/frontend/web/images/external/laravel_comments.jpg)


Мой блог: [klisl.com](http://klisl.com)  