<?php

/**
 * This is the model class for table "country".
 *
 * The followings are the available columns in table 'country':
 * @property string $iso
 * @property string $name
 * @property string $printable_name
 * @property string $iso3
 * @property integer $numcode
 *
 * The followings are the available model relations:
 * @property Brewer[] $brewers
 * @property Venue[] $venues
 */
class BaseCountry extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseCountry the static model class
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
		return 'country';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('iso, name, printable_name', 'required'),
			array('numcode', 'numerical', 'integerOnly'=>true),
			array('iso', 'length', 'max'=>2),
			array('name, printable_name', 'length', 'max'=>80),
			array('iso3', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('iso, name, printable_name, iso3, numcode', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'iso'            => 'Iso',
			'name'           => 'Name',
			'printable_name' => 'Printable Name',
			'iso3'           => 'Iso3',
			'numcode'        => 'Numcode',
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

		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('printable_name',$this->printable_name,true);
		$criteria->compare('iso3',$this->iso3,true);
		$criteria->compare('numcode',$this->numcode);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}