<?php
class User extends BaseUser
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}