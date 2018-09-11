<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/3/23
 * Time: 15:09
 */
namespace I3A\Base\Abstracts;

use I3A\Base\ApiCode\ApiCode;

/**
 * Class ServiceAbstract
 * @package App\Http\Abstracts
 */
abstract class ServiceAbstract
{
    /**
     * @var
     */
    protected $errcode = 0;

    /**
     * @var
     */
    protected $errmsg = null;

    /**
     * @var null
     */
    protected $errmodule = null;

    /**
     * 获取错误信息
     *
     * @return mixed
     */
    public function msg()
    {
        return $this->errmsg ?? app(ApiCode::class)->getMsg($this->errcode, $this->errmodule);
    }

    /**
     * 设置错误信息
     *
     * @param $message
     * @return $this
     */
    protected function setMsg($message = 'ok')
    {
        $this->errmsg = $message;
        return $this;
    }

    /**
     * 获取错误码
     *
     * @return mixed
     */
    public function code()
    {
        return app(ApiCode::class)->getCode($this->errcode, $this->errmodule);
    }

    /**
     * 设置错误码
     *
     * @param integer $code
     * @param mixed $module 模块
     * @return $this\
     */
    protected function setCode($code = 0, $module = null)
    {
        $this->errcode = $code;
        $this->errmodule = $module;
        return $this;
    }

    /**
     * 判定操作是否请求成功
     *
     * @return bool
     */
    public function hasSuc()
    {
        return $this->errcode === 0;
    }

}