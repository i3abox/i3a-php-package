<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/5/28
 * Time: 17:13
 */

namespace I3A\Base\Traits;

/**
 * 实现数组和对象的访问
 *
 * Trait ArrayAccessTrait
 * @package App\Http\Traits
 */
trait ArrayAccessTrait
{
    public function __get($name)
    {
       return $this->offsetGet($name);
    }

    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }

    /**
     * @param $offset
     * @return null
     */
    public function offsetGet($offset)
    {
        $key = $this->AccessVar;

        return $this->offsetExists($offset) ? $this->$key[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        $key = $this->AccessVar;

        return $this->$key[$offset] = $value;
    }

    /**
     * @param $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        $key = $this->AccessVar;

        return array_key_exists($offset, $this->$key);
    }

    /**
     * @param $offset
     */
    public function offsetUnset($offset)
    {
        $key = $this->AccessVar;

        unset($this->$key[$offset]);
    }
}