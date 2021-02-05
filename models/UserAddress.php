<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_address".
 *
 * @property int $id
 * @property int $user_id
 * @property int $postcode
 * @property string $country
 * @property string $city
 * @property string $street
 * @property string $house_number
 * @property string $apartment
 *
 * @property User $user
 */
class UserAddress extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['postcode', 'country', 'city', 'street'], 'required'],
            [['user_id', 'postcode'], 'integer'],
            [['country'], 'string', 'max' => 2],
            ['country', 'match', 'pattern'=>'/^[A-Z]/',
                'message' => 'Страна должна быть в верхнем регистре и состоять из двух символов. Пример: UA'],
            [['city', 'street', 'house_number', 'apartment'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'postcode' => 'Почтовый индекс',
            'country' => 'Страна',
            'city' => 'Город',
            'street' => 'Улица',
            'house_number' => 'Номер дома',
            'apartment' => 'Номер офиса/квартиры',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
