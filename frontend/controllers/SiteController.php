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


    // создание клиентской пиццы
    public function actionCreate()
    {
        // ассоциативный массив для записи рецептуры в JSON
        $custom_pizza = [
            'ingridient_name' => [],
            'portion' => [],
            'base' => 0,
        ];
        $model = new CreatePizzaForm();
        $ingridients = new PizzaIngridient();
        $items = ArrayHelper::map(Ingridient::find()->all(),'id_ingridient','name');
        if($model->load(Yii::$app->request->post()) && $ingridients->load(Yii::$app->request->post()))
        {
            $order = new Order();
            // Добавляем из модели формы /информацию
            $order->phonenumber = $model->phonenumber;
            $custom_pizza['base'] = $model->base;
            foreach ($ingridients['ingridient_id'] as $ingridient)
            {
                // ищем по номеру имя ингредиента и его стоимость
                $name_ingridient = Ingridient::find()->select(['price','name'])->where(['id_ingridient' => $ingridient['ingridient_id']])->one();
                // Добавляем порции и название ингредиентов
                array_push($custom_pizza['portion'],$ingridient['portions']);
                array_push($custom_pizza['ingridient_name'],$name_ingridient['name']);
                // считаем стоимость заказа
                $order->payment += ( $name_ingridient['price'] / 100) * $ingridient['portions'];
            }
            $order->payment = round($order->payment);
            // зашифровать в JSON формат и сохранить в поле заказа
            $order->custom_pizza = json_encode($custom_pizza);
            $order->save();
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



























