<?php

/**
 * This is the model class for table "{{contacts}}".
 *
 * The followings are the available columns in table '{{contacts}}':
 * @property integer $id
 * @property string $name
 * @property string $post
 * @property string $birthday
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property string $icq
 * @property string $note
 * @property integer $client_id
 */
class Contacts extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Contacts the static model class
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
		return '{{contacts}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, client_id', 'required'),
			array('client_id', 'numerical', 'integerOnly'=>true),
			array('name, post, address, phone, email, icq', 'length', 'max'=>255),
			array('birthday, note', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, post, birthday, address, phone, email, icq, note, client_id', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'post' => 'Post',
			'birthday' => 'Birthday',
			'address' => 'Address',
			'phone' => 'Phone',
			'email' => 'Email',
			'icq' => 'Icq',
			'note' => 'Note',
			'client_id' => 'Client',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('post',$this->post,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('icq',$this->icq,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('client_id',$this->client_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}