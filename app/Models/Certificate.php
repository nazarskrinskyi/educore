<?php

namespace App\Models;

use App\Jobs\SendCertificateNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * @method static where(string $string, mixed $id)
 * @method static find(int $id)
 * @method static findOrFail(int $id)
 */
class Certificate extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'course_id', 'certificate_path', 'issued_at'];

    protected array $dates = ['issued_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public static function generate(User $user, Course $course): self
    {
        $certificate = new self([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'issued_at' => now(),
        ]);

        $pdf = Pdf::loadView('certificates.template', [
            'user' => $user,
            'course' => $course,
            'date' => now()->format('d.m.Y'),
        ]);

        $filename = 'certificates/' . $user->id . '_' . $course->id . '_' . time() . '.pdf';
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
