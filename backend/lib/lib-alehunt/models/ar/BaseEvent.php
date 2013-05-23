<?php

/**
 * This is the model class for table "event".
 *
 * The followings are the available columns in table 'event':
 * @property integer $id
 * @property string $ip
 * @property integer $beer_id
 * @property integer $brewer_id
 * @property integer $venue_id
 * @property integer $venue_beer_id
 * @property integer $user_id
 * @property integer $type
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Beer $beer
 * @property Brewer $brewer
 * @property Venue $venue
 * @property VenueBeer $venueBeer
 */
class BaseEvent extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Event the static model class
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
        return 'event';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ip', 'required'),
            array('param, user_id, type', 'numerical', 'integerOnly'=>true),
            array('ip', 'length', 'max'=>255),
            array('created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, ip, param, user_id, type, created', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'      => 'ID',
            'ip'      => 'IP',
            'param'   => 'Param',
            'user_id' => 'User',
            'type'    => 'Type',
            'created' => 'Created',
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
        $criteria->compare('ip',$this->ip,true);
        $criteria->compare('param',$this->param);
        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('type',$this->type);
        $criteria->compare('created',$this->created,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}