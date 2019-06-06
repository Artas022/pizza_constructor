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




}