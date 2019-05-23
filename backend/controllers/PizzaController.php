<?php

namespace backend\controllers;

use common\models\PizzaRepository;
use common\models\ServicePizza;
use Yii;
use app\models\PizzaSearch;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PizzaController implements the CRUD actions for Pizza model.
 */
class PizzaController extends Controller
{
    private $Pizza_Service;
    private $Repo;

    public function __construct($id, $module, array $config=[])
    {
        parent::__construct($id, $module, $config);
        $this->Pizza_Service = Yii::$container->get(ServicePizza::class);
        $this->Repo = Yii::$container->get(PizzaRepository::class);
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
            'model' => $this->Repo->view($id),
            'ingridients' => $this->Repo->getPizzaIngridients($id),
        ]);
    }

    public function actionCreate()
    {
        if ($this->Pizza_Service->create(Yii::$app->request->post(), $model, $ingridients) )
            return $this->redirect(['view', 'id' => $model->id_pizza]);

        return $this->render('create', [
            'model' => $model,
            'ingridients' => $ingridients,
            'items' => $this->Repo->getMapIngridients(),
        ]);
    }

    public function actionUpdate($id)
    {
        if ($this->Pizza_Service->update(Yii::$app->request->post(), $id, $model, $ingridients))
            return $this->redirect(['view', 'id' => $model->id_pizza]);

        return $this->render('update', [
            'model' => $model,
            'ingridients' => $ingridients,
            'items' => $this->Repo->getMapIngridients(),
        ]);
    }

    public function actionDelete($id)
    {
        $this->Pizza_Service->delete($id);
        return $this->redirect(['index']); 
    }
    
}
