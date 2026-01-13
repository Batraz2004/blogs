<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## blogs api app =)
Приложение по созданию постов с видео а также коментариев

## Технологии
- PHP 8.4
- Laravel 12
- mysql 8.0.44

## пакеты
- auth sanctum для аутентификации
- media library от spatie для сохранения видео

## api endpoints

### регистрация
```http
POST api/registration/
{
    "email": почта,
    "name": имя,
    "password": пароль
    "password_confirmation": подтверждение пароля
}
```

### авторизация
```http
POST api/login/
{
    "email": почта,
    "password": пароль
    "password_confirmation": подтверждение пароля
}
```

### выход
```http
POST api/logout/
{}
```

### создание поста
```http
POST api/post/
{
    "title": заголовок,
    "description": описание,
    "video": файл видео
}
```
### обновление поста
```http
POST api/post/<id поста>
{
    "title": заголовок,
    "description": описание,
    "video": файл видео
}
```

### получение поста по id
```http
GET api/post/<id поста>
{}
```

### список постов(с пагинацией)
```http
GET api/post/?per_page=15
{}
```

### удаление поста
```http
DELETE api/post/<id поста>
{}
```

### создание новости
```http
POST api/news/
{
    "title": заголовок,
    "description": описание,
}
```

### обновление новости
```http
POST api/news/<id новости>
{
    "title": заголовок,
    "description": описание,
}
```

### получение новости по id
```http
GET api/news/<id новости>
{}
```

### список новостей(с пагинацией)
```http
GET api/news/?per_page=15
{}
```

### удаление новости
```http
DELETE api/news/<id новости>
{}
```

### создание коментария
```http
POST api/comment
{
    "message": сообщение,
    "post_id": к какому посту,
}
```

### обновление коментария
```http
POST api/comment/<id коментария>
{
    "message": сообщение,
}
```

### удаление коментария
```http
DELETE api/comment/6
{}
```

### список коментариев по посту(с пагинацией)
```http
GET api/comment/post/<id поста>
{}
```

### список коментариев текущего пользователя(с пагинацией)
```http
GET api/comment/user
{}
```

### список коментариев к новостям(с пагинацией)
```http
GET api/comment/news/<id новости>
{}
```

### список коментариев текущего пользователя(с пагинацией)
```http
GET api/comment/user
{}
```