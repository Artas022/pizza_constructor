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
    public function actionCreate()
    {
        $model = new CreatePizzaForm();
        $ingridients = new PizzaIngridient();
        $items = ArrayHelper::map(Ingridient::find()->all(),'id_ingridient','name');
        if($model->load(Yii::$app->request->post()))
        {
            $ingridients->load(Yii::$app->request->post());

            $pizza = new Pizza();
            $pizza->base = $model->base;
            $pizza->title = 'Custom';

            // Считаем стоимость пиццы по id ингредиентов в foreach
            foreach ($ingridients['ingridient_id'] as $item)
            {
                $temp = Ingridient::findOne($item['ingridient_id']);
                // Результат записываем в стоимость пиццы
                $pizza->price += $temp['price'];
            }
            $pizza->save();
            $ingridients->saveIngridients($pizza->id_pizza);

            //Создаём заказ на основе созданной пиццы
                $order = new Order();
                $order->phonenumber = $model->phonenumber;
                $order->id_pizza = $pizza->id_pizza;
                $order->payment = $pizza['price']/100;
                $order->status = 0;
                $order->save();

            Yii::$app->session->setFlash('success', 'Ваш особый заказ принят! Наш сотрудник свяжется с вами в скором времени!');
            return $this->goHome();

            }
        return $this->render('create', compact('model','items','ingridients'));
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

    public function actionIndex()
    {
        $menu = Pizza::find()->asArray()->all();
        return $this->render('index',compact('menu'));
    }
    
    public function actionOrder()
    {
        $model = new OrderForm();
        $items = ArrayHelper::map(Pizza::find()->all(),'id_pizza','title');
        if($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            foreach ($model['id_pizza'] as $item)
            {
                // найти пиццу в БД по номеру
                // добавить её стоимость в заказ
                // поставить статус выполнения 0
                // сохранить заказ
                $order = new Order();
                $order->phonenumber = $model->phonenumber;
                $order->id_pizza = $item;
                $pizza = Pizza::findOne(['id_pizza' => $item]);
                $order->payment = $pizza['price']/100;
                $order->status = 0;
                $order->save();

            }
            Yii::$app->session->setFlash('success', 'Ваш заказ успешно отправлен в обработку! Наш сотрудник свяжется с вами в скором времени!');
            return $this->goHome();
        }
        return $this->render('order', compact('model','items'));
    }


}



























