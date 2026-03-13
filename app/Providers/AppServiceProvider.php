<?php

namespace App\Providers;

use App\Models\Inquiry;
use App\Policies\InquiryPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Inquiry::class => InquiryPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
