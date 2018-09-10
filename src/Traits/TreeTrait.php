<?php
namespace I3A\Base\Traits;

use Closure;
use OverNick\Support\Arr;
use OverNick\Support\Collection;

/**
 * 树形菜单类
 *
 * Class TreeTrait
 * @package App\Http\Traits
 */
trait TreeTrait
{

    /**
     *
     * @return array
     */

    /**
     * getSubTree
     * @param $config
     * @return array
     * @throws \Exception
     */
    protected function getSubTree($config)
    {
        /*
         * @param data               数据
         * @param callback            返回值处理函数
         * @param id                 最上级id
         * @param id_key             键值名称
         * @param parent_key         上级键值名称
         * @param children_key       返回的子集名称
         * @param recursive          是否需要递归累加指定值，需要则传入键名
         * @param recursive_key      递归累加值的名称
         * @param recursive_arr      递归累加的值
         */
        if(!array_key_exists('data',$config)){
            throw new \InvalidArgumentException('tree 组件传值不正确');
        }

        $id = Arr::get($config,'id',0);
        $id_key = Arr::get($config,'id_key','id');
        $parent_id = Arr::get($config,'parent_key','parent_id');
        $recursive = Arr::get($config,'recursive');
        $recursive_key = Arr::get($config,'recursive_key','recursive');
        $children_key = Arr::get($config,'children_key','children');
        $data = Arr::get($config,'data');

        if(!is_array($data) && !is_object($data) && !$data instanceof Collection){
            throw new \InvalidArgumentException('data 不是一个有效的参数，参考类型:array,object,collection instance');
        }

        $items = [];

        foreach ($data as $key => $item){

            if(Arr::get($item, $parent_id) == $id){

                unset($config['data'][$key]);

                // 如果需要递归累加某项值
                if($recursive){
                    array_push($config['recursive_arr'], Arr::get($item,$recursive));
                    $item[$recursive_key] = $config['recursive_arr'];
                }

                // 父级id
                $config['id'] = Arr::get($item, $id_key);

                $item[$children_key] = $this->getSubTree($config);

                if(empty($item[$children_key])) unset($item[$children_key]);

                array_push($items, $item);
            }
        }

        // 如果存在处理方法
        if(array_key_exists('callback',$config) &&
            $config['callback'] instanceof Closure){
            $items = array_map($config['callback'], $items);
        }

        return $items;
    }
}