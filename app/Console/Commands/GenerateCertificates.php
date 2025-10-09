<?php

namespace App\Console\Commands;

use App\Jobs\SendCertificateNotification;
use App\Models\Course;
use App\Models\User;
use App\Services\CourseProgressService;
use Illuminate\Console\Command;

class GenerateCertificates extends Command
{
    protected $signature = 'certificates:generate';
    protected $description = 'Генерує сертифікати для користувачів, які завершили курси';

    public function handle(CourseProgressService $progressService): int
    {
        $this->info('🔔 Початок генерації сертифікатів...');

        $users = User::with('courses')->get();

        foreach ($users as $user) {
            foreach ($user->courses as $course) {
                $certificate = $progressService->completeCourse($user, $course);
                if ($certificate) {
                    $this->info("✅ Сертифікат згенеровано для $user->name [$user->id] ($course->title)");
                    app(SendCertificateNotification::class)->dispatch($certificate);
                }
            }
        }

        $this->info('🎉 Генерація сертифікатів завершена!');
        return 0;
    }
}
