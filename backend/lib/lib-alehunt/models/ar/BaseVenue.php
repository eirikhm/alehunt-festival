<?php
/**
 * This is the model class for table "venue".
 *
 * The followings are the available columns in table 'venue':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $created
 * @property integer $country_id
 * @property integer $is_event
 * @property integer $tap_lines
 */
class BaseVenue extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseVenue the static model class
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
		return 'venue';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title,city_id,slug', 'required'),
            array('city_id, is_event, is_shop, parent_id, tap_lines', 'numerical', 'integerOnly'=>true),
            array('country_id', 'length', 'max'=>2),
            //array('lat, lng', 'numerical'), stored with , for now. validate will break
			array('title,address,website', 'length', 'max'=>255),
			array('description, created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, tap_lines, description, created, country_id', 'safe', 'on'=>'search'),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'id' => 'ID',
            'title' => 'Title',
            'address' => 'Address',
            'city_id' => 'City',
            'website' => 'Website',
            'description' => 'Description',
            'is_event' => 'Is Event',
            'is_shop' => 'Is Bottleshop',
            'created' => 'Created',
            'country_id' => 'Country',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'tap_lines' => 'Tap Lines',
            'slug' => 'Slug',
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

        $criteria->compare('address',$this->address,true);
        $criteria->compare('city_id',$this->city_id);

        $criteria->compare('website',$this->website,true);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('is_event',$this->is_event,true);
        $criteria->compare('is_shop',$this->is_event,true);

        $criteria->compare('created',$this->created,true);


        $criteria->compare('country_id',$this->country_id,true);

        //$criteria->compare('lat',$this->lat,true);
        //$criteria->compare('lng',$this->lng,true);

//        $criteria->compare('tap_lines',$this->tap_lines,true);
        $criteria->compare('slug',$this->slug,true);


        $criteria->order = 'title';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}