<?php

namespace App\Providers;

use App\Repositories\Admin\Contracts\AboutInterface;
use App\Repositories\Admin\Contracts\AdminLogInterface;
use App\Repositories\Admin\Contracts\AdminMenuInterface;
use App\Repositories\Admin\Contracts\AdminRoleInterface;
use App\Repositories\Admin\Contracts\AdminUserInterface;
use App\Repositories\Admin\Contracts\AttachmentInterface;
use App\Repositories\Admin\Contracts\AuthInterface;
use App\Repositories\Admin\Contracts\BannerInterface;
use App\Repositories\Admin\Contracts\LinksInterface;
use App\Repositories\Admin\Contracts\MenuInterface;
use App\Repositories\Admin\Contracts\SettingGroupInterface;
use App\Repositories\Admin\Contracts\SettingInterface;
use App\Repositories\Admin\Contracts\UserInterface;
use App\Repositories\Admin\Contracts\UserLevelInterface;
use App\Repositories\Admin\Eloquent\AboutRepository;
use App\Repositories\Admin\Eloquent\AdminLogRepository;
use App\Repositories\Admin\Eloquent\AdminMenuRepository;
use App\Repositories\Admin\Eloquent\AdminRoleRepository;
use App\Repositories\Admin\Eloquent\AdminUserRepository;
use App\Repositories\Admin\Eloquent\AttachmentRepository;
use App\Repositories\Admin\Eloquent\AuthRepository;
use App\Repositories\Admin\Eloquent\BannerRepository;
use App\Repositories\Admin\Eloquent\LinksRepository;
use App\Repositories\Admin\Eloquent\MenuRepository;
use App\Repositories\Admin\Eloquent\SettingGroupRepository;
use App\Repositories\Admin\Eloquent\SettingRepository;
use App\Repositories\Admin\Eloquent\UserLevelRepository;
use App\Repositories\Admin\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class AdminRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(AuthInterface::class,AuthRepository::class);
        $this->app->singleton(AdminMenuInterface::class,AdminMenuRepository::class);
        $this->app->singleton(AdminUserInterface::class,AdminUserRepository::class);
        $this->app->singleton(AdminRoleInterface::class,AdminRoleRepository::class);
        $this->app->singleton(AdminLogInterface::class,AdminLogRepository::class);
        $this->app->singleton(UserInterface::class,UserRepository::class);
        $this->app->singleton(UserLevelInterface::class,UserLevelRepository::class);
        $this->app->singleton(SettingInterface::class,SettingRepository::class);
        $this->app->singleton(SettingGroupInterface::class,SettingGroupRepository::class);
        $this->app->singleton(LinksInterface::class,LinksRepository::class);
        $this->app->singleton(BannerInterface::class,BannerRepository::class);
        $this->app->singleton(MenuInterface::class,MenuRepository::class);
        $this->app->singleton(AttachmentInterface::class,AttachmentRepository::class);
        $this->app->singleton(AboutInterface::class,AboutRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.debug', false)) {
            \DB::listen(function ($query) {
                $sql = $query->sql;
                foreach ($query->bindings as $i => $item) {
                    $sql = preg_replace('/\?/', "'$item'", $sql, 1);
                }
                logger("$sql [$query->time]");
            });
        }
    }
}
