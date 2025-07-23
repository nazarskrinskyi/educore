<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;

class ContactMessageController extends Controller
{
    public function __invoke(ContactMessageRequest $request): JsonResponse
    {
        ContactMessage::create($request->validated());

        return response()->json(['message' => 'Thank you for contacting us!']);
    }
}
