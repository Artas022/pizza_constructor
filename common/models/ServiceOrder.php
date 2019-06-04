<?php
/**
 * Created by PhpStorm.
 * User: danil
 * Date: 04.06.19
 * Time: 16:04
 */

namespace common\models;


class ServiceOrder
{
    private $repo;

    public function __construct(OrderRepository $OrderRepository)
    {
        $this->repo = $OrderRepository;
    }

    public static function ShowRecept($ingridients)
    {
        $recept = [
            'title' => Null,
            'ingridient' => [],
        ];
        if($ingridients)
        {
            $recept['title'] = '<p class="lead">' . 'Рецептура заказной пиццы c основанием ' . $ingridients['base'] . ' см:' . '</p>';
            for($i = 0; $i < count($ingridients['ingridient_name']); $i++)
            {
                $html = '<strong>' . 'Ингредиент: ' . $ingridients['ingridient_name'][$i] . ', порция: ' . $ingridients['portion'][$i] . '</strong>' .'<br>';
                $recept['ingridient'][$i] = $html;
            }
        }
        return $recept;
    }
}