<?php

/**
 * This is the model class for table "{{clients}}".
 *
 * The followings are the available columns in table '{{clients}}':
 * @property integer $id
 * @property string $name
 * @property string $fullname
 * @property string $requisite
 * @property string $address
 * @property string $contactdata
 * @property string $headpost
 * @property string $headfio
 * @property string $headbasis
 */
class Clients extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Clients the static model class
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
		return '{{clients}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name, fullname, headfio, headpost, headbasis', 'length', 'max'=>255),
			array('requisite, address, contactdata', 'safe'),
			array('fullname,headfio,headpost,headbasis,requisite,address,contactdata', 'default', 'setOnEmpty' => true, 'value' => null),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, fullname, requisite, address, contactdata, headpost, headfio, headbasis', 'safe', 'on'=>'search'),
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
			'orders'=>array(self::HAS_MANY, 'Orders', 'client_id'),
			'payments'=>array(self::HAS_MANY, 'Payments', 'client_id'),			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'fullname' => 'Полное название',
			'requisite' => 'Реквизиты',
			'address' => 'Адрес',
			'contactdata' => 'Контакты',
			'headpost' => 'Должность директора',
			'headfio' => 'ФИО директора',
			'headbasis' => 'Директор действует на основании',
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
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('requisite',$this->requisite,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('contactdata',$this->contactdata,true);
		$criteria->compare('headpost',$this->headpost,true);
		$criteria->compare('headfio',$this->headfio,true);
		$criteria->compare('headbasis',$this->headbasis,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 't.name DESC'),
			'pagination' => array(
				'pageSize' => Yii::app()->config->get('global.per_page'),)
		));
	}
	/**
	 * get client by order
	 * @param <type> $order_id
	 * @return <type>
	 */
	public function clientByOrder($order_id) {
		$r = Yii::app()->db->createCommand()
						->select('c.*,o.client_id')
						->from('{{clients}} c')
						->join('{{orders}} o', 'o.client_id = c.id')
						->where('o.id=:id', array(':id' => $order_id))
						->queryRow();

		return $r;
	}

	public function listArray($item=null)
	{
		$post=$this->findAll(array('select'=>'id, name'));
		if ($post!=NULL)
		{
			foreach ($post as $v) {
				$list[$v->id]=$v->name;
			}
			return $list;
		}
		else return NULL;
//		$posts=Post::model()->findAll($condition,$params);
//		$_items = array(		);
	}
}