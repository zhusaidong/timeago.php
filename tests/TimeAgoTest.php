<?php
/**
 * test
 */

use PHPUnit\Framework\TestCase;
use zhusaidong\TimeAgo\TimeAgo;

class TimeAgoTest extends TestCase
{
	public function testAgoTime()
	{
		$timeAgo = new TimeAgo;
		
		$now       = time();
		$testTimes = [
			$now - 1               => 'a second ago',
			$now - 31              => '31 seconds ago',
			$now - 86400 * 7 * 1.5 => 'a week ago',
			1500000000             => 'a year ago',
			150000000              => '44 years ago',
		];
		
		try
		{
			foreach($testTimes as $time => $ago)
			{
				$this->assertEquals($timeAgo->setTimestamp($time)->format(), $ago);
			}
		}
		catch(Exception $e)
		{
			$this->fail('have Exception');
		}
	}
	
	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage The time you set is greater than the current time!
	 */
	public function testExceptionTime()
	{
		$timeAgo = new TimeAgo;
		
		$timeAgo->setTimestamp(time() + 1)->format();
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage exception_locale locales not exist!
	 * @throws Exception
	 */
	public function testExceptionLocale()
	{
		$timeAgo = new TimeAgo;
		
		$timeAgo->setTimestamp(time() + 1)->format('exception_locale');
	}
}
