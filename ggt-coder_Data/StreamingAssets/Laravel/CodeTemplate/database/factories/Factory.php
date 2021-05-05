<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory AS BaseFactory;

abstract class Factory extends BaseFactory
{

    /**
     * @description 在工厂函数中添加 states
     * @param $states
     * @return mixed
     * @author CuratorC
     * @date 2021/2/5
     */
    function addStates($states): Factory
    {
        $factory = $this;
        foreach ($states as $state) {
            $factory = $factory->$state();
        }
        return $factory;
    }

}
