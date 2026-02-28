<?php

namespace App\Models;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * @method static where(string $string, mixed $id)
 * @method static find(int $id)
 * @method static findOrFail(int $id)
 */
class Certificate extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'course_id', 'certificate_path', 'certificate_number', 'issued_at'];

    protected array $dates = ['issued_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Generate a unique certificate number
     */
    private static function generateCertificateNumber(User $user, Course $course): string
    {
        $prefix = 'EC';
        $year = date('Y');
        $userId = str_pad((string)$user->id, 6, '0', STR_PAD_LEFT);
        $courseId = str_pad((string)$course->id, 4, '0', STR_PAD_LEFT);
        $timestamp = substr((string)time(), -4);

        return "{$prefix}-{$year}-{$userId}-{$courseId}-{$timestamp}";
    }

    /**
     * Calculate course duration in hours (if lessons have duration)
     */
    private static function calculateCourseDuration(Course $course): ?string
    {
        $lessons = $course->lessons;
        if ($lessons->isEmpty()) {
            return null;
        }

        // If lessons have duration field, sum them up
        $totalMinutes = $lessons->sum('duration') ?? 0;

        if ($totalMinutes > 0) {
            $hours = floor($totalMinutes / 60);
            $minutes = $totalMinutes % 60;

            if ($hours > 0 && $minutes > 0) {
                return "{$hours} год {$minutes} хв";
            } elseif ($hours > 0) {
                return "{$hours} год";
            } else {
                return "{$minutes} хв";
            }
        }

        // Fallback: count lessons
        $lessonCount = $lessons->count();
        return "{$lessonCount} уроків";
    }

    /**
     * Get course instructor name
     */
    private static function getCourseInstructor(Course $course): string
    {
        // If course has instructor relationship
        if (isset($course->instructor) && $course->instructor) {
            return $course->instructor->name;
        }

        // If course has instructor_id, load the user
        if (isset($course->instructor_id)) {
            $instructor = User::find($course->instructor_id);
            if ($instructor) {
                return $instructor->name;
            }
        }

        return 'EduCore Instructor';
    }

    public static function generate(User $user, Course $course): self
    {
        // Generate unique certificate number
        $certificateNumber = self::generateCertificateNumber($user, $course);

        $certificate = new self([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'certificate_number' => $certificateNumber,
            'issued_at' => now(),
        ]);

        // Prepare data for certificate template
        $duration = self::calculateCourseDuration($course);
        $instructor = self::getCourseInstructor($course);

        // Generate high-quality PDF with all information
        $pdf = Pdf::loadView('certificates.template', [
            'user' => $user,
            'course' => $course,
            'date' => now()->format('d.m.Y'),
            'certificateNumber' => $certificateNumber,
            'duration' => $duration,
            'instructor' => $instructor,
        ])
        ->setPaper('a4', 'landscape')
        ->setOption('dpi', 300)
        ->setOption('defaultFont', 'DejaVu Sans')
        ->setOption('isPhpEnabled', true)
        ->setOption('isRemoteEnabled', false)
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isFontSubsettingEnabled', true)
        ->setOption('debugPng', false)
        ->setOption('debugKeepTemp', false)
        ->setOption('debugCss', false)
        ->setOption('debugLayout', false)
        ->setOption('debugLayoutLines', false)
        ->setOption('debugLayoutBlocks', false)
        ->setOption('debugLayoutInline', false)
        ->setOption('debugLayoutPaddingBox', false);

        $filename = 'certificates/'.$user->id.'_'.$course->id.'_'.time().'.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        $certificate->certificate_path = $filename;
        $certificate->save();

        return $certificate;
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->certificate_path);
    }
}
