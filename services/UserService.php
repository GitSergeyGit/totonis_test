<?php

namespace app\services;

use app\models\User;
use app\models\UserAddress;
use yii\web\NotFoundHttpException;
use Yii;

class UserService
{
    /** @var null|User */
    public $service;

    /** @var null|UserAddress */
    public $serviceAddress;

    /**
     * UserService constructor.
     */
    public function __construct(User $user, UserAddress $serviceAddress)
    {
        $this->service = $user;

        $this->serviceAddress = $serviceAddress;
    }

    /**
     * Обёртка для транзакций
     *
     * @param callable $function
     * @return mixed
     * @throws NotFoundHttpException
     */
    private function wrap(callable $function)
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $result = $function();

            $transaction->commit();

            return $result;
        } catch (\Exception $e) {
            $transaction->rollBack();

            throw new NotFoundHttpException($e->getMessage());
        }
    }


    /**
     * Добавление новой записи, если данные не проходят, метод вернет пустые модели
     *
     * @param $params
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function create($params)
    {
        return $this->wrap(function () use ($params) {
            $model = new $this->service();
            $modelAddress = new $this->serviceAddress();
            if ($model->load($params) && $modelAddress->load($params)) {
                if($model->save()){
                    $modelAddress->user_id = $model->id;
                    $modelAddress->save();
                }
            }
            return [$model, $modelAddress];
        });
    }

    /**
     * Информация про пользователя
     *
     * @param int $id
     * @return User|null
     */
    public function info(int $id): ?User
    {
        $model = $this->service::findOne($id);
        if (null == $model) {
            return null;
        }

        return $model;
    }

    /**
     * @param int $id
     * @return bool
     * @throws NotFoundHttpException
     */
    public function delete(int $id): bool
    {
        $model = $this->service::findOne($id);

        if (null == $model) {
            return false;
        }

        return $this->wrap(function () use ($model) {
            $this->serviceAddress::deleteAll(['user_id' => $model->id]);
            return $model->delete();
        });
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function deleteAddress(int $id): bool
    {
        $model = $this->serviceAddress::findOne($id);

        if (null == $model) {
            return false;
        }

        return $model->delete();
    }

    /**
     * Информация про Адресс пользвоателя
     *
     * @param int $id
     * @return UserAddress|null
     */
    public function infoAddress(int $id): ?UserAddress
    {
        $model = $this->serviceAddress::findOne($id);
        if (null == $model) {
            return null;
        }

        return $model;
    }

    /**
     * Добавление новой записи, Адресс пользвоателя
     *
     * @param $params
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function createAddress($params)
    {
        $model = new $this->serviceAddress();
        if ($model->load($params)) {
            $model->save();
        }
        return $model;
    }
}
