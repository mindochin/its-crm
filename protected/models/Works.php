<?php

/**
 * This is the model class for table "{{works}}".
 *
 * The followings are the available columns in table '{{works}}':
 * @property integer $id
 * @property string $date
 * @property integer $client_id
 * @property integer $order_id
 * @property integer $act_id
 * @property string $name
 * @property string $unit
 * @property double $cost
 * @property string $group
 * @property integer $quantity
 * @property string $location
 */
class Works extends CActiveRecord {

	public $works_sum_order; //used in orders
	public $sum; //(cost*quantity) as sum

	/**
	 * Returns the static model of the specified AR class.
	 * @return Works the static model class
	 */

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{works}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, cost, unit, quantity, group, client_id', 'required'),
			array('client_id, order_id, act_id, quantity', 'numerical', 'integerOnly' => true),
			array('cost', 'numerical'),
			array('name, unit', 'length', 'max' => 255),
			array('group', 'length', 'max' => 8),
			array('location', 'length', 'max' => 100),
			array('date', 'date', 'format' => 'yyyy-MM-dd', 'allowEmpty' => true,),
			array('order_id, act_id, date, location','default', 'setOnEmpty' => true, 'value' => null),			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date, client_id, order_id, act_id, name, unit, cost, group, quantity, location, sum', 'safe', 'on' => 'search'),
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
			'date' => 'Дата',
			'client_id' =>'Клиент',
			'order_id' => 'Заказ №',
			'act_id' => 'Акт №',
			'name' => 'Наименование',
			'unit' => 'Ед.изм.',
			'cost' => 'Стоимость',
			'group' => 'Группа',
			'quantity' => 'Кол-во',
			'location' => 'Место',
			'sum' => 'Сумма'
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
		$criteria->compare('date', $this->date, true);
		$criteria->compare('client_id', $this->client_id);
		$criteria->compare('order_id', $this->order_id);
		$criteria->compare('act_id', $this->act_id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('unit', $this->unit, true);
		$criteria->compare('cost', $this->cost, true);
		$criteria->compare('group', $this->group);
		$criteria->compare('quantity', $this->quantity);
		$criteria->compare('location', $this->location, true);
		$criteria->compare('sum', $this->sum, true);

		$criteria->select = '*, (cost*quantity) as sum';

		$criteria->with=array('order','client','act');
		
		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 't.id DESC'),
			'pagination' => array(
				'pageSize' => Yii::app()->config->get('global.per_page'),)
		));
	}

	/**
	 * used in orders
	 * @param dataprovider $provider
	 * @return numeric
	 */
	public function sumByOrder($provider) {
		(float) $total = 0.00;
		foreach ($provider->data as $item)
			$total+=$item->cost*$item->quantity;
		return number_format($total, 2, '.', '');
	}

	public function itemAlias($type, $item=NULL) {
		$_items = array(
			'group' => array(
				'services' => 'Работы\Услуги',
				'goods' => 'Материалы\Оборудование',
			),
			'unit' =>array(
				'шт.'=>'шт.',
				'уп.'=>'уп.',
			)
		);
		if ($item == NULL)
			return isset($_items[$type]) ? $_items[$type] : false;
		else
			return isset($_items[$type][$item]) ? $_items[$type][$item] : false;
	}

	/**
	 * получить позиции заказа (исп. в акте и счете)
	 * @param <type> $id
	 * @return <type>
	 */
	public function worksByOrder($order_id, $act_id=false, $works=false) {

		$q = Yii::app()->db->createCommand();
		$q->select('*, (cost*quantity) as sum');
		$q->from('{{works}}');
		//все работы по заказу
		if ($act_id == false and $works == false) {
			$q->where('order_id=:order_id', array(':order_id' => (int) $order_id));
		}
		//обновить указанные работы по акту из заказа
		elseif ($act_id !== false and $works !== false) {
			parse_str($works); // получим $Works из акта
			//очистим все потом добавим указанные
//			$this->updateAll(array('act_id' => null), array('condition' => 'act_id=' . (int) $act_id));
//			$this->updateByPk($Works, array('act_id' => (int) $act_id), array('condition' => 'order_id=' . (int) $order_id));
//			$q->where('order_id=:order_id and act_id=:act_id', array(':order_id' => (int) $order_id, ':act_id' => (int) $act_id));
		
			$q->where(array('and','order_id is null or order_id=:order_id', array('in','id',$Works)),array(':order_id' => (int) $order_id));
		}
		//все работы по заказу без актов
		elseif ($act_id == false and $works !== false) {
			parse_str($works); // получим $Works

			$q->where(array('and', 'order_id is null or order_id=:order_id and act_id is null', array('in', 'id', $Works)), array(':order_id' => (int) $order_id));
		}
		//все работы по акту из заказа
		elseif ($act_id !== false and $works == false) {
			$q->where('order_id=:order_id and act_id=:act_id', array(':order_id' => (int) $order_id, ':act_id' => (int) $act_id));
		}
		$q->order('date');
		return $q->queryAll();

//		$criteria = new CDbCriteria;
//		$criteria->select = '*, (cost*quantity) as sum';
//		$criteria->order = 'date';
//
//		if ($act_id == false and $works == false) {
//			$criteria->condition = 'order_id=:order_id';
//			$criteria->params = array(':order_id' => (int) $order_id);
//		}
//		elseif ($act_id!==false and $works !== false) {
//			parse_str($works); // получим $Works из акта
//			//очистим потом добавим
//			$this->updateAll(array('act_id' => null), array('condition' => 'act_id=' . (int) $act_id));
//			$this->updateByPk($Works, array('act_id' => (int) $act_id), array('condition' => 'order_id=' . (int) $order_id));
//			$criteria->condition = 'order_id=:order_id and act_id=:act_id';
//			$criteria->params = array(':order_id' => (int) $order_id, ':act_id' => (int) $act_id);
//		}
//		elseif ($act_id==false and $works !== false) {
//			parse_str($works); // получим $Works из акта
//
//			$criteria->condition = 'order_id=:order_id and act_id=:act_id';
//			$criteria->addInCondition('id',$works);
//			$criteria->params = array(':order_id' => (int) $order_id, ':act_id' => (int) $act_id);
//		}
//		return $this->findAll($criteria);
	}

}