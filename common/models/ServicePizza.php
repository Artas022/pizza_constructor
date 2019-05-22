<?php

namespace common\models;

use frontend\models\CreatePizzaForm;
use frontend\models\OrderForm;
use Yii;
use yii\helpers\ArrayHelper;

class ServicePizza
{
    private $pirep;
    
    public $model; // модель 
    public $ingridients; // ингредиенты
    
    public function __construct(PizzaRepository $PizzaRepository)
    {
        $this->pirep = $PizzaRepository;
    }

    public function PizzaIngridients($id)
    {
        return PizzaIngridient::find()->joinWith(['pizza','ingridient'])->asArray()->where(['pizza_id' => $id])->all();
    }
    
    public function AllPizza()
    {
        return $this->pirep->getMapPizza();
    }
    
    public function AllIngridients()
    {
        return $this->pirep->getMapIngridients();
    }
    
    public function PizzaList()
    {
        return $this->pirep->getAllPizza();
    }
    
    public function create($POST)
    {
        $this->model = new Pizza();
        $this->ingridients = new PizzaIngridient();
        // загружаем и проверяем на валидность данные модели
        if (($this->model->load($POST) && $this->ingridients->load($POST) && ($this->model->validate())))
        {

            foreach ($this->ingridients['ingridient_id'] as $item)
            {
                $temp = Ingridient::findOne($item['ingridient_id']);
                // Результат записываем в стоимость пиццы
                $this->model->price += $temp['price']/100*$item['portions'];
            }
            
            $this->model->price = round($this->model->price);
            $this->model->save();
            
            foreach ($this->ingridients['ingridient_id'] as $ingridient)
            {
                // Экземпляр пиццы
                $model = new PizzaIngridient();
                // даём номер пиццы
                $model->pizza_id = $this->model->id_pizza;
                // даём порцию и номер ингредиента
                $model->portions = $ingridient['portions'];
                $model->ingridient_id = $ingridient['ingridient_id'];
                $model->save();
            }
            return true;
        }
    }
    
    public function delete($id)
    {
        $this->ingridients = new PizzaIngridient();
        $this->model = Pizza::findOne($id);
        // удаляем ингредиенты из связной таблицы
        $this->ingridients->deleteAll(['pizza_id' => $this->model['id_pizza']]);
        // удаляем пиццу из таблицы пицц
        $this->model->delete();
    }
    
    public function update($POST,$id)
    {
        $this->ingridients = new PizzaIngridient();
        $this->model = Pizza::findOne($id);
        if ($this->model->load($POST) && $this->model->save())
            return true;
    }
    // заказ обычной пиццы
    public function Order_Pizza($POST)
    {
        $this->model = new OrderForm();
        if ($this->model->load($POST) && $this->model->validate()) {
            foreach ($this->model['id_pizza'] as $item) {
                $order = new Order();
                $order->phonenumber = $this->model->phonenumber;
                $order->id_pizza = $item;
                $pizza = Pizza::findOne(['id_pizza' => $item]);
                $order->payment = $pizza['price'];
                $order->status = 0;
                $order->save();
            }
            Yii::$app->session->setFlash('success', 'Ваш заказ успешно отправлен в обработку! Наш сотрудник свяжется с вами в скором времени!');
            return true;
        }
    }
    // Кастомная пицца
    public function Order_CustomPizza($POST)
    {
        // загрузка моделей и валидация
        $this->model = new CreatePizzaForm();
        $this->model->load($POST);

        if ($this->model->load($POST) && $this->model->validate())
        {
            // ассоциативный массив для записи рецептуры в JSON
                $custom_pizza = [
                    'ingridient_name' => [],
                    'portion' => [],
                    'base' => 0,
                ];
                // модель заказа
                $order = new Order();
                // Добавляем из модели формы информацию:
                // основание, телефон
                $order->phonenumber = $this->model->phonenumber; 
                $custom_pizza['base'] = $this->model->base;
                // перечень ингредиентов

                foreach ($this->model['id_ingridient'] as $ingridient)
                {
                    // ищем по номеру имя ингредиента и его стоимость
                    $name_ingridient = $this->pirep->getIngridientName($ingridient);
                    // Добавляем порции и название ингредиентов
                    array_push($custom_pizza['portion'], $ingridient['portions']);
                    array_push($custom_pizza['ingridient_name'], $name_ingridient['name']);
                    // считаем стоимость заказа
                    $order->payment += ($name_ingridient['price'] / 100) * $ingridient['portions'];
                }
                $this->pirep->getMapIngridients();
                $order->payment = round($order->payment);
                // зашифровать в JSON формат и сохранить в поле заказа
                $order->custom_pizza = json_encode($custom_pizza);
                $order->save();
                Yii::$app->session->setFlash('success', 'Ваш особый заказ принят! Наш сотрудник свяжется с вами в скором времени!');
            return true;
        }
    }
}
