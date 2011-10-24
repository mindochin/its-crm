<?php

class MyConfig extends CApplicationComponent
{
	
	const CACHE_KEY = 'Extension.Config';

	public $configTableName = 'Config';
	public $autoCreateConfigTable = false;
	public $connectionID = 'db';
	public $cacheID = false;
	public $strictMode = true;
	
	private $_db;
	private $_cache;
	private $_config;

	public function get($key)
	{

		$db = $this->_getDb();
		$cache = $this->_getCache();

		if (null === $this->_config)
		{
			$this->_getConfig($db, $cache);
		}
		
		if (false === is_array($this->_config) || false === array_key_exists($key, $this->_config))
		{
			if (true === $this->strictMode)
			{
				throw new CException("Unable to get value - no entry present with key \"{$key}\".");
			}
			else
			{
				return null;
			}
		}
		
		return (null === $this->_config[$key]) ? null : ($this->_config[$key]);
		
	}
	
	public function set($key, $value, $desc=NULL)
	{

		$db = $this->_getDb();
		$cache = $this->_getCache();

		if (null === $this->_config)
		{
			$this->_getConfig($db, $cache);
		}

		if (false === is_array($this->_config) || false === array_key_exists($key, $this->_config))
		{
			if (true === $this->strictMode)
			{
				throw new CException("Unable to set value - no entry present with key \"{$key}\".");
			}
			else
			{
				$dbCommand = $db->createCommand("INSERT INTO `{$this->configTableName}` (`key`, `value`, `desc`) VALUES (:key, :value, :desc)");
				$dbCommand->bindParam(':key', $key, PDO::PARAM_STR);				
				$dbCommand->bindValue(':value', ($value), PDO::PARAM_STR);
				$dbCommand->bindValue(':desc', ($desc), PDO::PARAM_STR);
				$dbCommand->execute();
			}
		}

		if (false === isset($dbCommand))
		{
			$dbCommand = $db->createCommand("UPDATE `{$this->configTableName}` SET `value` = :value, `desc` = :desc WHERE `key` = :key LIMIT 1");
			$dbCommand->bindValue(':value', serialize($value), PDO::PARAM_STR);		
			$dbCommand->bindParam(':key', $key, PDO::PARAM_STR);
			$dbCommand->bindValue(':desc', ($desc), PDO::PARAM_STR);
			$dbCommand->execute();
		}

		$this->_config[$key] = ($value);
		$this->_config[$key]['desc'] = ($desc);

		if (false !== $cache)
		{
			$cache->set(self::CACHE_KEY, $this->_config);
		}
		
	}

	private function _getDb()
	{

		if (null !== $this->_db)
		{
			return $this->_db;
		}
		elseif (($this->_db = Yii::app()->getComponent($this->connectionID)) instanceof CDbConnection)
		{
			return $this->_db;
		}
		else
		{
			throw new CException("Config.connectionID \"{$this->connectionID}\" is invalid. Please make sure it refers to the ID of a CDbConnection application component.");
		}
		
	}
	
	private function _getCache()
	{
		
		if (false === $this->cacheID)
		{
			return false;
		}
		elseif (null !== $this->_cache)
		{
			return $this->_cache;
		}
		elseif (($this->_cache = Yii::app()->getComponent($this->cacheID)) instanceof CCache)
		{
			return $this->_cache;
		}
		elseif (($this->_cache = Yii::app()->getComponent($this->cacheID)) instanceof CDummyCache)
		{
			return $this->_cache;
		}
		else
		{
			throw new CException("Config.cacheID \"{$this->cacheID}\" is invalid. Please make sure it refers to the ID of a CCache application component.");
		}
		
	}
	
	private function _getConfig($db, $cache)
	{

		if (true === $this->autoCreateConfigTable)
		{
			$this->_createConfigTable($db);
		}
		
		if (false === $cache || false === ($this->_config = $cache->get(self::CACHE_KEY)))
		{
			
			$dbReader = $db->createCommand("SELECT * FROM `{$this->configTableName}`")->query();

			while (false !== ($row = $dbReader->read()))
			{
				$this->_config[$row['key']] = $row['value'];
				$this->_config[$row['key']['desc']] = $row['desc'];
			}
			
			if (false !== $cache)
			{
				$cache->set(self::CACHE_KEY, $this->_config);
			}
			
		}

	}
	
	private function _createConfigTable($db)
	{
		$db->createCommand("CREATE TABLE IF NOT EXISTS `{$this->configTableName}` (`key` VARCHAR(100) PRIMARY KEY, `value` TEXT, `desc` TINYTEXT) COLLATE = utf8_bin")->execute();
	}
	
}

?>