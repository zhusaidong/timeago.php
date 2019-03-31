<?php
/**
 * time group
 *
 * @author zhusaidong [zhusaidong@gmail.com]
 */
namespace zhusaidong\TimeAgo;

class TimeGroup
{
	/**
	 * @var array $timeGroup timeGroup
	 */
	private $timeGroup = [];
	
	/**
	 * set timeslot
	 *
	 * @param Timeslot $timeslot timeslot
	 *
	 * @return TimeGroup
	 */
	public function set(Timeslot $timeslot)
	{
		$this->timeGroup[] = $timeslot;
		
		return $this;
	}
	
	/**
	 * get time group
	 *
	 * @return array time group
	 */
	public function get()
	{
		return $this->timeGroup;
	}
}
