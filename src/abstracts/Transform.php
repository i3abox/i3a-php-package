<?php
/**
 * User: overNic
 * Date: 2016/8/8 0008 17:57
 */
namespace I3A\Base\Abstracts;

use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * 格式化组件
 * @author  OverNick
 * @version  v1.1
 *
 * Class Transform
 * @package App\Lib\Transformer
 */
abstract class Transform
{
    /**
     * @var
     */
    protected $params = [];

    /**
     * @var
     */
    protected $data = [];

    /**
     * 格式化一条数据（一维数据）
     *
     * @param $data
     * @param array $param
     * @return array
     */
    public function item($data, array $param = [])
    {
        $this->setData($data, $param);

        return array_merge($this->params, $this->transform($this->data));
    }

    /**
     * 格式化数据，集合或分页
     *
     * @param $data
     * @param array $param
     * @param string $key
     * @return array
     */
    public function items($data, array $param = [], $key = 'data')
    {
        $this->setData($data, $param);

        $items = array_map([$this,'transform'], $this->data);

        // 如果存在额外参数
        if(count($this->params) > 0){

            $this->params[$key] = $items;

            return $this->params;
        }

        return $items;
    }

    /**
     * 格式化的数据
     * @param $item
     * @return mixed
     */
    protected abstract function transform(array $item);

    /*
    * 设置数据
    *
    * @param array|object|Collection|LengthAwarePaginator $data 原数据
    * @param array $param 附加数据
    */
    protected function setData($data, array $param = [])
    {
        // 如果是一个分页数据
        if(
            ($data instanceof LengthAwarePaginator || $data instanceof Paginator) ||
            (is_array($data) && isset($data['total']) && isset($data['data']) && is_array($data['data']))
        ){
            $paginate = ($data instanceof LengthAwarePaginator || $data instanceof Paginator) ? $data->toArray() : $data;

            $data = array_get($paginate, 'data');

            $param = array_merge($param, collect($paginate)->except([
                'data',
                'first_page_url',
                'last_page_url',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'from'
            ])->toArray());
        }

        // 如果是一个集合
        if($data instanceof Collection){
            $data = $data->toArray();
        }

        // 如果是一个对象
        if(gettype($data) == 'object'){
            $data = collect($data)->toArray();
        }

        $this->params = $param;
        $this->data = $data;
    }
}