<?php
/**
 * TimeAgo
 *
 * @author zhusaidong [zhusaidong@gmail.com]
 */
namespace zhusaidong\TimeAgo;

use InvalidArgumentException;
use Exception;

class TimeAgo
{
	/**
	 * @var int $timestamp timestamp
	 */
	private $timestamp = 0;
	/**
	 * @var array $timeConfig time config
	 */
	private $timeConfig = [
		'second' => 60,
		'minute' => 60,
		'hour'   => 24,
		'day'    => 7,
		'week'   => 365 / 7 / 12,
		'month'  => 12,
		'year'   => 0,
	];
	/**
	 * @var array $locales locales
	 */
	private $locales = [];
	/**
	 * @var string $language language, default is `en`
	 */
	private $language = 'en';
	
	/**
	 * __construct
	 */
	public function __construct()
	{
		$this->initLocales();
	}
	
	/**
	 * time diff
	 *
	 * @return array|null
	 */
	private function getTimeDiff() : ?array
	{
		$diff = time() - $this->timestamp;
		if($diff < 0)
		{
			return NULL;
		}
		
		$ago = [
			'time'    => 0,
			'locales' => '',
		];
		foreach($this->timeConfig as $key => $value)
		{
			if($value == 0 or $diff < $value)
			{
				$ago['time']    = floor($diff);
				$ago['locales'] = $key;
				break;
			}
			else
			{
				$diff /= $value;
			}
		}
		
		return $ago;
	}
	
	/**
	 * get Locales
	 *
	 * @param array $ago
	 *
	 * @return string Locales
	 */
	private function getLocales(array $ago) : string
	{
		$locales = $this->locales[$this->language][$ago['locales']];
		
		if($locales instanceof TimeGroup)
		{
			$local = '';
			foreach($locales->get() as $value)
			{
				$timeslot = $value->get();
				if($ago['time'] >= $timeslot['start'] and $ago['time'] <= $timeslot['end'])
				{
					$local = $timeslot['locales'];
					break;
				}
			}
		}
		else
		{
			$local = $locales;
		}
		
		if($local instanceof Locales)
		{
			if($ago['time'] > 1 and ($plural = $local->getPlural()) != NULL)
			{
				$local = $plural;
			}
			else
			{
				$local = $local->getSingular();
			}
		}
		
		return $local;
	}
	
	/**
	 * init locales
	 */
	private function initLocales()
	{
		array_map(function($local)
		{
			$this->registerLocales(pathinfo($local, PATHINFO_FILENAME), include($local));
		}, glob(__DIR__ . '/locales/*.php'));
	}
	
	/**
	 * register locales
	 *
	 * @param string $name
	 * @param array  $config
	 *
	 * @return TimeAgo
	 * @throws Exception
	 */
	public function registerLocales(string $name, array $config) : TimeAgo
	{
		if(!empty($diff = array_diff(array_keys($this->timeConfig), array_keys($config))))
		{
			throw new Exception('unable to register locales \'' . $name . '\', the \'' . implode(',', $diff) . '\' not exist');
		}
		
		foreach($config as $type => $local)
		{
			$local = !$local instanceof TimeGroup ? : $local->get();
			if(is_array($local))
			{
				$t = range(1, $this->timeConfig[$type]);
				foreach($local as $timeslot)
				{
					$timeslot = !$timeslot instanceof Timeslot ? : $timeslot->get();
					$t        = array_diff($t, range($timeslot['start'], $timeslot['end']));
				}
				if(!empty($t))
				{
					throw new Exception('unable to register locales \'' . $name . '\', the \'' . $type . '\' timeslot is incomplete');
				}
			}
		}
		
		$this->locales[$name] = $config;
		
		return $this;
	}
	
	/**
	 * set language
	 *
	 * @param string $language
	 *
	 * @return TimeAgo
	 */
	public function setLanguage(string $language) : TimeAgo
	{
		$this->language = $language;
		
		return $this;
	}
	
	/**
	 * set timestamp
	 *
	 * @param int $timestamp
	 *
	 * @return TimeAgo
	 */
	public function setTimestamp(int $timestamp) : TimeAgo
	{
		$this->timestamp = $timestamp;
		
		return $this;
	}
	
	/**
	 * format
	 *
	 * @param string $language language
	 *
	 * @return string
	 * @throws Exception
	 * @throws InvalidArgumentException
	 */
	public function format(string $language = '') : string
	{
		$language != '' and $this->setLanguage($language);
		if(!isset($this->locales[$this->language]))
		{
			throw new InvalidArgumentException($this->language . ' locales not exist!');
		}
		
		$ago = $this->getTimeDiff();
		if($ago === NULL)
		{
			throw new Exception('The time you set is greater than the current time!');
		}
		if(empty($ago['locales']))
		{
			return '';
		}
		
		return str_replace('%t', $ago['time'], $this->getLocales($ago));
	}
}
