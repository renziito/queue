<?php

/**
 * This is the model class for table "queue_list".
 *
 * The followings are the available columns in table 'queue_list':
 * @property integer $id
 * @property integer $order
 * @property integer $queue_id
 * @property string $username
 * @property string $args
 * @property integer $play
 * @property integer $remove
 * @property string $register_date
 * @property integer $state
 */
class QueueList extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'queue_list';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order, queue_id, username', 'required'),
			array('order, queue_id, play, remove, state', 'numerical', 'integerOnly'=>true),
			array('username, args', 'length', 'max'=>255),
			array('register_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order, queue_id, username, args, play, remove, register_date, state', 'safe', 'on'=>'search'),
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
			'order' => 'Order',
			'queue_id' => 'Queue',
			'username' => 'Username',
			'args' => 'Args',
			'play' => 'Play',
			'remove' => 'Remove',
			'register_date' => 'Register Date',
			'state' => 'State',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('order',$this->order);
		$criteria->compare('queue_id',$this->queue_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('args',$this->args,true);
		$criteria->compare('play',$this->play);
		$criteria->compare('remove',$this->remove);
		$criteria->compare('register_date',$this->register_date,true);
		$criteria->compare('state',$this->state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QueueList the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
