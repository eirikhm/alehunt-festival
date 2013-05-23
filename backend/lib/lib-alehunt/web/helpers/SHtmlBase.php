<?php
define('NOW', time());
define('ONE_MINUTE', 60);
define('ONE_HOUR', 3600);
define('ONE_DAY', 86400);
define('ONE_WEEK', ONE_DAY * 7);
define('ONE_MONTH', ONE_WEEK * 4);
define('ONE_YEAR', ONE_MONTH * 12);
abstract class SHtmlBase
{
    public static function getTextForUnitType($id)
    {
        $str = '';
        switch ($id)
        {
            case VenueBeer::UNIT_BOTTLE:
                $str = 'Bottle';
                break;
            case VenueBeer::UNIT_CASK:
                $str = 'Cask';
                break;
            case VenueBeer::UNIT_KEG:
                $str = 'Draft';
                break;
            default:
                $str = 'Unknown';
                break;

        }

        return $str;
    }

    public static function fuzzyTime($time)
    {
        if(($time = strtotime($time)) == false)
        {
            return 'an unknown time';
        }

        // sod = start of day :)
        $sod     = mktime(0, 0, 0, date('m', $time), date('d', $time), date('Y', $time));
        $sod_now = mktime(0, 0, 0, date('m', NOW), date('d', NOW), date('Y', NOW));

        // used to convert numbers to strings
        $convert = array(1  => 'one',
                         2  => 'two',
                         3  => 'three',
                         4  => 'four',
                         5  => 'five',
                         6  => 'six',
                         7  => 'seven',
                         8  => 'eight',
                         9  => 'nine',
                         10 => 'ten',
                         11 => 'eleven');

        // today
        if($sod_now == $sod)
        {
            if($time > NOW - (ONE_HOUR))
            {
                return 'just now';
            }
            return 'today';
        }

        // yesterday
        if(($sod_now - $sod) <= ONE_DAY)
        {
            if(date('i', $time) > (ONE_MINUTE + 30))
            {
                $time += ONE_HOUR / 2;
            }
            //return 'yesterday around ' . date( 'ga', $time );
            return 'yesterday';
        }

        // within the last 5 days
        if(($sod_now - $sod) <= (ONE_DAY * 5))
        {
            $str = date('l', $time);
            return $str;
        }

        // number of weeks (between 1 and 3)...
        if(($sod_now - $sod) < (ONE_WEEK * 3.5))
        {
            if(($sod_now - $sod) < (ONE_WEEK * 1.5))
            {
                return 'about a week ago';
            }
            else if(($sod_now - $sod) < (ONE_DAY * 2.5))
            {
                return 'about two weeks ago';
            }
            else
            {
                return 'about three weeks ago';
            }
        }

        // number of months (between 1 and 11)...
        if(($sod_now - $sod) < (ONE_MONTH * 11.5))
        {
            for ($i = (ONE_WEEK * 3.5), $m = 0; $i < ONE_YEAR; $i += ONE_MONTH, $m++)
            {
                if(($sod_now - $sod) <= $i)
                {
                    return 'about ' . $convert[$m] . ' month' . (($m > 1) ? 's' : '') . ' ago';
                }
            }
        }

        // number of years...
        for ($i = (ONE_MONTH * 11.5), $y = 0; $i < (ONE_YEAR * 10); $i += ONE_YEAR, $y++)
        {
            if(($sod_now - $sod) <= $i)
            {
                return 'about ' . $convert[$y] . ' year' . (($y > 1) ? 's' : '') . ' ago';
            }
        }

        // more than ten years...
        return 'more than ten years ago';
    }

    public static function niceTime($time)
    {
        return ucfirst(self::fuzzyTime($time));
    }

    public static function brewerImage(BaseBrewer $brewer)
    {
        $filename = self::brewerImageUrl($brewer);
        return CHtml::image($filename,$brewer->title,array('width' => '100'));
    }

    public static function brewerImageUrl(BaseBrewer $brewer)
    {
        $id = $brewer->id;
        $basePath = APP_ROOT.'/webroot';

        if (!is_numeric($id))
        {
            return Yii::app()->params['site_url'].'/content/images/no_brewer.png';
        }
        $filename = '/content/brewers/'.$id.'.png';


        if (!file_exists($basePath.$filename))
        {
            $filename = '/content/images/no_brewer.png';
        }
        return Yii::app()->params['site_url'].$filename;
    }

    public static function beerImage(BaseBeer $beer)
    {
        return self::beerImageAlt($beer->id,$beer->title);
    }

    public static function beerImageAlt($id,$title)
    {
        $filename = self::beerImageUrl($id,$title);
        return CHtml::image($filename,$title,array('width' => '100'));
    }

    public static function beerImageUrl($id)
    {
        $basePath = APP_ROOT.'/webroot';

        if (!is_numeric($id))
        {
            return Yii::app()->params['site_url'].'/content/images/no_beer.png';
        }

        $filename = '/content/beers/'.$id.'.png';
        if (!file_exists($basePath.$filename))
        {
            $filename = '/content/images/no_beer.png';
        }

        return Yii::app()->params['site_url'].$filename;

    }

    public static function venueImage(BaseVenue $venue)
    {
        return self::venueImageAlt($venue->id,$venue->title);
    }

    public function venueImageUrl(BaseVenue $venue)
    {
        return self::venueImageUrlAlt($venue->id);
    }

    public static function venueImageAlt($id,$title)
    {
        $filename = self::venueImageUrlAlt($id);
        return CHtml::image($filename,$title,array('width' => '100'));
    }

    public function venueImageUrlAlt($id)
    {
        $basePath = APP_ROOT.'/webroot';

        if (!is_numeric($id))
        {
            return Yii::app()->request->baseUrl.'/content/images/no_beer.png';
        }
        $filename = '/content/venues/'.$id.'.png';

        if (!file_exists($basePath.$filename))
        {
            $filename = Yii::app()->request->baseUrl.'/content/images/no_beer.png';
        }
        return Yii::app()->params['site_url'].$filename;
    }

    public static function flagImage($country)
    {
        $basePath = APP_ROOT.'/webroot';
        $country  = strtolower($country);
        $filename = '/content/images/flags/'.$country.'.png';

        if (!file_exists($basePath.$filename))
        {
            return $country;
        }

        return CHtml::image(Yii::app()->request->baseUrl.$filename,$country);
    }

}