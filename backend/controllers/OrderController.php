<?php

namespace backend\controllers;

use common\models\OrderRepository;
use common\models\PizzaRepository;
use common\models\ServiceOrder;
use Yii;
use common\models\Order;
use app\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class OrderController extends Controller
{
    private $Service;
    private $Repo;
    private $Repo_pizza;

    public function __construct($id, $module, array $config=[])
    {
        parent::__construct($id, $module, $config);
        $this->Service = Yii::$container->get(ServiceOrder::class);
        $this->Repo = Yii::$container->get(OrderRepository::class);
        $this->Repo_pizza = Yii::$container->get(PizzaRepository::class);
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
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pizza_titles' => $this->Repo_pizza->getAllNotCustomPizza(),
        ]);
    }
    
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'reception' => $this->Repo->GetRecept($id),
            'pizza_titles' => $this->Repo_pizza->getAllNotCustomPizza(),
        ]);
    }
    
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_order]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post())) {
            $this->Service->ChangeOrder($model);
            return $this->redirect(['view', 'id' => $model->id_order]);
        }

        return $this->render('update', [
            'model' => $model,
            'pizza_list' => $this->Repo_pizza->getMapPizza(),
        ]);
    }
    
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null)
            return $model;

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
