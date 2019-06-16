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
	 * @var array $timeslot timeslot
	 */
	private $timeslot = [];
	
	/**
	 * __construct
	 *
	 * @param int            $start   timeslot start
	 * @param int            $end     timeslot end
	 * @param Locales|string $locales locales
	 */
	public function __construct(int $start, int $end, $locales)
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
	public function get() : array
	{
		return $this->timeslot;
	}
}
