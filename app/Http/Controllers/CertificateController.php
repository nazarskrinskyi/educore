<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CertificateController extends Controller
{
    public function show(Request $request, int $id): StreamedResponse
    {
        $certificate = Certificate::findOrFail($id);

        if ($certificate->user_id !== $request->user()->id) {
            abort(403, 'You are not authorized to view this certificate.');
        }

        $relativePath = str_replace('public/', '', $certificate->certificate_path);

        if (!Storage::disk('public')->exists($relativePath)) {
            abort(404, 'Certificate file not found.');
        }

        $stream = Storage::disk('public')->readStream($relativePath);

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $certificate->course->title . '_certificate.pdf"',
        ]);
    }
}
