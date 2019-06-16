<?php
/**
 * TimeAgo test
 *
 * @author zhusaidong [zhusaidong@gmail.com]
 */
require('vendor/autoload.php');

use zhusaidong\TimeAgo\Locales;
use zhusaidong\TimeAgo\TimeAgo;
use zhusaidong\TimeAgo\TimeGroup;
use zhusaidong\TimeAgo\Timeslot;

$timeAgo = new TimeAgo;

try
{
	$timeAgo->registerLocales('testLocales', [
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
	
	$time = time() - random_int(1, 999) ** 2;
	
	echo 'now: ' . date('Y-m-d H:i:s') . PHP_EOL;
	echo 'time: ' . date('Y-m-d H:i:s', $time) . PHP_EOL;
	echo 'timeAgo: ' . $timeAgo->setTimestamp($time)->format('testLocales') . PHP_EOL;
}
catch(Exception $e)
{
	echo $e->getMessage();
}
