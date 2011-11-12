<?php

/**
 * This is the model class for table "{{acts}}".
 *
 * The followings are the available columns in table '{{acts}}':
 * @property integer $id
 * @property integer $order_id
 * @property integer $client_id
 * @property integer $template_id
 * @property string $date
 * @property double $sum
 * @property string $num
 * @property string $note
 */
class Acts extends CActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @return Acts the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{acts}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('template_id, order_id, client_id, date, sum, num, is_sign', 'required'),
			array('order_id, client_id, template_id', 'numerical', 'integerOnly' => true),
			array('sum', 'numerical'),
			array('body', 'length', 'max' => 60000),
			array('num', 'length', 'max' => 50),
			array('date', 'date', 'format' => 'yyyy-MM-dd', 'allowEmpty' => true),
			array('note, body', 'default', 'setOnEmpty' => true, 'value' => null),
//			array('date, note', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_id, client_id, template_id, date, sum, num, body, note, is_sign', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'works' => array(self::HAS_MANY, 'Works', 'act_id'),
			'order' => array(self::BELONGS_TO, 'Orders', 'order_id'),
			'client' => array(self::BELONGS_TO, 'Clients', 'client_id'),
			'tmpl' => array(self::BELONGS_TO, 'ActsTmpl', 'template_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'order_id' => 'Заказ',
			'client_id' => 'Клиент',
			'template_id' => 'Шаблон',
			'date' => 'Дата',
			'sum' => 'Сумма',
			'num' => '№№',
			'body' => 'Текст',
			'note' => 'Примечание',
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
		$criteria->compare('order_id', $this->order_id);
		$criteria->compare('t.client_id', $this->client_id);
		$criteria->compare('template_id', $this->template_id);
		$criteria->compare('date', $this->date, true);
		$criteria->compare('sum', $this->sum);
		$criteria->compare('num', $this->num, true);
		$criteria->compare('body', $this->num, true);
		$criteria->compare('note', $this->note, true);
		$criteria->compare('is_sign', $this->is_sign);
		$criteria->with = array('order', 'client', 'tmpl');
//$criteria->select = 't.*,(SELECT name FROM ' . Yii::app()->db->tablePrefix . 'orders WHERE id=t.order_id) as order_name';
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
					'*',
				)
			),
			'pagination' => array(
				'pageSize' => Yii::app()->config->get('global.per_page'),)
		));
	}

	/**
	 * выбрать шаблон для подстановки
	 * @param <type> $act_tmpl
	 * @return <type>
	 */
	public function get_act_tmpl($act_tmpl) {
		return ActsTmpl::model()->findByPk($act_tmpl);
	}

	public function getLastNum() {
		$n = $this->findBySql('SELECT MAX(num*1) as num from {{acts}}');
		if ($n !== null)
			return $n->num;
		else
			return '0';
	}

	/**
	 * список неактированных работ
	 * @param <type> $order_id
	 * @return CActiveDataProvider
	 */
	public function mdlWorks($order_id, $act_id=false) {
		if ($act_id === false)
			$criteria = array('condition' => 'order_id is null or order_id=' . (int) $order_id . ' and act_id is null');
		else
			$criteria = array('condition' => 'order_id is null or order_id=' . (int) $order_id . ' and act_id is null or act_id=' . (int) $act_id);
		return new CActiveDataProvider('Works', array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 'id DESC'),
			'pagination' => array(
				'pageSize' => Yii::app()->config->get('global.per_page'),)
		));
	}
	/**
	 *
	 * @return array
	 */
	public function listData($order_id=false) {
		$r=array();
		if ($order_id===false) $criteria=array(
			'select' => 'id,num,date,order.name as order_name,client.name as client_name',
			'order' => 't.id DESC',
			);
		else $criteria=array(
			'select' => 'id,num,date,order.name as order_name,client.name as client_name',
			'order' => 't.id DESC',
			'condition'=>'order_id='.(int)$order_id,
			);
		$l = $this
		->with(array(
			'order' => array('select' => 'name'),
			'client' => array('select' => 'name'),
			))
		->findAll($criteria);
//		CVarDumper::dump($l,20,true);die;
		foreach ($l as $d) {
			$r[$d->id] = '[' . $d->id . '] [' . $d->date . '] [' . $d->client->name . '] [' . $d->order->name . '] - ' . $d->num;
		}
		return $r;
	}
	/**
	 * присвоить работы акту
	 * @param int $act_id
	 * @param array $works
	 * @return int
	 */
	public function setWorks($works) {
//		parse_str($works);
//		Dumper::d($works);die;
		Works::model()->updateAll(array('act_id' => null), array('condition' => 'act_id=' . $this->id));
		return Works::model()->updateByPk($works, array('act_id' => $this->id, 'order_id'=>  $this->order_id), array('condition' => 'client_id=' . (int) $this->client_id));
		//return $c;
	}
		public function itemAlias($type, $item=NULL) {
		$_items = array(			
			'is_sign' => array(
				'0' => 'Нет', '1'=>'Подписан'
			),
		);
		if ($item == NULL)
			return isset($_items[$type]) ? $_items[$type] : false;
		else
			return isset($_items[$type][$item]) ? $_items[$type][$item] : false;
	}
}