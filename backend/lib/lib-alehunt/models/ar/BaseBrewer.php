<?php

/**
 * This is the model class for table "brewery".
 *
 * The followings are the available columns in table 'brewery':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $created
 * @property integer $country_id
 */
class BaseBrewer extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseBrewery the static model class
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
		return 'brewer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title,slug', 'required'),
            array('country_id', 'length', 'max'=>2),

			array('title', 'length', 'max'=>255),
			array('city', 'length', 'max'=>255),
			array('description, created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, description, created, country_id', 'safe', 'on'=>'search'),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'          => 'ID',
			'title'       => 'Name',
			'description' => 'Description',
			'created'     => 'Created',
			'country_id'  => 'Country',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('country_id',$this->country_id);
        $criteria->order = 'title';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,

		));
	}
}