<?php
class Country extends BaseCountry
{
    /**
   	 * @return array relational rules.
   	 */
   	public function relations()
   	{
   		// NOTE: you may need to adjust the relation name and the related
   		// class name for the relations automatically generated below.
   		return array(
   			'brewers' => array(self::HAS_MANY, 'Brewer', 'country_id'),
   			'venues' => array(self::HAS_MANY, 'Venue', 'country_id'),
   		);
   	}

    public static function model($className=__CLASS__)
   	{
   		return parent::model($className);
   	}
}