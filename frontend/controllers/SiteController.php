<?php
namespace frontend\controllers;
use common\models\ServicePizza;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\PizzaRepository;


class SiteController extends Controller
{
    private $Service_Pizza;
    private $Repo;

    public function __construct($id, $module, array $config=[])
    {
        parent::__construct($id, $module, $config);
        $this->Service_Pizza = Yii::$container->get(ServicePizza::class);
        $this->Repo = Yii::$container->get(PizzaRepository::class);
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
            $this->Service_Pizza->validate_order($_POST);

        return $this->render('ajaxorder',[
            'items' => $this->Repo->getAllPizzaIdTitle()
        ]);
    }

    // конструктор пицц и их заказ (AJAX)
    public function actionAjaxcreate()
    {
        if(Yii::$app->request->isAjax)
            $this->Service_Pizza->validate_ajax($_POST);
        
        return $this->render('ajaxcreate',[
            'items' => $this->Repo->getAllIngridients()
        ]);
    }

}



























