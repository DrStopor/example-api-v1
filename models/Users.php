<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $pk_user_id Первичный ключ
 * @property int $id Идентификатор пользователя
 * @property string $first_name Имя пользователя
 * @property string $last_name Фамилия пользователя
 * @property string $city Город
 * @property string $country Страна
 * @property string $created_at Дата создания записи
 * @property string $updated_at Дата обновления записи
 *
 * @property UsersSessions $usersSessions
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'first_name', 'last_name', 'city', 'country'], 'required'],
            [['id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['first_name', 'last_name', 'city', 'country'], 'string', 'max' => 2048],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pk_user_id' => 'Первичный ключ',
            'id' => 'Идентификатор пользователя',
            'first_name' => 'Имя пользователя',
            'last_name' => 'Фамилия пользователя',
            'city' => 'Город',
            'country' => 'Страна',
            'created_at' => 'Дата создания записи',
            'updated_at' => 'Дата обновления записи',
        ];
    }

    /**
     * Gets query for [[UsersSessions]].
     *
     * @return \yii\db\ActiveQuery|UsersSessionsQuery
     */
    public function getUsersSessions()
    {
        return $this->hasOne(UsersSessions::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
}
