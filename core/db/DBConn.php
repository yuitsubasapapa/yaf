<?php
defined('DIRACCESS') or die('Cannot access this directly');

require_once(CLASSROOT . '/exception/yafException.php');
require_once(CLASSROOT . '/base/ObjFactory.php');
require_once(CLASSROOT . '/config/Constants.php');

/**
 * DB Connection Object
 * @author John Skrzypek
 * @copyright
 * @todo revisit $dbcreds check - error
 */

class DBConn
{
	private static $instance = false;
	protected static $firephp; //FirePHP console logging for FireFox
	
	private function __construct() {}
	private function __clone() {}
	
	private function getConnection(){

		if(!self::$instance) {
			
			$dbcreds = xmlToArray::getArray(CONFIG.'/'.Constants::config,'config-root','config','database');
		
			
			if(!is_array($dbcreds)){
				throw new yafException(yafException::DBCONN);
			}
			
			//create appropriate DB object
			$wrapper = ObjFactory::getObject($dbcreds['DBType']);
			
			if(!(self::$instance = $wrapper->connect($dbcreds['DBHost'],$dbcreds['DBUser'],$dbcreds['DBPassword'],$dbcreds['DBName']))){
				throw new yafException(yafException::DBCONN,yafException::FATAL);
			}
			
		}
		//FirePHP::getInstance(true)->info(self::$instance,"instance");
		return self::$instance;	
	}
	
	public static function getInstance() {
		return self::getConnection();
	}
	
}


?>