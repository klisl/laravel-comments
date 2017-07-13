laravel-widgets
=================
[![Laravel 5.4](https://img.shields.io/badge/Laravel-5.4-orange.svg?style=flat-square)](http://laravel.com)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

Пакет для удобного создания и использования виджетов в Laravel-5

  * Удобный синтаксис - вызов любого виджета из шаблона с помощью простой директивы @widget, которая в качестве первого аргумента принимает название виджета, например:
```php
@widget('menu')
```
  * Простые правила создания виджетов.
  * Создание объекта виджета только в случае непосредственного его запроса.
  * Только самый необходимый функционал, разработанный с учетом архитектуры Laravel-5.4


  
Установка
------------------
Установка пакета с помощью Composer.

```
composer require klisl/laravel-widgets
```

По завершении этой операции, добавьте в файл `config/app.php` вашего проекта в конец массива `providers` :

```php
Klisl\Widgets\WidgetServiceProvider::class,
```

После этого выполните в консоли команду публикации нужных ресурсов:

```
php artisan vendor:publish --provider="Klisl\Widgets\WidgetServiceProvider"
```


Использование
-------------

В файле `config\widgets.php` находится массив, в котором, в качестве ключей нужно указать названия для виджетов которые вы будете создавать, а в качестве значений названия классов виджетов (с пространством имен). Например:
```php
'test' => 'App\Widgets\TestWidget'
```

Классы для своих виджетов нужно создавать в папке `app\Widgets`. Для размещения шаблонов виджетов предназначена папка `app\Widgets\views`.

Класс виджета должен иметь соответствующее пространство имен: `namespace App\Widgets`. Так же класс виджета должен включать интерфейс ContractWidget и реализовывать его метод execute(). 
Если виджет должен, для своей работы, получить какие-то данные из контроллера и тд. (передаются в шаблоне), то необходимо предусмотреть метод конструктор для класса виджета с получением аргумента в виде массива параметров.


Примеры
-------------

Пример минимального класса виджета:

```php
<?php

namespace App\Widgets;

use Klisl\Widgets\Contract\ContractWidget;

class TestWidget implements ContractWidget{
	
	public function execute(){
				
		return view('Widgets::test');
		
	}	
}
```

Шаблон данного виджета, файл test.blade.php (с произвольным контентом) должен находиться в папке `app\Widgets\views`.

Вызов данного виджета (из основного шаблона нужного контроллера):
```php
@widget('test')
```


Пример с передачей параметров:
```php
<?php

namespace App\Widgets;

use Klisl\Widgets\Contract\ContractWidget;

class TestWidget implements ContractWidget{
	
	public $num;
		
	public function __construct ($data){
		$this->num = $data['num'];
	}
		
	public function execute(){
				
		return view('Widgets::test', [
			'num' => $this->num
		]);
		
	}	
}
```

Вызов данного виджета с передачей параметров для обработки:
```php
@widget('test', ['num' => 5])
```

В каталоге `app\Widgets` уже находится тестовый виджет. Вы можете создавать свои на его основе.

Мой блог: [klisl.com](http://klisl.com)  