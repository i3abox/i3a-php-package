<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/6 0006
 * Time: 下午 2:12
 */
namespace I3A\Base\Package;

use I3A\Base\Traits\ArrayAccessTrait;

/**
 * 包的基本类
 *
 * Class PackageBase
 * @package App\Lib\Package
 */
abstract class PackageBase implements \ArrayAccess
{
    use ArrayAccessTrait;

    /**
     * 定义引用的数组
     *
     * @var string
     */
    protected $AccessVar = 'config';

    /**
     * @var PackageManage
     */
    protected $manage;

    /**
     * @var array
     */
    protected $config;

    public function __construct(array $config = [], PackageManage $manage = null)
    {
        $this->config = $config;
        $this->manage = $manage;
    }
}