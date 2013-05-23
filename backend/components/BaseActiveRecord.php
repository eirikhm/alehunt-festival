<?php
class BaseActiveRecord extends CActiveRecord
{
    protected $type;
    protected $app;
    protected $url;

    public function construct()
    {
        $this->app = Yii::app()->params['facebook']['appId'];
        $this->type = 'beerreview:brewer';

    }

    public function formalize()
    {
        return array('fb:app_id' => $this->app,
                     'og:type' => $this->type,
                     'url' => $this->url);
    }
}