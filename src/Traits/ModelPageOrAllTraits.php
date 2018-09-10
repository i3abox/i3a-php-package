<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/1/24
 * Time: 17:06
 */

namespace I3A\Base\Traits;

/**
 * 模型使用的trait
 *
 * Class ModelTraits
 * @package App\Http\Traits
 */
trait ModelPageOrAllTrait
{
    /**
     * 获取全部数据还是分页数据
     *
     * @param $query
     * @param $num
     * @param array $column
     * @return mixed
     */
    public function scopeGetData($query, $column = ['*'], $num = 15)
    {
        if(app('request')->input('is_all')){
            return $query->get($column);
        }else{
            return $this->scopeGetPage($query, $column, $num);
        }
    }

    /**
     * 获取分页
     *
     * @param $query
     * @param $column
     * @param int $num
     * @return mixed
     */
    public function scopeGetPage($query, $column = ['*'], $num = 15)
    {
        $pageNum = app('request')->input('page_num', $num);
        return $query->paginate($pageNum > 500 ? 500 : $pageNum, $column);
    }

}