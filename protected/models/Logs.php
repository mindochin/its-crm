<?php

/**
 * This is the model class for table "{{logs}}".
 *
 * The followings are the available columns in table '{{logs}}':
 * @property integer $id
 * @property string $login
 * @property string $class
 * @property string $function
 * @property string $msg
 * @property string $time
 */
class Logs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Logs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{logs}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('time', 'required'),
			array('login, class, function', 'length', 'max'=>50),
			array('msg', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, login, class, function, msg, time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'login' => 'Пользователь',
			'class' => 'Class',
			'function' => 'Function',
			'msg' => 'Сообщение',
			'time' => 'Время',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('class',$this->class,true);
		$criteria->compare('function',$this->function,true);
		$criteria->compare('msg',$this->msg,true);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 't.id DESC'),
			'pagination' => array(
				'pageSize' => Yii::app()->config->get('global.per_page'),)
		));
	}
}