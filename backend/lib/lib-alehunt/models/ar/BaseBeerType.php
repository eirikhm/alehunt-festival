<?php

/**
 * This is the model class for table "beer_type".
 *
 * The followings are the available columns in table 'beer_type':
 * @property integer $id
 * @property string $name
 * @property integer $parent
 */
class BaseBeerType extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return BeerType the static model class
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
		return 'beer_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('parent', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, parent', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'     => 'ID',
			'name'   => 'Style',
			'parent' => 'Base Style',
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

		$criteria->compare('name',$this->name,true);

		$criteria->compare('parent',$this->parent);

        $criteria->order = 'name';

		return new CActiveDataProvider('BeerType', array(
			'criteria'=>$criteria,
		));
	}
}