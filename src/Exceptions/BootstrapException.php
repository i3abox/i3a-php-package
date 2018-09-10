<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/7/30
 * Time: 14:56
 */
namespace I3A\Base\Exceptions;

use Exception;

/**
 * Class BootstrapException
 * @package App\Exceptions
 */
class BootstrapException extends Exception
{
    protected $code = '416';

    protected $message = '';
}