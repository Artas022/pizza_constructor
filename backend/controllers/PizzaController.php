<?php

namespace backend\controllers;

use app\models\IngridientSearch;
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


    public function actionIndex()
    {
        $searchModel = new PizzaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->query->where('is_custom = 0');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $ingridients = PizzaIngridient::find()->joinWith(['pizza','ingridient'])->asArray()->where(['pizza_id' => $id])->all();
        return $this->render('view', [
            'model'
            => $this->findModel($id),
            'ingridients' => $ingridients,
        ]);
    }

    public function actionCreate()
    {
        $model = new Pizza();
        $ingridients = new PizzaIngridient();
        // загружаем и проверяем на валидность данные модели
        if (($model->load(Yii::$app->request->post()) && $ingridients->load(Yii::$app->request->post())
            && ($model->validate())
        ))
        {
            $model->setPrice($ingridients);
            $ingridients->saveIngridients($model->id_pizza);
            // рецептуру пиццы добавляем в связную БД
            return $this->redirect(['view', 'id' => $model->id_pizza]);
        }

        return $this->render('create', [
            'model' => $model, 
            'ingridients' => $ingridients,
            'items' => ArrayHelper::map(Ingridient::find()->all(),'id_ingridient','name'),
        ]);
    }

    public function actionUpdate($id)
    {
        $ingridients = new PizzaIngridient();
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pizza]);
        }
        return $this->render('update', [
            'model' => $model, 
            'ingridients' => $ingridients, 
            'items' => ArrayHelper::map(Ingridient::find()->all(),'id_ingridient','name'),
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
