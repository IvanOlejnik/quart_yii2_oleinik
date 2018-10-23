<?php

namespace frontend\models;

use yii\base\Model;

class SearchResoursForm extends Model
{
    public $id;
    public $name;
    public $count;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'string'],
            [['count'], 'integer']
        ];
    }
}