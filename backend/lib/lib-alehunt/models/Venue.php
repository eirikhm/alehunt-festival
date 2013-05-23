<?php
class Venue extends BaseVenue
{

    /**
   	 * @return array relational rules.
   	 */
   	public function relations()
   	{
   		// NOTE: you may need to adjust the relation name and the related
   		// class name for the relations automatically generated below.
   		return array(
            'city' => array(self::BELONGS_TO, 'City', 'city_id'),
            'beers'       => array(self::MANY_MANY, 'Beer', 'venue_beer(venue_id, beer_id)'),
            'country'   => array(self::BELONGS_TO, 'Country', 'country_id'),
            'venueBeers'  => array(self::HAS_MANY,  'VenueBeer', 'venue_id','order' => 'updated DESC'),

            'events'  => array(self::HAS_MANY,  'Venue', 'parent_id','order' => 'created DESC'),

            'beerCount'    => array(self::STAT,      'VenueBeer', 'venue_id','condition' => 'status != 0'),
            'kegCount'    => array(self::STAT,      'VenueBeer', 'venue_id','condition' => 'status != 0 AND unit_type = '.VenueBeer::UNIT_KEG),
            'caskCount'   => array(self::STAT,      'VenueBeer', 'venue_id','condition' => 'status != 0 AND unit_type = '.VenueBeer::UNIT_CASK),
            'bottleCount' => array(self::STAT,      'VenueBeer', 'venue_id','condition' => 'status != 0 AND unit_type = '.VenueBeer::UNIT_BOTTLE),



            'kegVenueBeers'    => array(self::HAS_MANY,      'VenueBeer', 'venue_id','condition' => 'status != 0 AND unit_type = '.VenueBeer::UNIT_KEG, 'order' => 'pinged DESC,updated DESC'),
            'caskVenueBeers'   => array(self::HAS_MANY,      'VenueBeer', 'venue_id','condition' => 'status != 0 AND unit_type = '.VenueBeer::UNIT_CASK, 'order' => 'pinged DESC,updated DESC'),
            'bottleVenueBeers' => array(self::HAS_MANY,      'VenueBeer', 'venue_id','condition' => 'status != 0 AND unit_type = '.VenueBeer::UNIT_BOTTLE, 'order' => 'pinged DESC,updated DESC'),

            'historyVenueBeers' => array(self::HAS_MANY,      'VenueBeer', 'venue_id','condition' => 'status = 0', 'order' => 'updated DESC'),



             'kegBeers'    => array(self::MANY_MANY,      'Beer', 'venue_beer(venue_id, beer_id)','condition' => 'status != 0 AND unit_type = '.VenueBeer::UNIT_KEG),
             'caskBeers'   => array(self::MANY_MANY,      'Beer', 'venue_beer(venue_id, beer_id)','condition' => 'status != 0 AND unit_type = '.VenueBeer::UNIT_CASK),
             'bottleBeers' => array(self::MANY_MANY,      'Beer', 'venue_beer(venue_id, beer_id)','condition' => 'status != 0 AND unit_type = '.VenueBeer::UNIT_BOTTLE),
   		);
   	}

    public function getMoreFromCountry($count = 10)
    {
        $criteria            = new CDbCriteria();
        $criteria->limit     = $count;
        $criteria->condition = 'country_id = :country';
        $criteria->params    = array(':country' => $this->country_id);
        $criteria->order     = 'RAND()';
        return Venue::model()->findAll($criteria);
    }

    public function getToplist($cityId = 1)
    {
        $sql = "
              SELECT
                count(b.id) as beerCount,
                v.id as venueId,
                v.title as venue,
                v.slug as venueSlug,
                c.name as city,
                v.country_id as countryId,
                vb.unit_type as type
             FROM
                 venue v
                 LEFT JOIN venue_beer vb ON (vb.venue_id = v.id AND vb.status = 1)
                 LEFT JOIN beer b ON (b.id = vb.beer_id AND b.created BETWEEN DATE_SUB(NOW(), INTERVAL 14 DAY) AND NOW())
                 JOIN city c ON (v.city_id = c.id)
              WHERE c.id = 1
                 group by v.id order by beerCount desc;";

        $command = Yii::app()->db->createCommand($sql);

        return $command->queryAll();
    }

    public static function getEvents($country = 'NO')
    {
        return Venue::model()->with('city')->together()->findAll('is_event = 1 AND t.country_id = "NO"');
    }

    public static function getVenuesWithBeers($cityId = 1)
    {
        $sql = "SELECT
                count(vb.id) as beerCount,
                v.id as id,
                v.title as title,
                v.slug as slug,
                c.name as city
             FROM
                 venue v
             JOIN
                venue_beer vb ON (vb.venue_id = v.id AND vb.status != 0 AND is_event = 0)
            JOIN
                city c ON (v.city_id = c.id AND c.id = :cityId)

             GROUP BY v.id
                 ORDER BY v.title ASC;";
        $command = Yii::app()->db->createCommand($sql);

        $venues = $command->queryAll(true,array(':cityId' => $cityId));
        $items = array();

        // TODO: qucik hack for now.
        foreach($venues as $venue)
        {
            if($venue['beerCount'] > 0)
            {
                $items[] = $venue;
            }
        }
        return $items;
    }

    public static function model($className=__CLASS__)
   	{
   		return parent::model($className);
   	}

    public static function getAutoCompleteList($searchTerm,$addField = true,$cityId = null)
    {
        $params = array(':title' => '%'.$searchTerm.'%');

        $criteria = new CDbCriteria();
        $criteria->addCondition('title  LIKE :title');

        if ($cityId)
        {
            $params[':city'] = $cityId;
            $criteria->addCondition('city_id = :city');
        }

        $criteria->params = $params;
        $criteria->order = 't.title';
        $venues = Venue::model()->findAll($criteria);
        $items = array();
        foreach($venues as $venue)
        {
            $items[] = array('id' => $venue->id,'value' => $venue->id,'value' => $venue->title);
        }

        if ($addField)
        {
            $items[] = array('id' => -1,'value' => -1,'value' => 'Click here to register a new place');
        }

        return $items;
    }

    /**
     * @todo extend to support history toggle
     * @static
     * @param $brewerId
     * @param null $cityId
     * @return array
     */
    public static function getVenuesWithBrewer($brewerId,$cityId = null)
    {
        $params = array(':brewer' => $brewerId);

        $sql = 'SELECT
                       v.id as id,
                       count(b.id) as cnt,
                       v.title as title,
                       v.slug as slug,
                       v.is_event as is_event,
                       c.name as city
                    FROM
                        venue v
                    JOIN
                       venue_beer vb ON (vb.venue_id = v.id AND vb.status != 0)
                   JOIN
                       city c ON (v.city_id = c.id )
       			   JOIN
       			  	  beer b ON (vb.beer_id = b.id AND b.brewer_id = :brewer) ';

        if ($cityId)
        {
            $params[':cityId'] = $cityId;
            $sql .= "WHERE v.city_id = :cityId ";
        }

        $sql .=' GROUP BY v.id ORDER BY cnt DESC;';

        $command = Yii::app()->db->createCommand($sql);

        return $command->queryAll(true,$params);
    }

    public function hasGeoCoordinates()
    {
        return !($this->lat == 0 && $this->lng == 0);
    }

    /**
     * TODO: This is a hack for now, move to better places later!
     */
    public function geocode($update = true, $force = false)
    {
        if ((!$this->hasGeoCoordinates() || $force) && $this->address)
        {
            $pos = geocode($this->address,$this->city->name);
            if (is_array($pos) && count($pos) == 2)
            {
                $this->lat = $pos['lat'];
                $this->lng = $pos['lng'];
                if ($update)
                {
                    $this->update(array('lat','lng'));
                }
            }
        }
    }

    public function hasEvents()
    {
        return count($this->events) > 0;
    }
}