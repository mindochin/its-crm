<?php

/**
 * This is the model class for table "{{payments}}".
 *
 * The followings are the available columns in table '{{payments}}':
 * @property integer $id
 * @property integer $order_id
 * @property integer $client_id
 * @property integer $invoice_id
 * @property string $date
 * @property double $sum
 * @property string $note
 */
class Payments extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Payments the static model class
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
		return '{{payments}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('client_id, date, sum', 'required'),
			array('note, order_id, invoice_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('date', 'date', 'format' => 'yyyy-mm-dd'),
			array('order_id, client_id, invoice_id', 'numerical', 'integerOnly'=>true),
			array('sum', 'numerical'),			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_id, client_id, invoice_id, date, sum, note', 'safe', 'on'=>'search'),
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
			'client'=>array(self::BELONGS_TO, 'Clients', 'client_id'),
			'order'=>array(self::BELONGS_TO, 'Orders', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_id' => 'Заказ',
			'client_id' => 'Клиент',
			'invoice_id' => 'Счет',
			'date' => 'Дата',
			'sum' => 'Сумма',
			'note' => 'Инфо',
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
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('invoice_id',$this->invoice_id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('sum',$this->sum);
		$criteria->compare('note',$this->note,true);

		$criteria->with=array('client','order');
		
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}