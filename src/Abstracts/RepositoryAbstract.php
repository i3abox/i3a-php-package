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
    protected static $instance;

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getModel()
    {
        if(is_null(self::$instance) && is_null($this->model)){
            throw new \Exception('Repository init fail!');
        }

        if(is_null(self::$instance)){
            self::$instance = $this->model::query();
        }

        return self::$instance;
    }

    /**
     * @param $model
     * @return $this
     */
    public function setModel(Model $model)
    {
        self::$instance = $model;
        return $this;
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([self::$instance, $method], $args);
    }
}