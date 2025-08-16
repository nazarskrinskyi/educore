<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Http\{Request, RedirectResponse};
use Illuminate\Support\Facades\Session;
use Inertia\Response as InertiaResponse;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class CartController extends Controller
{
    private const CART_SESSION_KEY = 'cart';
    private const CURRENCY = 'uah';

    /**
     * Get the current cart from session
     */
    private function getCart(): array
    {
        return Session::get(self::CART_SESSION_KEY, []);
    }

    /**
     * Save cart to session
     */
    private function saveCart(array $cart): void
    {
        Session::put(self::CART_SESSION_KEY, $cart);
    }

    /**
     * Display the shopping cart
     */
    public function index(): InertiaResponse
    {
        return Inertia::render('Cart/Index', [
            'cart' => $this->getCart()
        ]);
    }

    /**
     * Add a course to the cart
     */
    public function add(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        $course = Course::with('instructor', 'reviews')->findOrFail($validated['course_id']);
        $cart = $this->getCart();

        if (isset($cart[$course->id])) {
            return redirect()->back()->with('error', 'Course already in cart');
        }

        $cart[$course->id] = [
            'id'         => $course->id,
            'name'       => $course->title,
            'price'      => $course->price / 100,
            'image'      => Storage::url($course->image_path),
            'instructor' => $course->instructor?->name ?? 'Unknown',
            'rating'     => round($course->reviews()->avg('rating') ?? 0, 1),
            'reviews'    => $course->reviews()->count(),
            'duration'   => $course->duration,
            'level'      => $course->level,
        ];

        $this->saveCart($cart);

        return redirect()->back()->with('success', 'Course added to cart');
    }

    /**
     * Remove a course from the cart
     */
    public function remove(string $id): RedirectResponse
    {
        $cart = $this->getCart();

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $this->saveCart($cart);
            return redirect()->back()->with('success', 'Course removed from cart');
        }

        return redirect()->back()->with('error', 'Course not found in cart');
    }

    /**
     * Show the checkout page with Stripe payment intent
     */
    public function checkout(): InertiaResponse|RedirectResponse
    {
        $cart = $this->getCart();

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }

        $total = $this->calculateTotal($cart);

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentIntent = PaymentIntent::create([
                'amount' => (int)$total,
                'currency' => self::CURRENCY,
                'metadata' => ['integration_check' => 'accept_a_payment']
            ]);

            return Inertia::render('Cart/Checkout', [
                'cart' => $cart,
                'client_secret' => $paymentIntent->client_secret,
                'total' => $total
            ]);
        } catch (ApiErrorException) {
            return redirect()->back()
                ->with('error', 'Error processing payment. Please try again.');
        }
    }

    /**
     * Calculate total cart amount
     */
    private function calculateTotal(array $cart): float
    {
        return array_reduce($cart, function (float $total, array $item) {
            return $total + $item['price'];
        }, 0);
    }

    /**
     * Handle successful payment
     */
    public function pay(Request $request): RedirectResponse
    {
        $cart = $this->getCart();

        if (empty($cart)) {
            return redirect()->route('home')
                ->with('error', 'No items in cart');
        }

        $stripePriceId = 'price_deluxe_album';

        $quantity = 1;

        return $request->user()->checkout([$stripePriceId => $quantity], [
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.cancel'),
        ]);
    }
}
