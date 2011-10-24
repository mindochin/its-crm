<?php

/**
 * This is the model class for table "{{contracts}}".
 *
 * The followings are the available columns in table '{{contracts}}':
 * @property string $id
 * @property string $name
 * @property string $num
 * @property string $date
 * @property integer $client_id
 * @property integer $order_id
 * @property string $note
 * @property string $duedate
 * @property string $autoprolonged
 * @property integer $template_id
 * @property string $body
 * @property double $sum
 * @property string $file
 */
class Contracts extends CActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @return Contracts the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{contracts}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, body, client_id, order_id, template_id, date, autoprolonged, sum, is_sign', 'required'),
			array('client_id, order_id, template_id', 'numerical', 'integerOnly' => true),
			array('sum', 'numerical'),
			array('name, file', 'length', 'max' => 255),
			array('num', 'length', 'max' => 50),
			array('body', 'length', 'max' => 64000),
//			array('autoprolonged', 'length', 'max' => 3),
//			array('date, note, duedate', 'safe'),
			array('date,duedate', 'date', 'format' => 'yyyy-MM-dd', 'allowEmpty' => true),
			array('note,file,duedate', 'default', 'setOnEmpty' => true, 'value' => null),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, num, date, client_id, order_id, note, duedate, autoprolonged, template_id, body, sum, file, is_sign', 'safe', 'on' => 'search'),
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
			'tmpl' => array(self::BELONGS_TO, 'ContractsTmpl', 'template_id'),
			'order' => array(self::BELONGS_TO, 'Orders', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'name' => 'Предмет',
			'num' => '№№',
			'date' => 'Дата',
			'client_id' => 'Клиент',
			'order_id' => 'Заказ',
			'note' => 'Инфо',
			'duedate' => 'Действует до',
			'autoprolonged' => 'Автопродление',
			'template_id' => 'Шаблон',
			'body' => 'Текст',
			'sum' => 'Сумма',
			'file' => 'Файлы',
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

		$criteria->compare('id', $this->id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('num', $this->num, true);
		$criteria->compare('date', $this->date, true);
		$criteria->compare('client_id', $this->client_id);
		$criteria->compare('order_id', $this->order_id);
		$criteria->compare('note', $this->note, true);
		$criteria->compare('duedate', $this->duedate, true);
		$criteria->compare('autoprolonged', $this->autoprolonged, true);
		$criteria->compare('template_id', $this->template_id);
		$criteria->compare('body', $this->body, true);
		$criteria->compare('sum', $this->sum);
		$criteria->compare('is_sign', $this->is_sign);		
		$criteria->compare('file', $this->file, true);
		$criteria->with = array('client', 'tmpl');

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 't.id DESC',
				'attributes' => array(					
					'client_id' => array(
						'asc'=>'client.name asc',
						'desc'=>'client.name desc',
						),
					'*',
				)
			),
			'pagination' => array(
				'pageSize' => Yii::app()->config->get('global.per_page'),)
		));
	}

	public function itemAlias($type, $item=NULL) {
		$_items = array(
			'autoprolonged' => array('no' => 'Нет', 'yes' => 'Продлевается'),
			'is_sign' => array(
				'n' => '-', 'y'=>'Подписан'
			),
		);
		if ($item == NULL)
			return isset($_items[$type]) ? $_items[$type] : false;
		else
			return isset($_items[$type][$item]) ? $_items[$type][$item] : false;
	}

	/**
	 * выбрать шаблон для подстановки
	 * @param <type> $contract_tmpl
	 * @return <type>
	 */
	public function get_contract_tmpl($contract_tmpl) {
		return ContractsTmpl::model()->findByPk($contract_tmpl);
	}

}