<?php
namespace I3A\Base\Sign;

use I3A\Api\Client\App;
use I3A\Base\Exceptions\BootstrapException;
use Illuminate\Support\ServiceProvider;
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
            return new App($this->getConfig());
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
     * @return bool
     * @throws BootstrapException
     */
    protected function bootValidation()
    {
        if(!defined("INSTALL_INIT") && (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['SERVER_NAME']))){
            $cacheKey = Arr::get($this->getConfig(), 'access_id') .
                md5($this->app->make($this->key)->getDomain());

            $data = $this->app['cache']->remember($cacheKey, 10, function(){
                return $this->app[$this->key]->product->check();
            });

            if(!is_array($data) || !$rsp =  $this->app->make($this->key)->getData($data)) {
                throw new BootstrapException();
            }
        }

        return $this->app->bootstrapStatus = true;
    }

    /**
     * get config
     *
     * @return mixed
     */
    abstract protected function getConfig();

}