# timeago.php

timeago.php 是一个语言化之前时间的php库。

# 使用方法

## 安装

> composer require zhusaidong/timeago.php

## 使用

```php
use zhusaidong\TimeAgo\TimeAgo;

$timeAgo = new TimeAgo;

$time = time() - random_int(1, 999) ** 2;

echo 'now: ' . date('Y-m-d H:i:s') . PHP_EOL;
echo 'time: ' . date('Y-m-d H:i:s', $time) . PHP_EOL;
echo 'timeAgo: ' . $timeAgo->setTimestamp($time)->format() . PHP_EOL;
```

## 注册本地化语言

默认的语言是 en, 目前内置的语言包括 en 和 zh-cn，你也可以通过`$timeAgo->registerLocales()`来注册自己的本地化语言或者个性化语言。

```php
//register
$timeAgo->registerLocales('testLocal', [
    'second' => (new TimeGroup)
                ->set(new Timeslot(0, 30, '不久前'))
                ->set(new Timeslot(31, 60, '%t秒以前')),
    'minute' => '%t分钟以前',
    'hour'   => (new TimeGroup)
                ->set(new Timeslot(0, 12, '半天前'))
                ->set(new Timeslot(13, 24, '%t小时以前')),
    'day'    => new Locales('%t天以前'),
    'week'   => new Locales('%t周以前'),
    'month'  => new Locales('%t个月以前'),
    'year'   => new Locales('%t年以前'),
]);

//use it
$timeAgo->setTimestamp($time)->format('testLocal');
```

## 语言包

注册本地化语言包时，可以使用多种方式

### 字符串

> 'minute' => '%t分钟以前',

### `Locales`

针对有单复数的语言，如英语，

> 'hour' => new Locales('an hour ago', '%t hours ago'),

### `TimeGroup` + `Timeslot`

针对有时间段的需求，如

> 'second' => (new TimeGroup)
            ->set(new Timeslot(0, 30, '不久前'))
            ->set(new Timeslot(31, 60, '%t秒以前')),

