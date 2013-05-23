<?php
class Brewer extends BaseBrewer
{
    /**
   	 * @return array relational rules.
   	 */
   	public function relations()
   	{
   		// NOTE: you may need to adjust the relation name and the related
   		// class name for the relations automatically generated below.
   		return array(
            'beers' => array(self::HAS_MANY, 'Beer', 'brewer_id','order' => 'title'),
            'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
            'beerCount' => array(self::STAT,      'Beer', 'brewer_id'),
   		);
   	}

    public function formalize()
    {
        return array_merge(parent::formalize(),array(
            'og:title'          => $this->title,
            'og:description'    => $this->description,
            'og:image'          => XHtml::brewerImage($this),
            'og:url'            => Yii::app()->createAbsoluteUrl('brewer/view',array('id'=> $this->id)),
        ));
    }

    public static function model($className=__CLASS__)
   	{
   		return parent::model($className);
   	}

    public function getMoreFromCountry($count = 10)
    {
        $criteria            = new CDbCriteria();
        $criteria->limit     = $count;
        $criteria->condition = 'country_id = :country';
        $criteria->params    = array(':country' => $this->country_id);
        $criteria->order     = 'RAND()';
        return Brewer::model()->findAll($criteria);
    }

    public static function getAutoCompleteList($searchTerm)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('title  LIKE :title','OR');
        $criteria->params = array(':title' => '%'.$searchTerm.'%');
        $criteria->order = 't.title';
        $bewers = Brewer::model()->findAll($criteria);
        $items = array();
        foreach($bewers as $bewer)
        {
            $items[] = array('id' => $bewer->id,'value' => $bewer->id,'label' => $bewer->title);
        }

        $items[] = array('id' => -1,'value' => -1,'label' => 'Click here register this brewery');
        return $items;
    }
}