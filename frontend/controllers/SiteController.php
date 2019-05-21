<?php
namespace frontend\controllers;

use common\models\Order;
use common\models\Pizza;
use common\models\ServiceCustomPizza;
use common\models\ServiceMakecustompizza;
use frontend\models\CreatePizzaForm;
use frontend\models\OrderForm;
use common\models\Ingridient;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\PizzaIngridient;


class SiteController extends Controller
{
    private $Service_CustomPizza;

    public function __construct($id, $module, array $config=[])
    {
        parent::__construct($id, $module, $config);
        $this->Service_CustomPizza = Yii::$container->get(ServiceCustomPizza::class);
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


    // создание клиентской пиццы
    public function actionCreate()
    {
        // форма для обработки данных
        $model = new CreatePizzaForm();
        if($this->Service_CustomPizza->create((Yii::$app->request->post()), $model))
        {
            Yii::$app->session->setFlash('success', 'Ваш особый заказ принят! Наш сотрудник свяжется с вами в скором времени!');
            return $this->goHome();
        }
        return $this->render('create', [
                'model' => $model,
                'items' => ArrayHelper::map(Ingridient::find()->all(), 'id_ingridient', 'name'),
            ]
        );
    }

    public function actionIndex()
    {
        return $this->render('index',[
            "menu" => Pizza::find()->all(),
        ]);
    }
    
    public function actionOrder()
    {
        $model = new OrderForm();
        $items = ArrayHelper::map(Pizza::find()->all(),'id_pizza','title');
        if($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            Order::CreateOrder($model);
            Yii::$app->session->setFlash('success', 'Ваш заказ успешно отправлен в обработку! Наш сотрудник свяжется с вами в скором времени!');
            return $this->goHome();
        }
        return $this->render('order', compact('model','items'));
    }


}



























