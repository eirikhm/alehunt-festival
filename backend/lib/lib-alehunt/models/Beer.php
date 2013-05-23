<?php
class Beer extends BaseBeer
{
    /**
   	 * @return array relational rules.
   	 */
   	public function relations()
   	{
   		// NOTE: you may need to adjust the relation name and the related
   		// class name for the relations automatically generated below.
           return array(
               'venues' => array(self::MANY_MANY, 'Venue', 'venue_beer(beer_id, venue_id)'),
               'type' => array(self::BELONGS_TO, 'BeerType', 'beer_type_id'),
               'brewer' => array(self::BELONGS_TO, 'Brewer', 'brewer_id'),
               'venueBeers' => array(self::HAS_MANY, 'VenueBeer', 'beer_id', 'condition' => 'status != 0', 'order' => 'updated DESC'),
               'venueBeersHistory' => array(self::HAS_MANY, 'VenueBeer', 'beer_id', 'condition' => 'status = 0', 'order' => 'updated DESC'),

               'caskVenueBeers'   => array(self::HAS_MANY,      'VenueBeer', 'beer_id', 'joinType' => 'LEFT JOIN','alias' => 'cask','on' => 'cask.status != 0 AND cask.unit_type = '.VenueBeer::UNIT_CASK, 'order' => 'cask.updated DESC'),
               'kegVenueBeers'    => array(self::HAS_MANY,      'VenueBeer', 'beer_id', 'joinType' => 'LEFT JOIN','alias' => 'keg','on' => 'keg.status != 0 AND keg.unit_type = '.VenueBeer::UNIT_KEG, 'order' => 'keg.updated DESC'),
               'bottleVenueBeers' => array(self::HAS_MANY,      'VenueBeer', 'beer_id', 'joinType' => 'LEFT JOIN','alias' => 'bottle','on' => 'bottle.status != 0 AND bottle.unit_type = '.VenueBeer::UNIT_BOTTLE, 'order' => 'bottle.updated DESC'),
             );
   	}
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title,brewer_id,beer_type_id', 'required'),
            array('brewer_id, beer_type_id,is_makro', 'numerical', 'integerOnly'=>true),
            array('abv', 'numerical'),
            array('title', 'length', 'max'=>255),
            array('description, created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, description, brewer_id, beer_type_id, created', 'safe', 'on'=>'search'),
        );
    }


    public static function model($className=__CLASS__)
   	{
   		return parent::model($className);
   	}
/*
    public function __construct()
    {
        $this->type = 'beerreview:beer';
    }
*/
    public function formalize()
    {
        return array_merge(parent::formalize(),array(
            'og:title'          => $this->title,
            'og:description'    => $this->description,
            'og:image'          => XHtml::beerImage($this),
            'beerreview:brewer' => Yii::app()->createAbsoluteUrl('brewer/view',array('id' => $this->brewer_id)),
            'og:url'            => Yii::app()->createAbsoluteUrl('beer/view',array('id'=> $this->id)),
        ));
    }

    public function getMoreFromStyle($count = 10)
    {
        $criteria            = new CDbCriteria();
        $criteria->limit     = $count;
        $criteria->condition = 'beer_type_id = :type';
        $criteria->params    = array(':type' => $this->beer_type_id);
        $criteria->order     = 'RAND()';
        return Beer::model()->findAll($criteria);
    }

    public function getVenueBeersForCity($cityId = null,$isHistory = false)
    {
        $params = array(':beerId' => $this->id);

        $sql = "SELECT
                    v.id as venueId,
                    v.title as venue,
                    v.slug as venueSlug,
                    vb.unit_type as unit_type,
                    vb.updated as updated,
                    vb.pinged as pinged,
                    c.name as city
                FROM
                  venue_beer vb
                JOIN venue v on (v.id = vb.venue_id)
                JOIN city c ON (v.city_id = c.id)
                WHERE
                  vb.beer_id = :beerId AND ";

                if ($cityId)
                {
                    $params[':cityId'] = $cityId;
                    $sql .= "v.city_id = :cityId AND ";
                }

                if ($isHistory)
                {
                    $sql .= 'vb.status = 0';
                }
                else
                {
                    $sql .= 'vb.status != 0';
                }

                $sql .= " ORDER BY
                  vb.updated DESC";

        $command = Yii::app()->db->createCommand($sql);
        return $command->queryAll(true,$params);

    }

    /**
     * Returns a list of new beers in the system which is also available somewhere.
     */
    public function getNewBeers($limit = null,$cityId)
    {
        $sql = '
              SELECT
                v.id as venueId,
                v.title as venue,
                v.city_id as city,
                v.country_id as countryId,
                vb.unit_type as unit_type,
                b.created as created,
                b.slug as beerSlug,
                b.title as beer,
                b.abv as abv,
                b.id as beerId,
                br.id as brewerId,
                br.title as brewer,
                br.slug as brewerSlug,
                v.slug as venueSlug,
                bt.name as style,
                c.name as city
             FROM
                 beer b
                 JOIN venue_beer vb ON (vb.beer_id = b.id)
                 JOIN venue v ON (v.id = vb.venue_id)
                 JOIN brewer br ON (br.id = b.brewer_id)
                 JOIN beer_type bt ON (bt.id = b.beer_type_id)
                 JOIN city c ON (v.city_id = c.id)

            WHERE
            	b.created BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW() AND
            	b.is_makro = 0 AND
            	v.city_id = :cityId
			ORDER BY
				b.created desc';

        if ($limit)
            $sql .= ' LIMIT '.$limit;

        $command = Yii::app()->db->createCommand($sql);

        $result = $command->queryAll(true,array(':cityId' => $cityId));

        $beers = array();
        foreach($result as $res)
        {
            if (!isset($beers[$res['beerId']]))
            {
                $beer = array();
                $beer['id']         = $res['beerId'];
                $beer['name']       = $res['beer'];
                $beer['slug']       = $res['beerSlug'];
                $beer['brewer']     = $res['brewer'];
                $beer['brewerId']   = $res['brewerId'];
                $beer['brewerSlug'] = $res['brewerSlug'];
                $beer['style']      = $res['style'];
                $beer['created']    = $res['created'];
                $beer['abv']        = $res['abv'];
                $beer['unit_type']  = $res['unit_type'];
                $beer['venues']     = array();
                $beer['venues'][]   = array('id' => $res['venueId'],'name' => $res['venue'],'unit_type' => $res['unit_type'],'venueSlug' => $res['venueSlug'],'city' => $res['city']);
                $beers[$beer['id']] = $beer;
            }
            else
            {
                $beers[$beer['id']]['venues'][] = array('id' => $res['venueId'],'name' => $res['venue'],'unit_type' => $res['unit_type'],'venueSlug' => $res['venueSlug'],'city' => $res['city']);
            }
        }

        return $beers;

    }

    public function getNewBeersProvider()
    {
        return new CActiveDataProvider($this,array(
            'criteria' => array(
                'order' => 't.created DESC',
                'with' => array('brewer','venues'),
                'condition' => ' t.created BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()',
            ),
            'pagination' => array(
                'pageSize' => 100,
             ),
        ));
    }

    public static function getAutoCompleteList($searchTerm)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.title LIKE :title','OR');
        $criteria->addCondition('brewer.title  LIKE :title','OR');
        $criteria->params = array(':title' => '%'.$searchTerm.'%');
        $criteria->order = 'brewer.title, t.title';
        $beers = Beer::model()->with('brewer')->findAll($criteria);
        $items = array();
        foreach($beers as $beer)
        {
            $beerTitle = $beer->brewer->title . ' ' .$beer->title;
            $items[] = array('id' => $beer->id,'value' => $beerTitle);
        }

        $items[] = array('id' => -1,'value' => -1,'value' => 'Klikk her for å registrere dette ølet');
        return $items;
    }
}