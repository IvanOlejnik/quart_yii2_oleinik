<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "resources".
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 *
 * @property UserResources[] $userResources
 * @property User[] $users
 */
class Resources extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resources';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 24],
            [['icon'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'icon' => 'Icon',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserResources()
    {
        return $this->hasMany(UserResources::className(), ['resources_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_resources', ['resources_id' => 'id']);
    }
}
