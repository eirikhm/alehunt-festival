<?php

class UserLogbook extends BaseUserLogbook
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
            'beer' => array(self::BELONGS_TO, 'Beer', 'beer_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'venue' => array(self::BELONGS_TO, 'Venue', 'venue_id'),
        );
    }
}