<?php

/**
 * This is the model class for table "queue".
 *
 * The followings are the available columns in table 'queue':
 * @property integer $id
 * @property string $username
 * @property string $queue_start
 * @property string $queue_finish
 * @property integer $state
 */
class Queue extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'queue';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username', 'required'),
            array('state', 'numerical', 'integerOnly' => true),
            array('username', 'length', 'max' => 255),
            array('queue_start, queue_finish', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, queue_start, queue_finish, state', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'queue_start' => 'Queue Start',
            'queue_finish' => 'Queue Finish',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('queue_start', $this->queue_start, true);
        $criteria->compare('queue_finish', $this->queue_finish, true);
        $criteria->compare('state', $this->state);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Queue the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
