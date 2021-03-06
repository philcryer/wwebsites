<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to the Creative Commons Attribution-Share
 * Alike 2.5 License that is available through the world-wide-web at the following
 * URI: http://creativecommons.org/licenses/by-sa/2.5/legalcode.
 *
 * @package    Browscap
 * @author     Jonathan Stoppani <st.jonathan@gmail.com>
 * @copyright  Copyright (c) 2006 Jonathan Stoppani
 * @version    0.4
 * @license    http://creativecommons.org/licenses/by-sa/2.5/ Attribution-ShareAlike 2.5
 * @link       http://garetjax.info/projects/browscap/
 */
class Browscap
{
	/**
     * Options for regex patterns.
     *
     * REGEX_DELIMITER:  Delimiter of all the regex patterns in the whole class.
     * REGEX_MODIFIERS:  Regex modifiers.
     */
	const REGEX_DELIMITER	= '@';
	const REGEX_MODIFIERS	= 'i';
	
	/**
	 * The values to quote in the ini file
	 */
	const VALUES_TO_QUOTE	= 'Browser|Parent';
	
	/**
	 * Definitions of the function used by the uasort() function to order the
	 * userAgents array.
	 *
	 * ORDER_FUNC_ARGS:  Arguments that the function will take.
	 * ORDER_FUNC_LOGIC: Internal logic of the function.
	 */
	const ORDER_FUNC_ARGS 	= '$a, $b';
	const ORDER_FUNC_LOGIC	= '$a=strlen($a);$b=strlen($b);return$a==$b?0:($a<$b?1:-1);';

	/**
	 * The headers to be sent for checking the version and requesting the file.
	 */
	const REQUEST_HEADERS 	= "GET %s HTTP/1.1\r\nHost: %s\r\nConnection: Close\r\n\r\n";
	
	/**
	 * Options for auto update capabilities
	 * 
	 * $_remoteVerUrl:  The location to use to check out if a new version of the
	 *                  browscap.ini file is available.
	 * $_remoteIniUrl:  The location from which download the ini file.
	 *                  The placeholder for the file should be represented by a %s.
	 * $_iniVersion:    The version of the ini file to download, will be inserted
	 *                  into the REMOTE_INI_URL value.
	 * $_timeout:		The timeout for the requests.
	 */
	public $remoteIniUrl  	= 'http://browsers.garykeith.com/stream.asp?PHP_BrowsCapINI';
	public $remoteVerUrl  	= 'http://browsers.garykeith.com/version-date.asp';
	public $iniVersion		= 'BrowsCapINI';
	public $timeout			= 2;
	
	/**
	 * Where to store the cached php arrays.
	 *
	 * @var string
	 */
	public $cacheFilename 	= 'cache.php';
	
	/**
	 * Where to store the downloaded ini file.
	 *
	 * @var string
	 */
	public $iniFilename 	= 'browscap.ini';
	
	/**
     * Path to the cache directory
     *
     * @var string	
     */
	public $cacheDir 		= null;
	
	/**
	 * Flag to be set to true after loading the cache
	 *
	 * @var bool
	 */
	protected $_cacheLoaded	= false;
	
	/**
     * Where to store the value of the included php cache file
     *
     * @var array
     */
	protected $_userAgents	= array();
	protected $_browsers	= array();
	protected $_patterns	= array();
	protected $_properties	= array();

	/**
	 * Constructor class, checks for the existence of (and loads) the cache and
	 * if needed updated the definitions
	 *
	 * @param string $cache_dir
	 */
	public function __construct($cache_dir)
	{
		date_default_timezone_set('UTC');
	
		if (!isset($cache_dir)) {
			throw new Browscap_Exception(
				'You have to provide a path to read/store the browscap cache file'
			);
		}
		
		$cache_dir = realpath($cache_dir);
		
		if (substr($cache_dir, -4) === '.php') {
			$this->cacheFilename = basename($cache_dir);
			$this->cacheDir = dirname($cache_dir);
		} else {
			$this->cacheDir = $cache_dir;
		}
		
		$this->cacheDir .= DIRECTORY_SEPARATOR;
	}

	/**
	 * Gets the information about the browser by User Agent
	 *
	 * @param string $user_agent   the user agent string
	 * @param bool   $return_array whether return an array or an object 
	 * @return stdObject the object containing the browsers details. Array if 
	 *                   $return_array is set to true.
	 */
	public function getBrowser($user_agent = null, $return_array = false)
	{	
		if (!$this->_cacheLoaded) {
			$cache_file = $this->cacheDir . $this->cacheFilename;
						
			if (!file_exists($cache_file)) {
				$this->updateCache();
			}
			
			$this->_loadCache($cache_file);
		}
		
		if (!isset($user_agent) && isset($_SERVER['HTTP_USER_AGENT'])) {
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
		}
		
		$browser = array();
	
		foreach ($this->_patterns as $key => $pattern) {
			if (preg_match($pattern . 'i', $user_agent)) {
				$browser = array(
					trim(strtolower($pattern), self::REGEX_DELIMITER),
					$this->_userAgents[$key]
				);
				$browser = $value = $browser + $this->_browsers[$key];
				
				while (array_key_exists(2, $value)) {
					$value      =   $this->_browsers[$value[2]];
					$browser    +=  $value;
				}
				
				if (!empty($browser[2])) {
					$browser[2] = $this->_userAgents[$browser[2]];
				}
	
				break;
			}
		}

		foreach ($browser as $key => $value) {
			$array[$this->_properties[$key]] = $value;
		}

		return $return_array ? $array : (object) $array;
	}
	
	/**
	 * Parses the ini file and updates the cache
	 *
	 * @return bool whether the file was correctly written to the disk
	 */
	public function updateCache()
	{	
		$ini_path 			= $this->cacheDir . $this->iniFilename;
		$cache_path			= $this->cacheDir . $this->cacheFilename;
	
	
		$browsers 			= parse_ini_file($ini_path, true);
		array_shift($browsers);
							
		$this->_properties	= array_keys($browsers['DefaultProperties']);
		array_unshift(
			$this->_properties,
			'browser_name_regex',
			'browser_name_pattern',
			'Parent'
		);
		
		$this->_userAgents 	= array_keys($browsers);
		usort(
			$this->_userAgents,
			create_function(self::ORDER_FUNC_ARGS, self::ORDER_FUNC_LOGIC)
		);
		
		$user_agents_keys 	= array_flip($this->_userAgents);
		$properties_keys	= array_flip($this->_properties);
		
		$search				= array('\*', '\?');
    	$replace			= array('.*', '.');

		foreach ($this->_userAgents as $user_agent) {
			$pattern = preg_quote($user_agent, self::REGEX_DELIMITER);
			$this->_patterns[] 	= self::REGEX_DELIMITER
							    . '^'
						  		. str_replace($search, $replace, $pattern)
						 	 	. '$'
						  		. self::REGEX_DELIMITER;
			
			if (!empty($browsers[$user_agent]['Parent'])) {
				$parent = $browsers[$user_agent]['Parent'];
				//$browsers[$user_agent]['Parent'] = $user_agents_keys[$parent];
			}
			
			foreach ($browsers[$user_agent] as $key => $value) {
				$key = $properties_keys[$key] . ".0";
				$browser[$key] = $value;
			}
			
			$this->_browsers[] = $browser;
			unset($browser);
        }
        unset($user_agents_keys, $properties_keys, $browsers);

		$cache = $this->_buildCache();
		
		return (bool) file_put_contents($cache_path, $cache, LOCK_EX);
	}
	
	/**
	 * Loads the cache into odject's properties
	 *
	 * @return void
	 */
	protected function _loadCache($cache_file)
	{
		require $cache_file;
		
		$this->_browsers 	= $browsers;
		$this->_userAgents	= $userAgents;
		$this->_patterns	= $patterns;
		$this->_properties	= $properties;
		
		$this->_cacheLoaded = true;
	}
	
	/**
	 * Parses the array to cache and creates the php string to write to disk
	 *
	 * @return string the php string to save into the cache file
	 */
	protected function _buildCache()
	{
		$cacheTpl = "<?php\n\$properties=%s;\n\$browsers=%s;\n\$userAgents=%s;\n\$patterns=%s;\n";
	
		$propertiesArray	= $this->_array2string($this->_properties);
		$patternsArray 		= $this->_array2string($this->_patterns);
		$userAgentsArray	= $this->_array2string($this->_userAgents);
		$browsersArray		= $this->_array2string($this->_browsers);
		
		return sprintf(
			$cacheTpl,
			$propertiesArray,
			$browsersArray,
			$userAgentsArray,
			$patternsArray
		);
	}
	
	/**
	 * Updates the local copy of the ini file (by version checking) and adapts
	 * his syntax to php
	 *
	 * @param string $url  the url of the remote server
	 * @param string $path the path of the ini file to update
	 * @throws Browscap_Exception
	 * @return bool if the ini file was updated
	 */
	/**
	 * Converts the given array to the php string which represent it
	 *
	 * @param array $array the array to parse and convert
	 * @return string the array parsed into a php string
	 */
	protected function _array2string($array)
	{
		foreach ($array as $key => $value) {
			if (is_int($key)) {
				$key	= '';
			} elseif (ctype_digit((string) $key) || strpos($key, '.0')) {
				$key 	= intval($key) . '=>' ;
			} else {
				$key 	= "'" . str_replace("'", "\'", $key) . "'=>" ;
			}
			
			if (is_array($value)) {
				$value	= $this->_array2string($value);
			} elseif (ctype_digit((string) $value)) {
				$value 	= intval($value);
			} else {
				$value 	= "'" . str_replace("'", "\'", $value) . "'";
			}
			
			$strings[]	= $key . $value;
		}
		
		return 'array(' . implode(',', $strings) . ')';
	}
}

/**
 * Browscap.ini parsing class exception
 *
 * @package    Browscap
 * @author     Jonathan Stoppani <st.jonathan@gmail.com>
 * @copyright  Copyright (c) 2006 Jonathan Stoppani
 * @license    http://creativecommons.org/licenses/by-sa/2.5/ Attribution-ShareAlike 2.5
 * @link       http://garetjax.info/projects/browscap/
 */
class Browscap_Exception extends Exception
{}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */

