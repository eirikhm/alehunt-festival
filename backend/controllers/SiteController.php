<?php

Yii::import('alehunt.models.Beer');
Yii::import('alehunt.models.BeerType');
Yii::import('alehunt.models.Brewer');
Yii::import('alehunt.models.Venue');
class SiteController extends Controller
{
    public function actionData()
    {
        $venue       = Venue::model()->findByPk(159);
        $kegBeers    = $venue->kegVenueBeers;
        $bottleBeers = $venue->bottleVenueBeers;
        $beers     = array();
        $breweries = array();
        foreach ($kegBeers as $venueBeer)
        {
            if (!isset($beers[$venueBeer->beer->id]))
            {
                $beers[$venueBeer->id]            = $venueBeer->beer->attributes;
                $beers[$venueBeer->id]['brewery'] = $venueBeer->beer->brewer->title;
                $beers[$venueBeer->id]['style']   = $venueBeer->beer->type->name;
            }

            if (!isset($breweries[$venueBeer->beer->brewer->id]))
            {
                $breweries[$venueBeer->beer->brewer->id]               = $venueBeer->beer->brewer->attributes;
                $breweries[$venueBeer->beer->brewer->id]['beer_count'] = 1;
            }
            else
            {
                $breweries[$venueBeer->beer->brewer->id]['beer_count'] += 1;
            }
        }

        foreach ($bottleBeers as $venueBeer)
        {
            if (!isset($beers[$venueBeer->beer->id]))
            {
                $beers[$venueBeer->id]            = $venueBeer->beer->attributes;
                $beers[$venueBeer->id]['brewery'] = $venueBeer->beer->brewer->title;
                $beers[$venueBeer->id]['style']   = $venueBeer->beer->type->name;
            }

            if (!isset($breweries[$venueBeer->beer->brewer->id]))
            {
                $breweries[$venueBeer->beer->brewer->id]               = $venueBeer->beer->brewer->attributes;
                $breweries[$venueBeer->beer->brewer->id]['beer_count'] = 1;
            }
            else
            {
                $breweries[$venueBeer->beer->brewer->id]['beer_count'] += 1;

            }
        }

        ob_start('ob_gzhandler');
        echo json_encode(array('beers' => array_values($beers), 'breweries' => array_values($breweries)));
        header('Content-type: application/json');
        header("Content-Length: " . ob_get_length());
        ob_end_flush();
    }
}