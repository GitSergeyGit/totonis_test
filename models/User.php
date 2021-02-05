<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $name
 * @property string $last_name
 * @property string $gender
 * @property string $created_at
 * @property string $email
 *
 * @property UserAddress[] $userAddresses
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @var int Нет информации
     */
    const GENDER_NONE = 0;

    /**
     * @var int Женский пол
     */
    const GENDER_FEMALE = 1;

    /**
     * @var int Мужской пол
     */
    const GENDER_MALE = 2;

    /**
     * @var array Список с "полом"
     */
    const GENDER_LIST = [
        self::GENDER_NONE => 'Нет информации',
        self::GENDER_FEMALE => 'Женский',
        self::GENDER_MALE => 'Мужской',
    ];

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => false,
                ],
                'value' => date(\DateTime::ISO8601),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'password', 'name', 'last_name', 'gender', 'email'], 'required'],
            [['login'], 'string', 'min' => 4, 'max' => 255],
            [['password'], 'string', 'min' => 4, 'max' => 255],
            [['name', 'last_name', 'email'], 'string', 'max' => 255],
            ['name', 'match', 'pattern'=>'/^[A-ZА-Я]{1}/', 'message' => 'Имя должно быть с большой буквы'],
            ['last_name', 'match', 'pattern'=>'/^[A-ZА-Я]{1}/', 'message' => 'Фамилия должна быть с большой буквы'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['gender'], 'integer'],
            ['gender', 'in', 'range' => array_keys(static::GENDER_LIST)],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'name' => 'Имя',
            'last_name' => 'Фамилия',
            'gender' => 'Пол',
            'created_at' => 'Дата создания',
            'email' => 'E-mail',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->setPassword($this->password);

            if ($this->hasErrors()) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * Gets query for [[UserAddresses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAddresses()
    {
        return $this->hasMany(UserAddress::className(), ['user_id' => 'id']);
    }

    /**
     * Generates password hash from password and sets it to the model.
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
}
