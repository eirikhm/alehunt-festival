<?php

/**
 * This is the model class for table "Beer".
 *
 * The followings are the available columns in table 'Beer':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $brewer_id
 * @property integer $beer_type_id
 * @property string $created
 */
class BaseBeer extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseBeer the static model class
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
		return 'beer';
	}

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title,brewer_id,beer_type_id,slug', 'required'),
            array('brewer_id, beer_type_id,is_makro', 'numerical', 'integerOnly'=>true),
            array('abv', 'numerical'),
            array('title', 'length', 'max'=>255),
            array('description, created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, description, brewer_id, beer_type_id, created', 'safe', 'on'=>'search'),
        );
    }
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'           => 'ID',
			'title'        => 'Name',
			'description'  => 'Description',
			'brewer_id'    => 'Brewery',
			'beer_type_id' => 'Style',
			'is_makro'     => 'Is Makro beer',
			'created'      => 'Created',
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
		$criteria->compare('brewer_id',$this->brewer_id);
		$criteria->compare('beer_type_id',$this->beer_type_id);

		$criteria->compare('created',$this->created,true);

        $criteria->order = 'title';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}