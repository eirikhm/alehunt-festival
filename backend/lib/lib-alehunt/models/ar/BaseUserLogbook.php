<?php

/**
 * This is the model class for table "user_logbook".
 *
 * The followings are the available columns in table 'user_logbook':
 * @property integer $id
 * @property integer $venue_id
 * @property integer $beer_id
 * @property integer $unit_type
 * @property integer $batch
 * @property string $created
 * @property string $updated
 * @property integer $rating
 * @property string $appearance
 * @property string $aroma
 * @property string $taste
 * @property string $notes
 *
 * The followings are the available model relations:
 * @property Beer $beer
 * @property Venue $venue
 */
class BaseUserLogbook extends BaseActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserLogbook the static model class
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
        return 'user_logbook';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'required'),
            array('venue_id, beer_id, unit_type, batch, rating', 'numerical', 'integerOnly'=>true),
            array('user_id', 'length', 'max'=>10),
            array('created, updated, appearance, aroma, taste, notes', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, venue_id, beer_id, unit_type, batch, created, updated, rating, appearance, aroma, taste, notes', 'safe', 'on'=>'search'),
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
            'beer' => array(self::BELONGS_TO, 'Beer', 'beer_id'),
            'venue' => array(self::BELONGS_TO, 'Venue', 'venue_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'venue_id' => 'Venue',
            'beer_id' => 'Beer',
            'unit_type' => 'Unit Type',
            'batch' => 'Batch',
            'created' => 'Created',
            'updated' => 'Updated',
            'rating' => 'Rating',
            'appearance' => 'Appearance',
            'aroma' => 'Aroma',
            'taste' => 'Taste',
            'notes' => 'Notes',
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
        $criteria->compare('user_id',$this->user_id,true);
        $criteria->compare('venue_id',$this->venue_id);
        $criteria->compare('beer_id',$this->beer_id);
        $criteria->compare('unit_type',$this->unit_type);
        $criteria->compare('batch',$this->batch);
        $criteria->compare('created',$this->created,true);
        $criteria->compare('updated',$this->updated,true);
        $criteria->compare('rating',$this->rating);
        $criteria->compare('appearance',$this->appearance,true);
        $criteria->compare('aroma',$this->aroma,true);
        $criteria->compare('taste',$this->taste,true);
        $criteria->compare('notes',$this->notes,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}