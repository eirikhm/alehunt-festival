<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $email
 * @property string $password
 * @property string $balance
 * @property string $created
 */
class BaseUser extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(array('password', 'required'),
            array('email, name, password', 'length', 'max'=> 255),
            array('score', 'length','max'=> 10),
            array('created,updated', 'safe'), // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, email, password, score, created', 'safe','on'=> 'search'),);
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array('id'       => 'Id',
                     'email'    => 'E-mail',
                     'password' => 'Password',
                     'balance'  => 'Balance',
                     'created'  => 'Created',
                     'updated'  => 'Updated',);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);

        $criteria->compare('email', $this->email, true);

        $criteria->compare('password', $this->password, true);

        $criteria->compare('score', $this->score, true);

        $criteria->compare('created', $this->created, true);

        $criteria->compare('updated', $this->updated, true);

        return new CActiveDataProvider('User', array('criteria'=> $criteria,));
    }

    /**
     * This is invoked before the record is saved.
     * @return boolean whether the record should be saved.
     */
    protected function beforeSave()
    {
        if(parent::beforeSave())
        {
            if($this->isNewRecord)
            {
                $this->created = $this->created = $this->updated = new CDbExpression('NOW()');
            }
            else
            {
                $this->updated = new CDbExpression('NOW()');
            }

            return true;
        }
        else
        {
            return false;
        }
    }
}