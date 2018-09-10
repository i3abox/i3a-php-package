<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/3/23
 * Time: 11:06
 */
namespace I3A\Base\Interfaces;

/**
 * Model 仓库实现类
 *
 * Interface RepostoryInterface
 * @package App\Http\Interfaces
 */
interface RepositoryInterface
{
    /**
     * 获取Model
     *
     * @return mixed
     */
    public function getModel();

    /**
     * @param $instance
     * @return $this
     */
    public function setModel($instance);
}