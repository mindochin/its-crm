<?php

/**
 * This is the model class for table "{{invoices}}".
 *
 * The followings are the available columns in table '{{invoices}}':
 * @property integer $id
 * @property integer $order_id
 * @property integer $client_id
 * @property integer $act_id
 * @property string $date
 * @property double $sum
 * @property string $num
 * @property string $note
 * @property string $is_paid
 */
class Invoices extends CActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @return Invoices the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{invoices}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('act_id, order_id, client_id, template_id, sum, is_sign, is_paid', 'required'),
			array('order_id, client_id, template_id, act_id', 'numerical', 'integerOnly' => true),
			array('sum', 'numerical'),
			array('num', 'length', 'max' => 100),
			array('date, note', 'default', 'value' => null),
//			array('date, note', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_id, client_id, act_id, template_id, date, sum, num, note, is_paid, is_sign', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
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
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'order_id' => 'Заказ',
			'client_id' => 'Клиент',//в принципе лишнее поле в базе
			'act_id' => 'Акт',
			'template_id' =>'Шаблон',
			'date' => 'Дата',
			'sum' => 'Сумма',
			'num' => '№№',
			'note' => 'Заметки',
			'is_paid' => 'Оплачен',
			'is_sign' => 'Подписан',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('t.order_id', $this->order_id);
		$criteria->compare('t.client_id', $this->client_id);
		$criteria->compare('t.act_id', $this->act_id);
		$criteria->compare('t.template_id', $this->template_id);
		$criteria->compare('t.date', $this->date, true);
		$criteria->compare('sum', $this->sum);
		$criteria->compare('num', $this->num, true);
		$criteria->compare('note', $this->note, true);
		$criteria->compare('is_paid', $this->is_paid);
		$criteria->compare('is_sign', $this->is_sign);

		$criteria->with = array('order', 'client', 'act');

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
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

	public function sumByOrder($order_id) {
		$sum = $this->model()->findBySql('SELECT IFNULL((SELECT SUM(`sum`) FROM ' . Yii::app()->db->tablePrefix . 'invoices WHERE order_id = ' . $order_id . '),0)');
		return 0; //($sum);
	}

	/**
	 * номер счета, цифра по порядку
	 * @return
	 */
	function getLastNum() {
		$n = $this->findBySql('SELECT MAX(num*1) as num from {{invoices}}');
		if ($n !== null)
			return $n->num;
		else
			return '0';
	}

	public function itemAlias($type, $item=NULL) {
		$_items = array(
			// для выбора статуса заказа
			'is_paid' => array(
				'n' => '-', 'p' => 'Частично','y'=>'Полностью'
			),
			'is_sign' => array(
				'n' => '-', 'y'=>'Подписан'
			),
		);
		if ($item == NULL)
			return isset($_items[$type]) ? $_items[$type] : false;
		else
			return isset($_items[$type][$item]) ? $_items[$type][$item] : false;
	}

//	public function listArray() //used CHTML
//	{
//		$post=$this->findAll(array('select'=>'id, name'));
//		if ($post!=NULL)
//		{
//			foreach ($post as $v) {
//				$list[$v->id]=$v->name;
//			}
//			return $list;
//		}
//		else return NULL;
////		$posts=Post::model()->findAll($condition,$params);
////		$_items = array(		);
//	}
}