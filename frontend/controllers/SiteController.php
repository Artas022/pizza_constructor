<?php
namespace frontend\controllers;

use common\models\Order;
use common\models\Pizza;
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
    private $MakeCustomPizza_Service;

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

    public function __construct($id, $module, array $config=[])
    {
        parent::__construct($id, $module, $config);
        $this->MakeCustomPizza_Service = Yii::$container->get(ServiceMakecustompizza::class);
    }

    // создание клиентской пиццы
    public function actionCreate()
    {
        if($this->MakeCustomPizza_Service->make(Yii::$app->request->post()))
        {
            Yii::$app->session->setFlash('success', 'Ваш особый заказ принят! Наш сотрудник свяжется с вами в скором времени!');
            return $this->goHome();
        }
        
        return $this->render('create', compact('model','items','ingridients'));
    }

    public function actionIndex()
    {
        // отсекаем пользовательские пиццы
        $menu = Pizza::find()->where('is_custom = 0')->all();
        return $this->render('index',compact('menu'));
    }
    
    public function actionOrder()
    {
        $model = new OrderForm();
        $items = ArrayHelper::map(Pizza::find()->where('is_custom = 0')->all(),'id_pizza','title');
        if($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            Order::CreateOrder($model);
            Yii::$app->session->setFlash('success', 'Ваш заказ успешно отправлен в обработку! Наш сотрудник свяжется с вами в скором времени!');
            return $this->goHome();
        }
        return $this->render('order', compact('model','items'));
    }


}



























