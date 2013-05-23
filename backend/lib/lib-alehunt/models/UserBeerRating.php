<?php

class UserBeerRating extends BaseUserBeerRating
{

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function relations()
    {
        return array(
            'beer' => array(self::BELONGS_TO, 'Beer', 'beer_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    // TODO: should take user id as param
    public static function getRatingsForUser()
    {
        $sql = '
            SELECT
                ur.id as id,
                ur.rating as rating,
                ur.updated as updated,
                b.created as created,
                b.slug as beerSlug,
                b.title as beer,
                b.abv as abv,
                b.id as beerId,
                br.id as brewerId,
                br.title as brewer,
                br.slug as brewerSlug,
                bt.name as style
            FROM
              user_beer_rating ur
            JOIN beer b ON (b.id = ur.beer_id)
            JOIN brewer br ON (br.id = b.brewer_id)
            JOIN beer_type bt ON (bt.id = b.beer_type_id)

            WHERE
              ur.user_id = :userId
            ORDER BY
            b.created desc';

        $command = Yii::app()->db->createCommand($sql);

        return $command->queryAll(true,array(':userId' => Yii::app()->user->getId()));

    }
}