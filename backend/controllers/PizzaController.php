<?php

namespace backend\controllers;

use app\models\IngridientSearch;
use common\models\Ingridient;
use common\models\PizzaIngridient;
use common\models\ServicePizza;
use Yii;
use common\models\Pizza;
use app\models\PizzaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * PizzaController implements the CRUD actions for Pizza model.
 */
class PizzaController extends Controller
{
    private $Pizza_Service;

    public function __construct($id, $module, array $config=[])
    {
        parent::__construct($id, $module, $config);
        $this->Pizza_Service = Yii::$container->get(ServicePizza::class);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        //'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new PizzaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->query->where('is_custom = 0');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'ingridients' => $this->Pizza_Service->PizzaIngridients($id),
        ]);
    }

    public function actionCreate()
    {
        if ($this->Pizza_Service->create(Yii::$app->request->post()))
            return $this->redirect(['view', 'id' => $this->Pizza_Service->model->id_pizza]);

        return $this->render('create', [
            'model' => $this->Pizza_Service->model,
            'ingridients' => $this->Pizza_Service->ingridients,
            'items' => $this->Pizza_Service->AllIngridients(),
        ]);
    }

    public function actionUpdate($id)
    {
        if ($this->Pizza_Service->update(Yii::$app->request->post(), $id))
            return $this->redirect(['view', 'id' => $this->model->id_pizza]);

        return $this->render('update', [
            'model' => $this->Pizza_Service->model,
            'ingridients' => $this->Pizza_Service->ingridients,
            'items' => $this->Pizza_Service->AllIngridients(),
        ]);
    }

    public function actionDelete($id)
    {
        $this->Pizza_Service->delete($id);
        return $this->redirect(['index']); 
    }
    
}
