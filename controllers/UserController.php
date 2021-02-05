<?php

namespace app\controllers;

use app\services\UserService;
use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $service;

    /**
     * UserController constructor.
     * @param $id
     * @param $module
     * @param UserService $service
     * @param array $config
     */
    public function __construct($id, $module, UserService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-address' => ['POST'],

                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->service->info($id);

        if (empty($model)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        list($model, $modelAddress) = $this->service->create(Yii::$app->request->post());

        if(!empty($model->errors)){
            \Yii::$app->session->setFlash('error', json_encode($model->errors));
        }

        if(!empty($modelAddress->errors)){
            \Yii::$app->session->setFlash('error', json_encode($modelAddress->errors));
        }

        if (!empty($model->id)) {
            \Yii::$app->session->setFlash('success', 'success');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'modelAddress' => $modelAddress,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->service->info($id);

        if (empty($model)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->service->delete($id);

        return $this->redirect(['index']);
    }

    public function actionCreateAddress($user_id)
    {
        $params = Yii::$app->request->post();
        $params['UserAddress']['user_id'] = $user_id;
        $model = $this->service->createAddress($params);

        if(!empty($model->errors)){
            \Yii::$app->session->setFlash('error', json_encode($model->errors));
        }

        if (!empty($model->id)) {
            return $this->redirect(['view', 'id' => $model->user_id]);
        }

        $model->user_id = $user_id;

        return $this->render('create-address', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdateAddress($id)
    {
        $model = $this->service->infoAddress($id);

        if (empty($model)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update-address', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDeleteAddress($id)
    {
        $this->service->deleteAddress($id);

        return $this->redirect(['index']);
    }
}
