<?php

/**
 * This is the model class for table "{{invoices_fkt}}".
 *
 * The followings are the available columns in table '{{invoices_fkt}}':
 * @property integer $id
 * @property integer $order_id
 * @property integer $client_id
 * @property string $date
 * @property double $amount
 * @property string $num
 * @property string $note
 */
class InvoicesFkt extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return InvoicesFkt the static model class
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
		return '{{invoices_fkt}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('act_id, order_id, client_id, template_id, sum, is_sign', 'required'),
			array('id, order_id, client_id,act_id,template_id', 'numerical', 'integerOnly'=>true),
			array('sum', 'numerical'),
			array('num', 'length', 'max'=>100),
			array('cargo_send_info, cargo_addr_info', 'length', 'max'=>500),
			array('date, cargo_send, cargo_send, cargo_send_info, cargo_addr_info', 'default', 'value' => null),
			//array('date, note', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_id, client_id, act_id, template_id, date, sum, num, is_sign, cargo_send, cargo_addr, cargo_send_info, cargo_addr_info', 'safe', 'on'=>'search'),
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
			'order' => array(self::BELONGS_TO, 'Orders', 'order_id'),
			'client' => array(self::BELONGS_TO, 'Clients', 'client_id'),
			'act' => array(self::BELONGS_TO, 'Acts', 'act_id'),
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
			'act_id'=>'Акт',
			'template_id' =>'Шаблон',
			'date' => 'Дата',
			'sum' => 'Сумма',
			'num' => '№№',
			'cargo_send' =>'Грузоотправитель',
			'cargo_send_info' => 'Инфо грузоотправителя',
			'cargo_addr' =>'Грузополучатель',
			'cargo_addr_info' => 'Инфо грузополучателя',
			'is_sign'=>'Подписан',
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
		$criteria->compare('act_id',$this->act_id);
		$criteria->compare('template_id',$this->template_id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('sum',$this->sum);
		$criteria->compare('num',$this->num,true);		
		$criteria->compare('is_sign',$this->is_sign);
		$criteria->compare('cargo_send',$this->cargo_send,true);
		$criteria->compare('cargo_send_info',$this->cargo_send_info,true);
		$criteria->compare('cargo_addr',$this->cargo_addr,true);
		$criteria->compare('cargo_addr_info',$this->cargo_addr_info,true);

		$criteria->with = array('order', 'client', 'act');

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 't.id DESC',
				'attributes' => array(
					'client_id' => array(
						'asc' => 'client.name asc',
						'desc' => 'client.name desc',
					),
					'order_id' => array(
						'asc' => 'order.name asc',
						'desc' => 'order.name desc',
					),
					'act_id' => array(
						'asc' => 'act.num asc',
						'desc' => 'act.num desc',
					),
					'*',
				)
			),
			'pagination' => array(
				'pageSize' => Yii::app()->config->get('global.per_page'),)
		));
	}
	/**
	 * номер счета, цифра по порядку
	 * @return
	 */
	function getLastNum() {
		$n = $this->findBySql('SELECT MAX(num*1) as num from {{invoices_fkt}}');
		if ($n !== null)
			return $n->num;
		else
			return '0';
	}

	public function itemAlias($type, $item=NULL) {
		$_items = array(
			'is_sign' => array(
				'n' => '-', 'y'=>'Подписан'
			),
			'cargo' => array(
				'self' => 'Он же', 'other'=>'Другой'
			)
		);
		if ($item == NULL)
			return isset($_items[$type]) ? $_items[$type] : false;
		else
			return isset($_items[$type][$item]) ? $_items[$type][$item] : false;
	}
}