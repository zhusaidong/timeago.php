<?php
/**
 * TimeAgo
 *
 * @author zhusaidong [zhusaidong@gmail.com]
 */
namespace zhusaidong\TimeAgo;

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
	 * @var $locales locales
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
	 * @return array|int
	 */
	private function getTimeDiff()
	{
		$diff = time() - $this->timestamp;
		if($diff < 0)
		{
			return -1;
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
	private function getLocales($ago)
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
		/*
		//glob方法在目录有特殊字符(比如[])时会有问题
		array_map(function($local)
		{
			$this->registerLocales(pathinfo($local, PATHINFO_FILENAME), include($local));
		}, glob(__DIR__ . '/locales/*.php'));
		*/
		
		$dir = __DIR__ . '/locales/';
		array_map(function($local) use ($dir)
		{
			substr($local, -4) == '.php' and $this->registerLocales(pathinfo($local, PATHINFO_FILENAME), include($dir . $local));
		}, scandir($dir));
	}
	
	/**
	 * register locales
	 *
	 * @param string $name
	 * @param array  $config
	 *
	 * @return TimeAgo
	 */
	public function registerLocales($name, $config)
	{
		if(($diff = array_diff(array_keys($this->timeConfig), array_keys($config))) and !empty($diff))
		{
			echo 'unable to register locales \'' . $name . '\', the \'' . implode(',', $diff) . '\' not exist';
			exit;
		}
		
		foreach($config as $type => $local)
		{
			if($local instanceof TimeGroup)
			{
				$t = range(1, $this->timeConfig[$type]);
				foreach($local->get() as $value)
				{
					$timeslot = $value->get();
					$_t       = range($timeslot['start'], $timeslot['end']);
					$t        = array_diff($t, $_t);
				}
				if(!empty($t))
				{
					echo 'unable to register locales \'' . $name . '\', the \'' . $type . '\' timeslot is incomplete';
					exit;
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
	public function setLanguage($language)
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
	public function setTimestamp($timestamp)
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
	 */
	public function format($language = '')
	{
		$language != '' and $this->setLanguage($language);
		if(!isset($this->locales[$this->language]))
		{
			echo $this->language . ' locales not exist!';
			exit;
		}
		
		$ago = $this->getTimeDiff();
		if($ago === -1)
		{
			return 'The time you set is greater than the current time!';
		}
		if(empty($ago['locales']))
		{
			return '';
		}
		
		return str_replace('%t', $ago['time'], $this->getLocales($ago));
	}
}
