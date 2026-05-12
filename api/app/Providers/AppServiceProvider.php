<?php

namespace App\Providers;

use App\Modules\User\Profile\Domain\Repositories\UserProfileRepositoryInterface;
use App\Modules\User\Profile\Infrastructure\Repositories\EloquentUserProfileRepository;
use App\Modules\Product\Domain\Repositories\ProductRepositoryInterface;
use App\Modules\Product\Infrastructure\Repositories\EloquentProductRepository;
use App\Modules\Order\Domain\Repositories\OrderRepositoryInterface;
use App\Modules\Order\Infrastructure\Repositories\EloquentOrderRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserProfileRepositoryInterface::class,
            EloquentUserProfileRepository::class,
        );

        $this->app->bind(
            ProductRepositoryInterface::class,
            EloquentProductRepository::class,
        );

        $this->app->bind(
            OrderRepositoryInterface::class,
            EloquentOrderRepository::class,
        );
    }
    public function boot(): void
    {
        //
    }
}
