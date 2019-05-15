<?php

namespace backend\controllers;

use common\models\Ingridient;
use common\models\PizzaIngridient;
use Yii;
use common\models\Pizza;
use app\models\PizzaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * PizzaController implements the CRUD actions for Pizza model.
 */
class PizzaController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * Lists all Pizza models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PizzaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pizza model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Pizza model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // экземпляр пиццы
        $model = new Pizza();
        $ingridients = new PizzaIngridient();
        // экземпляр ингридиентов, которые будут в пицце
        $items = ArrayHelper::map(Ingridient::find()->all(),'id_ingridient','name');
       
        // загружаем и проверяем на валидность данные модели
        if ($model->load(Yii::$app->request->post()))
        {
            $model->save();
            // рецептуру пиццы добавляем в связную БД
            $ingridients->saveIngridients($model->id_pizza);
            return $this->redirect(['view', 'id' => $model->id_pizza]);
        }

        return $this->render('create', [
            'model' => $model, 'ingridients' => $ingridients,
            'items' => $items,
        ]);
    }

    public function actionUpdate($id)
    {
        $ingridients = new PizzaIngridient();
        $items = ArrayHelper::map(Ingridient::find()->all(),'id_ingridient','name');
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pizza]);
        }

        return $this->render('update', [
            'model' => $model, 'ingridients' => $ingridients, 'items' => $items,
        ]);
    }

    public function actionDelete($id)
    {
        $ingridients = new PizzaIngridient();
        $id_pizza = $this->findModel($id);
        // удаляем ингредиенты из связной таблицы
        $ingridients->deleteAll(['pizza_id' => $id_pizza['id_pizza']]);
        // удаляем пиццу из таблицы пицц
        $id_pizza->delete();
        return $this->redirect(['index']); 
    }

    protected function findModel($id)
    {
        if (($model = Pizza::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
