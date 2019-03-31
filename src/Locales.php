<?php
/**
 * Locales
 *
 * @author zhusaidong [zhusaidong@gmail.com]
 */
namespace zhusaidong\TimeAgo;

class Locales
{
	/**
	 * @var mixed $singular singular
	 */
	private $singular = NULL;
	/**
	 * @var mixed $plural plural
	 */
	private $plural = NULL;
	
	/**
	 * __construct
	 *
	 * @param string $singular singular
	 * @param string $plural   plural
	 */
	public function __construct($singular, $plural = NULL)
	{
		$this->singular = $singular;
		$this->plural   = $plural;
	}
	
	/**
	 * get singular
	 *
	 * @return string singular
	 */
	public function getSingular()
	{
		return $this->singular;
	}
	
	/**
	 * get plural
	 *
	 * @return string plural
	 */
	public function getPlural()
	{
		return $this->plural;
	}
}
