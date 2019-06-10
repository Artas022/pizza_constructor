<?php
namespace frontend\controllers;
use common\models\IngridientRepository;
use common\models\Pizza;
use common\models\ServicePizza;
use frontend\models\CreatePizzaForm;
use frontend\models\OrderForm;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\PizzaRepository;
use yii\web\Response;


class SiteController extends Controller
{
    private $Service_Pizza;
    private $Repo;
    private $Repo_ingr;

    public function __construct($id, $module, array $config=[])
    {
        parent::__construct($id, $module, $config);
        $this->Service_Pizza = Yii::$container->get(ServicePizza::class);
        $this->Repo = Yii::$container->get(PizzaRepository::class);
        $this->Repo_ingr = Yii::$container->get(IngridientRepository::class);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    // конструктор пицц и их заказ
    public function actionCreate()
    {
        // загрузка моделей и валидация
        $model = new CreatePizzaForm();
        if($this->Service_Pizza->Order_CustomPizza(Yii::$app->request->post(), $model))
            return $this->goHome();

        return $this->render('create', [
                'model' => $model,
                'items' => $this->Repo->getMapIngridients(),
            ]
        );
    }

    // основная страница
    public function actionIndex()
    {
        return $this->render('index',[
            "menu" => $this->Repo->getAllPizza(),
        ]);
    }
    
    // заказ готовых пицц
    public function actionOrder()
    {
        $model = new OrderForm();
        if($this->Service_Pizza->Order_Pizza(Yii::$app->request->post(), $model) )
            return $this->goHome();

        return $this->render('order',[
            'model' => $model,
            'items' => $this->Repo->getMapPizza(),
        ]);
    }

    // заказ готовых пицц (AJAX)
    public function actionAjaxorder()
    {
        if(Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->Service_Pizza->validate_order($_POST);
        }
        return $this->render('ajaxorder',[
            'items' => $this->Repo->getAllPizzaIdTitle()
        ]);
    }

    // конструктор пицц и их заказ (AJAX)
    public function actionAjaxcreate()
    {
        if(Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->Service_Pizza->validate_ajax($_POST);
        }
        
        return $this->render('ajaxcreate',[
            'items' => $this->Repo_ingr->getAllIngridients()
        ]);
    }

    // поле с собственным полем похожим на select2
    public function actionSelect2()
    {
        if(Yii::$app->request->isPost)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return json_encode($this->Repo_ingr->getMapIngridients(), JSON_UNESCAPED_UNICODE);
        }
        return $this->render('select2');
    }
    
}



























