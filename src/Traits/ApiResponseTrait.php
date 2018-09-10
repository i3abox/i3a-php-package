<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2017/7/26
 * Time: 18:00
 */

namespace I3A\Base\Traits;

use I3A\Base\Abstracts\ApiCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

/**
 * Api接口返回
 *
 * Trait ApiResponseTrait
 * @package App\Http\Traits\Api
 */
trait ApiResponseTrait
{
    /**
     * 错误的返回
     *
     * @param string $code  错误码
     * @param null $module  错误码组
     * @param array $headers 附加头信息
     * @param null $debug debug信息
     * @return mixed
     */
    protected function responseError($code, $module = null, array $headers = [], $debug = null)
    {
        $data = [
            'errcode' => app(ApiCode::class)->getCode($code, $module),
            'errmsg' => app(ApiCode::class)->getMsg($code, $module)
        ];

        // debug信息
        if(config('app.debug', false) && !is_null($debug)){
            $data['debug'] = $debug;
        }

        return $this->response($data, $headers);
    }

    /**
     * 成功返回
     *
     * @param array $data
     * @param array $headers
     * @return mixed
     * @throws \Exception
     */
    protected function responseSuccess($data = [],array $headers = [])
    {
        return $this->response([
            'errcode' => 0,
            'data' => $data
        ], $headers);
    }

    /**
     * 返回数据
     *
     * @param array $data
     * @param array $headers
     * @return mixed
     * @throws \Exception
     */
    private function response($data = [], $headers = [])
    {
        if(
            !is_array($data) &&
            !$data instanceof Collection &&
            !$data instanceof LengthAwarePaginator &&
            !$data instanceof Paginator
        ){
            throw new \Exception('response data is not object');
        }

        return JsonResponse::create($data, 200, $headers);
    }
}