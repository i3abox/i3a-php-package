<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/9/10
 * Time: 11:55
 */

namespace I3A\Base\ApiCode;

/**
 * 错误码基类
 *
 * Class CodeLibraryAbstract
 * @package App\Http\Transforms
 */
abstract class CodeLibraryAbstract
{
    /**
     * @var string 名称
     */
    public $moduleName = '';

    /**
     * @var string 模块编号前缀
     */
    public $moduleCodePrefix = '';

    /**
     * @var array 错误码
     */
    public $codes = [];
}