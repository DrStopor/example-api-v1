<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "users_sessions".
 *
 * @property int $user_id FK ID пользователя
 * @property string $access_token Токен
 *
 * @property Users $user
 */
class UsersSessions extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'users_sessions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'access_token'], 'required'],
            [['user_id'], 'integer'],
            [['access_token'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
           /* [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],*/
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'user_id' => 'FK ID пользователя',
            'access_token' => 'Токен',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * @param $user_id
     * @return UsersSessions|null
     */
    public static function getUserSessionByUserId($user_id): ?UsersSessions
    {
        return self::find()->where(['user_id' => $user_id])->limit(1)->one();
    }
}
