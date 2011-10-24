<?php

class MyLogger extends CApplicationComponent
{
	public $configTableName = '{{logs}}';
	public $autoCreateConfigTable = true;
	public $connectionID = 'db';
	
	private $_db;
	private $_config;

	public function write($msg)
	{

		$db = $this->_getDb();
		$login=Yii::app()->user->name;

		if (null === $this->_config)
		{
			$this->_getConfig($db);
		}
		$dbCommand = $db->createCommand("INSERT INTO `{$this->configTableName}` (`login`, `msg`) VALUES (:login, :msg)");
		$dbCommand->bindParam(':login', $login, PDO::PARAM_STR);
		$dbCommand->bindValue(':msg', $msg, PDO::PARAM_STR);
		$dbCommand->execute();			

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
			throw new CException("MyLogger.connectionID \"{$this->connectionID}\" is invalid. Please make sure it refers to the ID of a CDbConnection application component.");
		}
		
	}
	
	private function _getConfig($db)
	{

		if (true === $this->autoCreateConfigTable)
		{
			$this->_createConfigTable($db);
		}
	}
	
	private function _createConfigTable($db)
	{
		$db->createCommand("CREATE TABLE IF NOT EXISTS `{$this->configTableName}` (`id` INT PRIMARY KEY, `login` VARCHAR(50) DEFAULT NULL, `msg` VARCHAR(100) NOT NULL, `time` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP) COLLATE = utf8_general_ci")->execute();
	}
	
}

?>