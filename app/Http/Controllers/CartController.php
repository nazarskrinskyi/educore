<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\CartEnum;
use App\Models\Course;
use App\Services\CartService;
use App\Services\CourseService;
use Inertia\Inertia;
use Illuminate\Http\{JsonResponse, Request, RedirectResponse};
use Illuminate\Support\Facades\Session;
use Inertia\Response as InertiaResponse;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;
use Throwable;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService   $cartService,
        private readonly CourseService $courseService
    )
    {
    }

    /**
     * Display the shopping cart
     */
    public function index(): InertiaResponse
    {
        return Inertia::render('Cart/Index', [
            'cart' => $this->cartService->getCart()
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

        $id = $validated['course_id'];

        $course = Course::with('instructor', 'reviews')->findOrFail($id);
        $cart = $this->cartService->getCart();

        if (isset($cart[$id])) {
            return redirect()->back()->with('warning', 'Course already in cart');
        }

        $cart[$id] = $this->cartService->assignCourseData($course, $id);

        $this->cartService->saveCart($cart);

        return redirect()->back()->with('success', 'Course added to cart');
    }

    /**
     * Remove a course from the cart
     */
    public function remove(string $id): RedirectResponse
    {
        $cart = $this->cartService->getCart();

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $this->cartService->saveCart($cart);

            return redirect()->back()->with('success', 'Course removed from cart');
        }

        return redirect()->back()->with('error', 'Course not found in cart');
    }

    /**
     * Show the checkout page with Stripe payment intent
     * @throws ApiErrorException
     */
    public function checkout(): InertiaResponse|RedirectResponse
    {
        $cart = $this->cartService->getCart();
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $total = $this->cartService->calculateTotal($cart);

        Stripe::setApiKey(config('services.stripe.secret'));
        $paymentIntent = PaymentIntent::create([
            'amount' => (int)($total * 100),
            'currency' => CartEnum::CURRENCY->value,
            'metadata' => [
                'user_id' => auth()->id() ?? null,
            ],
        ]);

        return Inertia::render('Cart/Checkout', [
            'cart' => $cart,
            'client_secret' => $paymentIntent->client_secret,
            'total' => $total,
        ]);
    }

    /**
     * Store order in db and clears cart session
     */
    public function storeOrder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'payment_intent_id' => ['required'],
        ]);

        try {
            $cart = $this->cartService->getCart();
            $this->cartService->storeOrder($validated['payment_intent_id'], $cart);
            $this->courseService->enrollUser($cart);
            $this->courseService->notifyInstructors($cart);

            Session::forget(CartEnum::CART_SESSION_KEY->value);

            return response()->json(['success' => true]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
