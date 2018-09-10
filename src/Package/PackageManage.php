<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/6 0006
 * Time: 下午 2:42
 */
namespace I3A\Base\Package;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * 基础包
 */
abstract class PackageManage
{
    /**
     * @var array
     */
    protected $instance = [];

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var array
     */
    protected $alias = [];

    /**
     * @param $name
     * @return mixed|null
     */
    protected function get($name)
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }

        return null;
    }

    /**
     * @param $name
     * @param $val
     */
    protected function set($name, $val)
    {
        if (array_key_exists($name, $this->attributes)) {
            $this->attributes[$name] = $val;
        }
    }

    /**
     * 实例化类
     *
     * @param $name
     * @return mixed|object
     * @throws \Exception
     */
    protected function make($name)
    {
        $name = str_replace('_','.', Str::snake($name));

        if (!Arr::has($this->alias, $name)) {
            throw new InvalidArgumentException("class {$name} is not defined!");
        }

        $class = Arr::get($this->alias, $name);

        if (!class_exists($class)) {
            throw new InvalidArgumentException("class {$name} is not found!");
        }

        if(array_key_exists($class, $this->instance)){
            return $this->instance[$class];
        }

        $this->instance[$class] = new $class($this->attributes, $this);

        return $this->instance[$class];
    }

    /**
     * @param $name
     * @return mixed|object
     * @throws \Exception
     */
    public function __get($name)
    {
        return $this->make($name);
    }

    /**
     * @param $name
     * @param $classes
     */
    public function extend($name, $classes)
    {
        $this->alias[$name] = $classes;
    }

    /**
     * @param $name
     * @param $args
     * @return $this|mixed|null
     */
    public function __call($name, $args)
    {
        $prefix = substr($name, 0, 3);
        $suffix = substr($name, 3);

        if ($prefix == 'set') {
            $this->set(Str::snake($suffix), Arr::get($args, '0', true));
            return $this;
        }

        if ($prefix == 'get') {
            return $this->get(Str::snake($suffix));
        }

        throw new InvalidArgumentException("method " . $name . "not found!");
    }
}