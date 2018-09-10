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
     * 启动自加载
     */
    public function boot()
    {
        $this->bootUpdated();
        $this->bootValidation();
    }

    /**
     * 接收推送
     */
    protected function bootUpdated()
    {
        $this->app->make($this->key)->backend->run();
    }

    /**
     * 启动验证
     */
    public function bootValidation()
    {
        $this->app->make($this->key)->verify(function(App $app){

            if(!$app->hasSuccess($this->getChecked($app))){
                throw new BootstrapException();
            }

            $this->app->bootstrapStatus = true;
        });
    }

    /**
     * get config
     *
     * @return mixed
     */
    abstract protected function getConfig();

    /**
     * get api result
     *
     * @param App $app
     * @return mixed
     */
    abstract protected function getChecked(App $app);

}