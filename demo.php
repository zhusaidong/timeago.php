<?php
/**
 * TimeAgo test
 *
 * @author zhusaidong [zhusaidong@gmail.com]
 */
require('vendor/autoload.php');

use zhusaidong\TimeAgo\TimeAgo, zhusaidong\TimeAgo\TimeGroup, zhusaidong\TimeAgo\Timeslot, zhusaidong\TimeAgo\Locales;

$timeAgo = new TimeAgo;

$timeAgo->registerLocales('zh-demo', [
	'second' => (new TimeGroup)->set(new Timeslot(1, 30, new Locales('刚刚')))
		->set(new Timeslot(31, 60, new Locales('%t秒以前'))),
	'minute' => new Locales('%t分钟以前'),
	'hour'   => new Locales('%t小时以前'),
	'day'    => new Locales('%t天以前'),
	'week'   => new Locales('%t周以前'),
	'month'  => new Locales('%t个月以前'),
	'year'   => new Locales('%t年以前'),
]);

$testTimes = [
	time() - 1,
	time() - 31,
	
	time() - 86400 * 7 * 1.5,
	
	1500000000,
	150000000,
	15000000,
	
	1600000000,
	160000000,
	16000000,
];
foreach($testTimes as $time)
{
	var_dump($time, date('Y-m-d H:i:s', $time), $timeAgo->setTimestamp($time)->format());
	echo str_pad('', 60, '-', STR_PAD_RIGHT).PHP_EOL;//分割线
}
