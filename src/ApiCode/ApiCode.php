<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/9/10
 * Time: 11:20
 */

namespace I3A\Base\ApiCode;

/**
 * 错误码
 *
 * Class ApiCode
 * @package App\Http\Transforms
 */
abstract class ApiCode
{
    /**
     * @var array
     */
    protected $bootstrapWarp = [];

    /**
     * @var string
     */
    protected $default = "default";

    /**
     * 模块组
     *
     * @var array
     */
    protected $modules = [];

    /**
     * 模块与编号前缀组
     *
     * @var array
     */
    protected $library = [];

    /**
     * 获取错误信息
     *
     * @param $code
     * @param string $module
     * @param mixed $default
     * @return mixed
     */
    public function getMsg($code, $module = null, $default = null)
    {
        return array_get($this->modules, array_get($this->library, $module ?? $this->default).'.'.$code, $default);
    }

    /**
     * 获取错误码
     *
     * @param $code
     * @param string $module
     * @return string
     */
    public function getCode($code, $module = null)
    {
        return array_get($this->library, $module ?? $this->default, '').$code;
    }

    /**
     * 初始化操作
     */
    public function bootstrap()
    {
        foreach ($this->bootstrapWarp as $class){
            $this->extend(new $class());
        }
    }

    /**
     * 扩展错误码
     *
     * @param CodeLibraryAbstract $codeLibrary
     */
    public function extend(CodeLibraryAbstract $codeLibrary)
    {
       $this->library[$codeLibrary->moduleName] = $codeLibrary->moduleCodePrefix;
       $this->modules[$codeLibrary->moduleCodePrefix] = $codeLibrary->codes;
    }
}