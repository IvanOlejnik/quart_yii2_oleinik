<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Resources;
use frontend\models\SearchResoursForm;
use yii2tech\ar\position\PositionBehavior;


/**
 * This is the model class for table "user_resources".
 *
 * @property int $user_id
 * @property int $resources_id
 * @property int $count
 *
 * @property Resources $resources
 * @property User $user
 */
class UserResources extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
     public function behaviors()
    {
        return [
            'positionBehavior' => [
                'class' => PositionBehavior::className(),
                'positionAttribute' => 'position',
            ],
        ];
    } 
     
    public static function tableName()
    {
        return 'user_resources';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'resources_id'], 'required'],
            [['user_id', 'resources_id', 'count'], 'integer'],
            [['user_id', 'resources_id'], 'unique', 'targetAttribute' => ['user_id', 'resources_id']],
            [['resources_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resources::className(), 'targetAttribute' => ['resources_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'resources_id' => 'Resources ID',
            'count' => 'Count',
            //'id' => 'ID',
            //'name' => 'Name',
            //'icon' => 'Icon',
        ];
    }

    public static function findIdentity($user_id,$resources_id)
    {
        return static::findOne(['user_id' => $user_id, 'resources_id' => $resources_id]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResources()
    {
        $query = $this->hasOne(Resources::className(), ['id' => 'resources_id']);

        return $query;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
