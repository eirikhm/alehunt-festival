<?php
class Event extends BaseEvent
{
    // mixed with FKs this is enough to track everything.
    const EVENT_BEER_NEW        = 1;
    const EVENT_BEER_EDIT       = 2;
    const EVENT_BREWER_NEW      = 3;
    const EVENT_BREWER_EDIT     = 4;
    const EVENT_VENUE_NEW       = 5;
    const EVENT_VENUE_EDIT      = 6;
    const EVENT_VENUE_BEER_NEW  = 7;
    const EVENT_VENUE_BEER_EDIT = 8;
    const EVENT_VENUE_BEER_OFF  = 9;
    const EVENT_VENUE_BEER_ON   = 10;
    const EVENT_LOGIN           = 11;
    const EVENT_PING            = 12;
    const EVENT_REGISTER        = 13;
    const EVENT_REGISTER_FB     = 14;
    const EVENT_LINK_FB         = 15;
    const EVENT_UNLINK_FB       = 16;

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'beer' => array(self::BELONGS_TO, 'Beer', 'beer_id'),
            'brewer' => array(self::BELONGS_TO, 'Brewer', 'brewer_id'),
            'venue' => array(self::BELONGS_TO, 'Venue', 'venue_id'),
            'venueBeer' => array(self::BELONGS_TO, 'VenueBeer', 'venue_beer_id'),
        );
    }

    public static function model($className=__CLASS__)
   	{
   		return parent::model($className);
   	}


    public static function registerEvent($eventType,$param = null)
    {
        $event = new Event();
        if ($param)
        {
            $event->param = $param;
        }

        $event->type     = $eventType;
        $event->user_id  = Yii::app()->user->getId();
        $event->ip       = $_SERVER['REMOTE_ADDR'];
        $event->created  = new CDbExpression('NOW()');

        return $event->save();
    }
}