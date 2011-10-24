<?php

/**
 * This is the model class for table "{{orders}}".
 *
 * The followings are the available columns in table '{{orders}}':
 * @property integer $id
 * @property string $name
 * @property integer $client_id
 * @property integer $status
 * @property string $date
 * @property double $fixpay
 * @property string $note
 */
class Orders extends CActiveRecord {

	public $finBalance = NULL;
	public $works_sum;
	public $payments_sum;
	public $invoices_sum;
	public $client_name;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Orders the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{orders}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, name, client_id, status', 'required'),
			array('date', 'date', 'format' => 'yyyy-mm-dd'),
			array('client_id, status', 'numerical', 'integerOnly' => true),
			array('fixpay', 'numerical'),
			array('name', 'length', 'max' => 255),
			array('note', 'length', 'max' => 60000),
			array('note', 'default', 'setOnEmpty' => true, 'value' => null),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, client_id, status, date, fixpay, note', 'safe', 'on' => 'search'),
		);
	}

//	public function defaultScope() {
//		return array(
//			'condition' => 'status not in (12,13)',
//		);
//	}

	public function scopes() {
		return array(
			'open' => array(
				'condition' => 'status not in (12,13)',
			),
			'all' => array(
				'condition' => 'status in (1-13)',
			),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'client' => array(self::BELONGS_TO, 'Clients', 'client_id'),
			'works' => array(self::HAS_MANY, 'Works', 'order_id'),
			'payments' => array(self::HAS_MANY, 'Payments', 'order_id'),
			'acts' => array(self::HAS_MANY, 'Acts', 'order_id'),
			'contracts' => array(self::HAS_MANY, 'Contracts', 'order_id'),
			'invoices' => array(self::HAS_MANY, 'Invoices', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'name' => 'Предмет',
			'client_id' => 'Клиент',
			'status' => 'Статус',
			'date' => 'Дата',
			'fixpay' => 'Фикс.платёж',
			'note' => 'Инфо',
			'finBalance' => 'Баланс',
			'works_sum' => 'Вып-но',
			'payments_sum' => 'Оплата',
			'invoices_sum' => 'Счета',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $this->getSearchCriteria(),
			'sort' => array(
				'defaultOrder' => 't.id DESC',
				'attributes' => array(
					'client_id' => array(
						'asc' => 'client_name asc',
						'desc' => 'client_name desc',
					),
					'*',
				),
			),
			'pagination' => array(
				'pageSize' => Yii::app()->config->get('global.per_page'),)
		));
	}

	function getSearchCriteria() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('client_id', $this->client_id);

		$criteria->compare('date', $this->date, true);
		$criteria->compare('fixpay', $this->fixpay);
		$criteria->compare('note', $this->note, true);

//		$criteria->with = array('client');//, 'invoices'=> array('select' =>'IFNULL((SELECT SUM(`sum`) FROM '.Yii::app()->db->tablePrefix.'invoices WHERE order_id = t.id),0) as invoices_sum'));
		$criteria->select = 't.*,
			(IFNULL((SELECT SUM(`sum`) FROM ' . Yii::app()->db->tablePrefix . 'invoices WHERE order_id = t.id),0)) as invoices_sum,
			IFNULL((SELECT SUM(cost*quantity) FROM ' . Yii::app()->db->tablePrefix . 'works WHERE `order_id` = t.id),0) as works_sum,
		IFNULL((SELECT SUM(amount) FROM ' . Yii::app()->db->tablePrefix . 'payments WHERE order_id = t.id),0) as payments_sum,
		(SELECT IFNULL(works_sum-payments_sum,0)) as finBalance,
		(SELECT name FROM ' . Yii::app()->db->tablePrefix . 'clients WHERE id=t.client_id) as client_name';

		if ($this->status == 'open')
			$criteria->addNotInCondition('status', array('12', '13')); //закрыт или отменен
 elseif ($this->status !== '')
			$criteria->compare('status', $this->status);

		return $criteria;
	}

	public function totals($id) {
		$criteria = $this->getSearchCriteria();
		$criteria->select = 'IFNULL((SELECT SUM(sum) FROM ' . Yii::app()->db->tablePrefix . 'invoices WHERE order_id = ' . $id . '),0) as invoices_sum';
		return $this->commandBuilder->createFindCommand($this->getTableSchema(), $criteria)->queryScalar();
	}

	function mdlContracts($order_id) {
		return new CActiveDataProvider('Contracts', array(
			'criteria' => array('condition' => 'order_id=' . $order_id),
			'sort' => array('defaultOrder' => 'id DESC'),
			'pagination' => array(
				'pageSize' => Yii::app()->config->get('global.per_page'),)
		));
	}

	function mdlActs($order_id) {
		return new CActiveDataProvider('Acts', array(
			'criteria' => array('condition' => 'order_id=' . $order_id),
			'sort' => array('defaultOrder' => 'id DESC'),
			'pagination' => array(
				'pageSize' => Yii::app()->config->get('global.per_page'),)
		));
	}

	function mdlInv($order_id) {
		return new CActiveDataProvider('Invoices', array(
			'criteria' => array('condition' => 'order_id=' . $order_id),
			'sort' => array('defaultOrder' => 'id DESC'),
			'pagination' => array(
				'pageSize' => Yii::app()->config->get('global.per_page'),)
		));
	}

	function mdlInvFkt($order_id) {
		return new CActiveDataProvider('InvoicesFkt', array(
			'criteria' => array('condition' => 'order_id=' . $order_id),
			'sort' => array('defaultOrder' => 'id DESC'),
			'pagination' => array(
				'pageSize' => Yii::app()->config->get('global.per_page'),)
		));
	}

	function mdlPay($order_id) {
		return new CActiveDataProvider('Payments', array(
			'criteria' => array('with' => array('client'), 'condition' => 'order_id=' . $order_id),
			'sort' => array('defaultOrder' => 't.id DESC'),
			'pagination' => array(
				'pageSize' => Yii::app()->config->get('global.per_page'),)
		));
	}

	function mdlWorks($order_id) {
		return new CActiveDataProvider('Works', array(
			'criteria' => array(
//				'select' => 't.*, IFNULL((SELECT SUM(cost*quantity) from ' . Yii::app()->db->tablePrefix . 'works WHERE
//order_id=' . $order_id . ' AND act_id IS NULL ORDER BY id DESC LIMIT 1),0) as works_sum_order',
				'condition' => 'order_id=' . $order_id . ' AND act_id IS NULL'),
			'sort' => array('defaultOrder' => 't.id DESC'),
			'pagination' => array(
				'pageSize' => Yii::app()->config->get('global.per_page'),)
		));
	}

	/**
	 * used in works
	 * @return array
	 */
	public function listData() {
		$l = $this->with(array('client' => array('select' => 'name')))->findAll(array('select' => 'id,name,date,client.name as client_name', 'order' => 't.id DESC'));
//		CVarDumper::dump($l,20,true);die;
		foreach ($l as $d) {
			$r[$d->id] = '[' . $d->id . '] [' . $d->date . '] [' . $d->client_name . '] - ' . $d->name;
		}
		return $r;
	}

	public function itemAlias($type, $item=NULL) {
		$_items = array(
			// для выбора статуса заказа
			'status' => array(
				'1' => 'В планах', '2' => 'Не оплачено, не сделано', '3' => 'Оплачено, не сделано', '4' => 'Не оплачено, сделано',
				'5' => 'Оплачено, сделано', '6' => 'Оплачено, выполняется', '7' => 'Не оплачено, выполняется', '8' => 'На оплате, выполняется',
				'9' => 'На оплате, не сделано', '10' => 'На оплате, сделано', '11' => 'Оплачивается, выполняется', '12' => 'Закрыто', '13' => 'Отменено',
			),
			// для выбора фильтрации
			'fstatus' => array(
				'1' => 'В планах', '2' => 'Не оплачено, не сделано', '3' => 'Оплачено, не сделано', '4' => 'Не оплачено, сделано',
				'5' => 'Оплачено, сделано', '6' => 'Оплачено, выполняется', '7' => 'Не оплачено, выполняется', '8' => 'На оплате, выполняется',
				'9' => 'На оплате, не сделано', '10' => 'На оплате, сделано', '11' => 'Оплачивается, выполняется', '12' => 'Закрыто', '13' => 'Отменено',
				'open' => '[Действующие]',
			),
//			'clients' => Clients::model()->listArray()
		);
		if ($item == NULL)
			return isset($_items[$type]) ? $_items[$type] : false;
		else
			return isset($_items[$type][$item]) ? $_items[$type][$item] : false;
	}

}