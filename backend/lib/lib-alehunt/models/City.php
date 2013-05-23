<?php

class City extends BaseCity
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
        );
    }

    public static function getCitiesForCountry($country = 'NO')
    {
        return City::model()->findAll('country_id = :country AND id <= 5',array(':country' => $country));
    }

}