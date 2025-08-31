<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\Webhook;
use Stripe\PaymentIntent;

class StripeWebhookController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret    = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            /** @var PaymentIntent $paymentIntent */
            $paymentIntent = $event->data->object;

            $order = Order::where('stripe_payment_id', $paymentIntent->id)->first();
            if ($order) {
                $order->update(['status' => 'paid']);

                foreach ($order->items as $item) {
                    $order->user->courses()->attach($item->course_id);
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
