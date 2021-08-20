# Laravel Swagger UI
Пакет предоставляет легкий способ отображения Swagger (OpenAPI v3 YAML) документации в Laravel.

## Installation

Пакет можно установить с помощью composer:

1. Добавить репозиторий в composer.json
```json
{
  "license": "MIT",
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/YSRoot/laravel-swagger-ui.git"
    }
  ]
}
```

```bash
composer require ysroot/laravel-swagger-ui
```

После установки опубликуйте SwaggerUIServiceProvider используя команду `php artisan vendor:publish`

## Usage

### Config
Ознакомьтесь с `swagger-ui.php` конфиг файлом, есть несколько параметров обязательных для заполнения `paths.docs` и `paths.refs_dir_prefix` если структура вашей документации разбита на вложенные yaml файлы.

### Routes
Роуты можно определить с помощью `SwaggerUI` класса, вызовите его в одном из файлов роутинга (`api, web, etc`) или в `AppServiceProvider` в методе `boot`

По умолчанию документация будет доступна по адресу `host/docs/api`

```php
YSRoot\SwaggerUI\SwaggerUI::routes();
```
Вы можете переопределить параметры для группы роутов, `SwaggerUI::routes(null, ['middleware' => ['auth']])` первый аргумент callback на данный момент бесполезен, а вот второй аргумент может понадобиться если хотите добавить префикс, или любую другую опцию.

```php
//php7.4
SwaggerUI::routes(null, ['middleware' => ['auth']])
//php8
SwaggerUI::routes(options: ['middleware' => ['auth']])
```

### Authorize
По умолчанию документация доступна всем. Но вы можете это переопределить с помощью `SwaggerUI::$gateCallback` или переопределив `Gate::define('viewSwaggerUI', $closure)`

Пример как переопределить с помощью `$gateCallback` необходимо либо в `AppServiceProvider`-е или если вы опубликовали `SwaggerUIServiceProvider`-е в методе `boot` 
```php
public function boot()
{
    SwaggerUI::$gateCallback = function (\Illuminate\Http\Request $request) {
        // необходимо определить view-docs
        return $request->user()->can('view-docs');
    
        // только авторизованным пользователями из списка
        return in_array(optional($request)->user()->email, [
            'test@test.ru',
            //... 
        ]);
    
        // нужно определить метод isAdmin в моделе User (скорее всего)
        return $request->user()->isAdmin();
    
    };
}
```

 Или с помощью переопределение `Gate::define('viewSwaggerUI', ...)`
```php
protected function boot()
{
    Gate::define('viewSwaggerUI', function ($user = null) {
        return in_array(optional($user)->email, [
            //
        ]);
    });

    // .. etc
}
```

### Testing

``` bash
composer test
```

## Roadmap
Пока родмап максимально простой.
1. При рекурсивном чтении `$ref` yaml файликов добавлять их в массив и при следующей необходимости доставать оттуда, а не заново читать.
2. Добавить поддержку JSON формата документации.
3. Придумать родмап подлиннее.

## License

The MIT License (MIT).