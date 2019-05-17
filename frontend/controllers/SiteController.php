<?php
namespace frontend\controllers;

use common\models\Order;
use common\models\Pizza;
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
    
    public function actionCreate()
    {
        $model = new CreatePizzaForm();
        $ingridients = new PizzaIngridient();
        $items = ArrayHelper::map(Ingridient::find()->all(),'id_ingridient','name');
        if($model->load(Yii::$app->request->post()) && $ingridients->load(Yii::$app->request->post()))
        {

            $pizza = new Pizza();
            
            $pizza->CreateCustomPizza($model,$ingridients);
            
            $ingridients->saveIngridients($pizza->id_pizza);
            
            $order = new Order();
            $order->CreateCustomOrder($model,$pizza);

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



























