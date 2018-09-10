<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/9/10
 * Time: 14:54
 */
namespace I3A\Base\Sign;

use I3A\Base\Exceptions\BootstrapException;

/**
 * 项目内的闭环
 *
 * Trait KernelBootstrapTrait
 * @package I3A\Base\Auth
 */
trait KernelBootstrapTrait
{
    /**
     * @throws BootstrapException
     */
    public function bootstrap()
    {
        parent::bootstrap();

        if ($this->app->bootstrapStatus === false) throw new BootstrapException();
    }

}