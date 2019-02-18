<?php
/***
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/3/23
 * Time: 11:12
 */

namespace I3A\Base\Abstracts;

use Illuminate\Database\Eloquent\Model;
use I3A\Base\Interfaces\RepositoryInterface;

/**
 * Repository 基类
 *
 * Class RepositoryInterface
 * @package App\Http\Classes\Abstracts
 */
abstract class RepositoryAbstract implements RepositoryInterface
{
    /**
     * Model 地址
     *
     * @var
     */
    protected $model;

    /**
     * query对象
     *
     * @var
     */
    protected $instance;

    /**
     * @return mixed
     * @throws \Exception
     */

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function getModel()
    {
        if(is_null($this->instance) && is_null($this->model)){
            throw new \Exception('Repository init fail!');
        }

        if(is_null($this->instance)){
            $this->instance = $this->model::query();
        }

        return $this->instance;
    }

    /**
     * @param Model $model
     * @return $this|RepositoryInterface
     */
    public function setModel(Model $model)
    {
        $this->instance = $model;
        return $this;
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     * @throws \Exception
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this->getModel(), $method], $args);
    }
}