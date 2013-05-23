<?php
class VenueBeer extends BaseVenueBeer
{
    const UNIT_BOTTLE = 1;
    const UNIT_KEG    = 2;
    const UNIT_CASK   = 3;

    const STATUS_OFF     = 0;
    const STATUS_ON      = 1;
    const STATUS_UNSURE  = 2;

    /**
   	 * @return array relational rules.
   	 */
   	public function relations()
   	{
   		// NOTE: you may need to adjust the relation name and the related
   		// class name for the relations automatically generated below.
   		return array(
               'venue' => array(self::BELONGS_TO, 'Venue', 'venue_id'),
               'beer' => array(self::BELONGS_TO, 'Beer', 'beer_id'),
   		);
   	}

    public static function model($className=__CLASS__)
   	{
   		return parent::model($className);
   	}

    public function getBeerUpdates($limit = null,$cityId)
    {
        $sql = "SELECT
                  v.title as venue,
                  v.slug as venueSlug,
                  b.slug as beerSlug,
                  br.slug as brewerSlug,
                  v.id as venueId,
                  b.title as beer,
                  b.id as beerId,
                  b.abv, vb.updated,
                  vb.unit_type,
                  vb.updated as updated,
                  br.title as brewer,
                  br.country_id as country,
                  bt.name as beer_style,
                  c.name as city
              FROM
                venue_beer vb
            JOIN
              venue v ON (vb.venue_id = v.id and v.is_event = 0)
              JOIN beer b ON (b.id = vb.beer_id)
              JOIN brewer br ON (b.brewer_id = br.id)
              JOIN beer_type bt ON (b.beer_type_id = bt.id)
              JOIN city c ON (v.city_id = c.id)
          WHERE
            vb.status = 1 AND
            vb.updated BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW() AND
            v.city_id = :cityId AND
            b.is_makro = 0
            GROUP BY
              vb.id
            order by vb.updated DESC";


        if ($limit)
        {
            $sql .= ' LIMIT '.$limit;
        }

        $command = Yii::app()->db->createCommand($sql);
        $results = $command->queryAll(true,array(':cityId' => $cityId));
        return $results;
    }

    public static function registerVenueBeer($venueId,$beerId,$unitType)
    {
        $params = array(':beer' => $beerId, ':venue' => $venueId, ':unit' => $unitType);
        $vb = VenueBeer::model()->find('venue_id = :venue AND beer_id = :beer AND unit_type = :unit',$params);

        $isNew = false;
        if (!$vb)
        {
            $isNew         = true;
            $vb            = new VenueBeer();
            $vb->venue_id  = $venueId;
            $vb->beer_id   = $beerId;
            $vb->created   = new CDbExpression('NOW()');
            $vb->unit_type = $unitType;
        }
        else
        {
            if ($vb->venue_id == $venueId && $vb->beer_id == $beerId && $vb->unit_type == $unitType && $vb->status == VenueBeer::STATUS_ON)
            {
                return null;
            }
        }

        $vb->status  = VenueBeer::STATUS_ON;
        $vb->updated = new CDbExpression('NOW()');
        $vb->pinged  = new CDbExpression('NOW()');
        $vb->save();

        Event::registerEvent(Event::EVENT_VENUE_BEER_ON,$vb->id);
        if ($isNew)
        {
            Event::registerEvent(Event::EVENT_VENUE_BEER_NEW,$vb->id);
        }

        return $vb;
    }

    public static function emptyVenueBeer($venueBeerId)
    {
        $vb = VenueBeer::model()->findByPk($venueBeerId);
        $vb->updated = new CDbExpression('NOW()');
        $vb->pinged = null;
        $vb->status = VenueBeer::STATUS_OFF;
        $vb->save();

        Event::registerEvent(Event::EVENT_VENUE_BEER_OFF,$vb->id);
        return $vb;
    }
}