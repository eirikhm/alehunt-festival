<?php
class BeerType extends BaseBeerType
{
    /**
   	 * @return array relational rules.
   	 */
   	public function relations()
   	{
   		// NOTE: you may need to adjust the relation name and the related
   		// class name for the relations automatically generated below.
   		return array(
               'beers' => array(self::HAS_MANY, 'Beer', 'beer_type_id'),
               'parentType' => array(self::BELONGS_TO, 'BeerType', 'parent'),
               'childrenTypes' => array(self::HAS_MANY, 'BeerType', 'parent'),
               'beerCount' => array(self::STAT,      'Beer', 'beer_type_id'),
   		);
   	}

    public static function model($className=__CLASS__)
   	{
   		return parent::model($className);
   	}
}