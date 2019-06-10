<?php

namespace backend\controllers;

use common\models\IngridientRepository;
use common\models\Pizza;
use common\models\PizzaIngridient;
use common\models\PizzaRepository;
use common\models\ServicePizza;
use Yii;
use app\models\PizzaSearch;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class PizzaController extends Controller
{
    private $Pizza_Service;
    private $Repo;
    private $Repo_Ingr;
    public function __construct($id, $module, array $config=[])
    {
        parent::__construct($id, $module, $config);
        $this->Pizza_Service = Yii::$container->get(ServicePizza::class);
        $this->Repo = Yii::$container->get(PizzaRepository::class);
        $this->Repo_Ingr = Yii::$container->get(IngridientRepository::class);
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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->Repo->view($id),
            'ingridients' => $this->Repo_Ingr->getPizzaIngridients($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Pizza();
        $ingridients = new PizzaIngridient();
        if ($this->Pizza_Service->create(Yii::$app->request->post(), $model, $ingridients) )
            return $this->redirect(['view', 'id' => $model->id_pizza]);

        return $this->render('create', [
            'model' => $model,
            'ingridients' => $ingridients,
            'items' => $this->Repo_Ingr->getMapIngridients(),
        ]);
    }

    public function actionUpdate($id)
    {
        $model = new Pizza();
        $ingridients = new PizzaIngridient();
        if ($this->Pizza_Service->update(Yii::$app->request->post(), $id, $model, $ingridients))
            return $this->redirect(['view', 'id' => $model->id_pizza]);

        return $this->render('update', [
            'model' => $model,
            'ingridients' => $ingridients,
            'items' => $this->Repo_Ingr->getMapIngridients(),
        ]);
    }

    public function actionDelete($id)
    {
        $this->Pizza_Service->delete($id);
        return $this->redirect(['index']); 
    }
    
}
