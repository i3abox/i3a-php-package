<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/9/10
 * Time: 14:58
 */
namespace I3A\Base\Sign;

use I3A\Base\Exceptions\BootstrapException;
use Illuminate\Support\ServiceProvider;
use OverNick\SimpleDemo\Client\App;
use OverNick\Support\Arr;

/**
 * Provider 基类
 *
 * Class SimpleClientServiceProviderAbstract
 * @package I3A\Base\Sign
 */
abstract class SimpleClientServiceProviderAbstract extends ServiceProvider
{
    protected $key = 'sdk.i3a.sign';

    /**
     * 注册应用
     */
    public function register()
    {
        $this->app->singleton($this->key, function(){
            $config = $this->getConfig();
            return new App($config);
        });
    }

    /**
     * 启动验证
     *
     * @throws BootstrapException
     */
    public function boot()
    {
        $this->bootValidation();
    }

    /**
     * 启动验证
     *
     * @throws BootstrapException
     */
    public function bootValidation()
    {
        if(!$this->checkProduct()){
            throw new BootstrapException();
        }

        $this->app->bootstrapStatus = true;
    }

    /**
     * @return bool
     */
    protected function checkProduct()
    {
        if(
            defined("INSTALL_INIT") ||
            (!isset($_SERVER['HTTP_HOST']) && !isset($_SERVER['SERVER_NAME']))
        ) return true;

        $cacheKey = $this->app['config']->get('settings.auth.access_id') .
            md5($this->app->make($this->key)->getDomain());

        $data = $this->app['cache']->remember($cacheKey, 10, function(){
            return $this->app[$this->key]->product->check();
        });

        if(!is_array($data) || !$rsp =  $this->app->make($this->key)->getData($data)) return false;

        return Arr::get($rsp, 'verify') == $this->app->productName;
    }

    /**
     * get config
     *
     * @return mixed
     */
    abstract protected function getConfig();

}