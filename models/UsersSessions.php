<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_sessions".
 *
 * @property int $user_id FK ID пользователя
 * @property string $access_token Токен
 *
 * @property Users $user
 */
class UsersSessions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_sessions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'access_token'], 'required'],
            [['user_id'], 'integer'],
            [['access_token'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'FK ID пользователя',
            'access_token' => 'Токен',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersSessionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersSessionsQuery(get_called_class());
    }
}
