<?php
/**
 * Created by PhpStorm.
 * User: danil
 * Date: 06.06.19
 * Time: 15:22
 */

namespace common\models;


class ServiceIngridient
{
    private $Repo;

    public function __construct(IngridientRepository $ingridientRepository)
    {
        $this->Repo = $ingridientRepository;
    }
    // фильтрация для Select2 при поиске ингредиента
    public function FilterIngridients($data)
    {
        // если прислали запрос
        if(isset($data['status']))
        {
            if($this->Repo->getFilterIngridients($data['search']))
                return json_encode($this->Repo->getFilterIngridients($data['search']), JSON_UNESCAPED_UNICODE);
            else
                return false;
        }
        else
            return json_encode($this->Repo->getMapIngridients(), JSON_UNESCAPED_UNICODE);
    }


}