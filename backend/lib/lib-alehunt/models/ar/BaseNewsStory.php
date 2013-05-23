<?php

/**
 * This is the model class for table "news_story".
 *
 * The followings are the available columns in table 'news_story':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $facebook_url
 * @property string $alehunt_url
 * @property string $image_url
 * @property integer $active
 */
class BaseNewsStory extends BaseActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return NewsStory the static model class
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
        return 'news_story';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title', 'required'),
            array('active', 'numerical', 'integerOnly'=>true),
            array('title, facebook_url, alehunt_url, image_url', 'length', 'max'=>255),
            array('description', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, description, facebook_url, alehunt_url, image_url, active', 'safe', 'on'=>'search'),
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
            'title' => 'Title',
            'description' => 'Description',
            'facebook_url' => 'Facebook Url',
            'alehunt_url' => 'Alehunt Url',
            'image_url' => 'Image Url',
            'active' => 'Active',
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
        $criteria->compare('facebook_url',$this->facebook_url,true);
        $criteria->compare('alehunt_url',$this->alehunt_url,true);
        $criteria->compare('image_url',$this->image_url,true);
        $criteria->compare('active',$this->active);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}