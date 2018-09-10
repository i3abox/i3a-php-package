<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/9/10
 * Time: 11:10
 */

namespace I3A\Base\Middleware;

/**
 * 路由debug参数调试
 *
 * Class RouteDebug
 * @package I3A\Base\Middleware
 */
class RouteDebug
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if($request->input('debug') === 'true'){
            config(['app.debug' => true]);
            // 开启事务
            \DB::beginTransaction();
        }

        return $next($request);
    }

    // 收尾工作
    public function terminate($request, $response)
    {
        // 所有开启debug之后，数据回滚
        if($request->input('debug') === 'true'){
            \DB::rollBack();
        }
    }
}