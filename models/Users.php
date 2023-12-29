<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

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
class Users extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'users';
    }

    /**
     * @return string[]
     */
    public static function primaryKey(): array
    {
        return ['pk_user_id'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
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
    public function attributeLabels(): array
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
     * @return ActiveQuery
     */
    public function getUsersSessions(): ActiveQuery
    {
        return $this->hasOne(UsersSessions::class, ['user_id' => 'id']);
    }

    /**
     * @param $id
     * @return Users|null
     */
    public static function findIdentity($id): ?Users
    {
        return self::find()
            ->where(['id' => $id])
            ->limit(1)
            ->one();
    }

    /**
     * @param $token
     * @param $type
     * @return IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        $userId = UsersSessions::find()
            ->select('user_id')
            ->where(['access_token' => $token])
            ->limit(1)
            ->one();
        return self::find()
            ->where(['id' => $userId])
            ->limit(1)
            ->one();
    }

    /**
     * @return int|string
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getAuthKey(): ?string
    {
        return null;
    }

    /**
     * @param $authKey
     * @return bool|null
     */
    public function validateAuthKey($authKey): ?bool
    {
        return null;
    }
}
