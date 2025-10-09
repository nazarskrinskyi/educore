<?php

use App\Jobs\SendNewCoursesNotification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('reminders:telegram')
    ->daily()
    ->timezone('Europe/Kiev')
    ->evenInMaintenanceMode()
    ->withoutOverlapping();

Schedule::job(new SendNewCoursesNotification())->everyMinute();

Schedule::command('certificates:generate')->everyMinute();
