<?php

namespace common\models;

use frontend\models\CreatePizzaForm;
use frontend\models\OrderForm;
use Yii;
use yii\web\Response;

class ServicePizza
{
    const PHONENUMBER_ERROR = 'Номер должен состоять из цифр, не менее 8-ми!';
    const BASE_ERROR = 'Основание должно быть целочисленным, не меньше 10см!';
    const INGRIDIENT_ERROR = 'Ингредиент не найден в БД!';
    const PIZZA_ERROR = 'Была выбрана несуществующая пицца!';
    const PORTION_ERROR = 'Порции должны быть целочисленными и быть больше нуля!';

    private $pirep;
    public function __construct(PizzaRepository $PizzaRepository)
    {
        $this->pirep = $PizzaRepository;
    }

    // ------------------------ Администратор  ------------------------ //

    // создание пиццы
    public function create($POST, &$model, &$ingridients)
    {
        if (($model->load($POST) && $ingridients->load($POST) && ($model->validate())))
        {
            foreach ($ingridients['ingridient_id'] as $item)
            {
                $temp = Ingridient::findOne($item['ingridient_id']);
                // Результат записываем в стоимость пиццы
                $model->price += $temp['price']/100*$item['portions'];
            }

            $model->price = round($model->price);
            $model->save();

            foreach ($ingridients['ingridient_id'] as $ingridient)
            {
                // Экземпляр пиццы
                $model2 = new PizzaIngridient();
                // даём номер пиццы
                $model2->pizza_id = $model->id_pizza;
                // даём порцию и номер ингредиента
                $model2->portions = $ingridient['portions'];
                $model2->ingridient_id = $ingridient['ingridient_id'];
                $model2->save();
            }
            return true;
        }
        else
            return false;
    }

    // удаление пиццы
    public function delete($id)
    {
        $ingridients = new PizzaIngridient();
        $model = Pizza::findOne($id);
        // удаляем ингредиенты из связной таблицы
        $ingridients->deleteAll(['pizza_id' => $model['id_pizza']]);
        // удаляем пиццу из таблицы пицц
        $model->delete();
    }

    // обновление пиццы
    public function update($POST,$id, &$model)
    {
        $model = Pizza::findOne($id);
        if ($model->load($POST) && $model->save())
            return true;
        else
            return false;
    }

    // ------------------------ Пользователь ------------------------ //

    // заказ обычной пиццы
    public function Order_Pizza($POST, OrderForm &$model)
    {
        if ($model->load($POST) && $model->validate()) {
            foreach ($model['id_pizza'] as $item) {
                $order = new Order();
                $order->phonenumber = $model->phonenumber;
                $order->id_pizza = $item;
                $pizza = Pizza::findOne(['id_pizza' => $item]);
                $order->payment = $pizza['price'];
                $order->status = 0;
                $order->save();
            }
            Yii::$app->session->setFlash('success', 'Ваш заказ успешно отправлен в обработку! Наш сотрудник свяжется с вами в скором времени!');
            return true;
        }
        else
            return false;
    }

    // заказ обычной пиццы (AJAX)
    public function Order_AjaxPizza($pizza_list, $phonenumber)
    {
        // проход по всем позициям выбора пользователя
            foreach ($pizza_list as $item)
            {
                $order = new Order();
                // находим id пиццы
                $id_pizza = $this->pirep->getPizzaById($item);
                // записываем данные в заказ (телефон, id пиццы, стоимость)
                $order->phonenumber = $phonenumber;
                $order->id_pizza = $id_pizza['id_pizza'];
                $order->payment = $id_pizza['price'];
                $order->status = 0;
                // сохраняем модель
                $order->save();
            }
            return true;
    }

    // Кастомная пицца
    public function Order_CustomPizza($POST, CreatePizzaForm &$model)
    {
        if ($model->load($POST) && $model->validate())
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
                $order->phonenumber = $model->phonenumber;
                $custom_pizza['base'] = $model->base;
                // перечень ингредиентов
                foreach ($model['id_ingridient'] as $ingridient)
                {
                    $Ingr_Rep = new IngridientRepository();
                    // ищем по номеру имя ингредиента и его стоимость
                    $name_ingridient = $Ingr_Rep->getIngridientName($ingridient);
                    // Добавляем порции и название ингредиентов
                    array_push($custom_pizza['portion'], $ingridient['portions']);
                    array_push($custom_pizza['ingridient_name'], $name_ingridient['name']);
                    // считаем стоимость заказа
                    $order->payment += ($name_ingridient['price'] / 100) * $ingridient['portions'];
                }
                $order->payment = round($order->payment);
                // зашифровать в JSON формат и сохранить в поле заказа
                $order->custom_pizza = json_encode($custom_pizza);
                $order->save();
                Yii::$app->session->setFlash('success', 'Ваш особый заказ принят! Наш сотрудник свяжется с вами в скором времени!');
            return true;
        }
        else
            return false;
    }

    // Кастомная пицца (AJAX)
    public function Order_AjaxCustomPizza($data)
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
        $order->phonenumber = $data['phonenumber'];
        $custom_pizza['base'] = $data['base'];
        // перечень ингредиентов
        for ($i = 0; $i < count($data['portion']); $i++)
        {
            $Repo_ingr = new IngridientRepository();
            // ищем по имени ингредиента его стоимость
            $ingridient = $Repo_ingr->getIngridientPriceName($data['ingridient'][$i]);
            // Добавляем порции и название ингредиентов
            array_push($custom_pizza['portion'], $data['portion'][$i]);
            array_push($custom_pizza['ingridient_name'], $ingridient['name']);
            // считаем стоимость заказа
            $order->payment += ($ingridient['price'] / 100) * $data['portion'][$i];
        }
        $order->payment = round($order->payment);
        // зашифровать в JSON формат и сохранить в поле заказа
        $order->custom_pizza = json_encode($custom_pizza);
        $order->status = 0;
        $order->save();
        return true;
    }

    // ------------------------ Валидация  ------------------------ //

    // валидация данных с AJAX конструктора пицц
    public function validate_ajax($data)
    {
        // проверка номера телефона
        // если состоит только из цифр и длинной > 8
        if((!ctype_digit($data['phonenumber'])) && (strlen((string)$data['phonenumber'] < 8 )))
            $status['phonenumber'] = self::PHONENUMBER_ERROR;
        // проверка основания
        // если основание - число и значение >= 10 см
        if( (!ctype_digit($data['base'])) && ($data['base'] < 10))
            $status['base'] = self::BASE_ERROR;
        // проверка ингредиентов и их порций
        // если кол-во полей равное друг другу
        if(count($data['ingridient']) == count($data['portion']))
        {
            // проходим по всем полям и проверяем их на валидность
            // (существование ингредиента по названию, корректность поля с порциями для него)
            // при хотя бы одном несовпадении - выход из цикла
            for($i = 0; $i < count($data['ingridient']); $i++)
            {
                // смотрим имя
                // если ингредиента не существует
                if(!IngridientRepository::isIngridientExist($data['ingridient'][$i]))
                    $status['ingridient'] = self::INGRIDIENT_ERROR;
                // проверяем правильность порций
                if((!ctype_digit($data['portion'][$i])) || ($data['portion'][$i] <= 0))
                    $status['portion'] = self::PORTION_ERROR;
                // проверка наличия ошибок
                if((isset($status['ingridient'])) || (isset($status['portion'] )))
                    break;
            } // конец цикла
        }

        // Успех -  передать выполнение в функцию для записи в БД
        // Провал - направить JSON ответ с указаниями ошибок
        if(isset($status))
            return json_encode($status);
        else
            return $this->Order_AjaxCustomPizza($data);
    }

    // валидация данных AJAX готовых пицц
    public function validate_order($data)
    {
        $pizza_list = [];
        $status = NULL;
        // проверяем номер телефона
        // состоит из цифр и >=8
        if((!ctype_digit($data['phonenumber'])) || (strlen($data['phonenumber']) < 8 ))
            $status['phonenumber'] = self::PHONENUMBER_ERROR;
        // проверка всех пицц
        // существуют ли данные пиццы в БД
        // при хотя бы одном несовпадении - ошибка
        foreach ($data['pizza'] as $item)
        {
            if(!$this->pirep->isPizzaExist($item))
            {
                $status['pizza'] = self::PIZZA_ERROR;
                break;
            }
            else
                array_push($pizza_list, $item);
        }
        // если есть ошибки - отправить обратно
        if(!isset($status))
            return $this->Order_AjaxPizza($pizza_list, $data['phonenumber']);
        else
            return json_encode($status);
    }
    
    
}
