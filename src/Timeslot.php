<?php
/**
 * time slot
 *
 * @author zhusaidong [zhusaidong@gmail.com]
 */
namespace zhusaidong\TimeAgo;

class Timeslot
{
	/**
	 * @var $timeslot timeslot
	 */
	private $timeslot = [];
	
	/**
	 * __construct
	 *
	 * @param int     $start   timeslot start
	 * @param int     $end     timeslot end
	 * @param Locales $locales locales
	 */
	public function __construct($start, $end, Locales $locales)
	{
		$this->timeslot = [
			'start'   => $start,
			'end'     => $end,
			'locales' => $locales,
		];
	}
	
	/**
	 * get time slot
	 *
	 * @return array time slot
	 */
	public function get()
	{
		return $this->timeslot;
	}
}
