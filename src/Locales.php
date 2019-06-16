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
	 * @var string $singular singular
	 */
	private $singular = NULL;
	/**
	 * @var string $plural plural
	 */
	private $plural = NULL;
	
	/**
	 * __construct
	 *
	 * @param string $singular singular
	 * @param string $plural   plural
	 */
	public function __construct(string $singular, string $plural = NULL)
	{
		$this->singular = $singular;
		$this->plural   = $plural;
	}
	
	/**
	 * get singular
	 *
	 * @return string singular
	 */
	public function getSingular() : string
	{
		return $this->singular;
	}
	
	/**
	 * get plural
	 *
	 * @return string plural
	 */
	public function getPlural() : ?string
	{
		return $this->plural;
	}
}
