<?php
namespace frontend\controllers;
use common\models\ServicePizza;
use frontend\models\OrderForm;
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

    public function actionAjaxorder()
    {
        // не использоваь ActiveForm классы
        // написать свою валидацию для полей
        // использовать AJAX для ассинхронной подгрузки пицц
        if($this->Service_Pizza->Order_AjaxPizza($model, $items))
        {

        }

        return $this->render('ajaxorder',[
            'model' => $model,
            'items' => $items
        ]);
    }

}



























