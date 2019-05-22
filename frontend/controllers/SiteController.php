<?php
namespace frontend\controllers;

use common\models\Order;
use common\models\Pizza;
use common\models\ServicePizza;
use frontend\models\OrderForm;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;


class SiteController extends Controller
{
    private $Service_Pizza;

    public function __construct($id, $module, array $config=[])
    {
        parent::__construct($id, $module, $config);
        $this->Service_Pizza = Yii::$container->get(ServicePizza::class);
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
        if($this->Service_Pizza->create_CustomPizza(Yii::$app->request->post())) //$model = $this->Service_CustomPizza->createModel()))
            return $this->goHome();

        return $this->render('create', [
                'model' => $this->Service_Pizza->model,
                'items' => $this->Service_Pizza->AllIngridients(),
            ]
        );
    }

    public function actionIndex()
    {
        return $this->render('index',["menu" => Pizza::find()->all()]);
    }

    // заказ готовых пицц
    public function actionOrder()
    {
        if($this->Service_Pizza->create_Pizza( Yii::$app->request->post()) )
            return $this->goHome();

        return $this->render('order',[
            'model' => $this->Service_Pizza->model,
            'items' => $this->Service_Pizza->AllPizza(),
        ]);
    }

}



























