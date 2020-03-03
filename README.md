# Laravel Query Logger

> A dev tool to log all queries for Laravel application.

## Installation
```
$ composer require luffluo/laravel-query-logger --dev
```

## Usage

`config/app.php` add `query_logger => true` to open.

```
$ tail -f ./storage/logs/laravel.log
```

```
[2018-12-20 14:52:13] local.INFO: ============ URL: http://laravel.app/discussions ===============
[2018-12-20 14:52:14] local.DEBUG: [800μs] select count(*) as aggregate from `discussions` where `discussions`.`deleted_at` is null
[2018-12-20 14:52:14] local.DEBUG: [1.07ms] select * from `discussions` where `discussions`.`deleted_at` is null order by `is_top` desc, `created_at` desc limit 15 offset 0
[2018-12-20 14:52:14] local.DEBUG: [3.63s] select `tags`.*, `taggables`.`taggable_id` as `pivot_taggable_id`, `taggables`.`tag_id` as `pivot_tag_id` from `tags` inner join `taggables` on `tags`.`id` = `taggables`.`tag_id` where `taggables`.`taggable_id` in ('1', '2', '3', '4', '5', '6', '7', '8') and `taggables`.`taggable_type` = 'App\\Models\\Discussion' order by `order_column` asc
[2018-12-20 14:52:14] local.DEBUG: [670μs] select * from `users` where `users`.`id` in ('1', '2', '4') and `users`.`deleted_at` is null
...
```

## Other
You will like it.
