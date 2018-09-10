<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/3/23
 * Time: 15:09
 */
namespace I3A\Base\Abstracts;

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
    protected $errmsg = 'ok';

    /**
     * 获取错误信息
     *
     * @return mixed
     */
    public function msg()
    {
        return $this->errmsg;
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
        return $this->errcode;
    }

    /**
     * 设置错误码
     *
     * @param string $code
     * @return $this\
     */
    protected function setCode($code = 'ok')
    {
        $this->errcode = $code;
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