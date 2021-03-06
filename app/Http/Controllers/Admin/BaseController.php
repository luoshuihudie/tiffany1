<?php
/**
 * 后台基础控制器
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Controllers\Admin;

use App\Facades\AuthFacade;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\Contracts\AdminMenuInterface;
use App\Traits\Admin\AdminTree;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Config;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests , AdminTree;

    /**
     * 构造函数
     *
     * BaseController constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        //登录用户信息
        $loginUser   = session(LOGIN_USER);
        //基础变量
        $baseVar     = $this->baseVar($loginUser);
        //当前url
        $url         = request()->route()->getName();

        //使用app()->make 实例化注册类
        $menu = app()->make(AdminMenuInterface::class)->findByRouteName($url);
        $menu && $baseVar['admin']['title'] = $menu->name;
        AuthFacade::adminLog($url,$loginUser,$menu);

        if ('admin.auth.login' !== $url
            && !request()->pjax()
            && session()->has(LOGIN_USER))
        {
            $baseVar['admin']['menu'] = $this->getLeftMenu($url,$loginUser);
        }
        
        //全局通用变量
        view()->share('admin',$baseVar['admin']);
        view()->share('debug',$baseVar['debug']);
        view()->share('cookiePrefix',$baseVar['cookie_prefix']);
    }

    /**
     * 基础变量
     *
     * @param $loginUser
     * @return array
     * Author: Stephen
     * Date: 2020/7/24 16:03:52
     */
    public function baseVar($loginUser) :array
    {
        $admin_config = config('admin.admin.base');
        if (!$admin_config) {
            $admin_config = config('Admin.admin.base');
        }
        $perPage      = request()->cookie('admin_per_page') ?? 10;
        $perPage      = $perPage < 100 ? $perPage : 100;

        return [
            'debug'               => env('APP_DEBUG') ? 'true' : 'false',
            'cookie_prefix'       => '',
            'admin'               => [
                'pjax'            => request()->pjax(),
                'user'            => $loginUser,
                'menu'            => 1,
                'name'            => $admin_config['name'] ?? '',
                'author'          => $admin_config['author'] ?? '',
                'version'         => $admin_config['version'] ?? '',
                'short_name'      => $admin_config['short_name'] ?? '',
                'per_page'        => $perPage,
                'per_page_config' => [10,20,30,50,100]
            ]
        ];

    }

    /**
     * ajax请求成功返回
     *
     * @param array $data //响应数据
     * @param int $code   //响应状态码
     * @param string $msg //响应信息
     * @return array
     */
    public function ajaxSuccess($data = [], $code = 0, $msg = 'Success')
    {
        return [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
    }

    /**
     * ajax请求失败返回
     *
     * @param $code
     * @param string $msg
     * @param array $data
     * @return array
     */
    public function ajaxError($code, $msg = 'Error', $data = [])
    {
        return [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
    }

    public function lists()
    {
        return $this->ajaxSuccess(Config::get('config.base'));
    }
}
