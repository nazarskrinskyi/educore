<?php

namespace App\Providers;

use App\Models\User;
use App\Repositories\Course\CourseRepository;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\CourseReview\CourseReviewRepository;
use App\Repositories\CourseReview\CourseReviewRepositoryInterface;
use App\Repositories\LessonComment\LessonCommentRepository;
use App\Repositories\LessonComment\LessonCommentRepositoryInterface;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Test\TestRepository;
use App\Repositories\Test\TestRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CourseRepositoryInterface::class,
            CourseRepository::class,
        );

        $this->app->bind(
            TestRepositoryInterface::class,
            TestRepository::class,
        );

        $this->app->bind(
            LessonCommentRepositoryInterface::class,
            LessonCommentRepository::class,
        );

        $this->app->bind(
            CourseReviewRepositoryInterface::class,
            CourseReviewRepository::class,
        );

        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        Model::unguard();
        Cashier::useCustomerModel(User::class);
    }
}
