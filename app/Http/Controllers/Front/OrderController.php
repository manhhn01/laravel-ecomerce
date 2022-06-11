<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\ProductVariant;
use App\Models\User;
use App\Repositories\CartProducts\CartProductRepositoryInterface;
use App\Repositories\Orders\OrderRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

class OrderController extends Controller
{
    protected $orderRepo;
    protected $cartRepo;
    public function __construct(OrderRepositoryInterface $orderRepo, CartProductRepositoryInterface $cartRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->cartRepo = $cartRepo;
    }
    //todo validate request
    public function store(Request $request)
    {
        $user = auth('sanctum')->user();
        if (empty($user)) {
            //todo coupon function
            $address = Address::create($request->only(['phone', 'lat', 'lon', 'ward_id', 'address', 'first_name', 'last_name']));
            $products = collect($request->cart)->map(function ($product) {
                $variant = ProductVariant::find($product['variant_id']);
                if (!empty($variant)) {
                    $variant->pivot = (object) ['quantity' => $product['cart_quantity']];
                    return $variant;
                }
            });
            $payment_method = $request->payment_method;

            $order = Order::create([
                'id' => time(),
                'address_id' => $address->id,
                'payment_method' => $payment_method
            ]);
        } else {
            $attributes = $request->only(['address_id', 'coupon_id', 'payment_method']);
            $order = $user->orders()->create($attributes);
            $products = $this->cartRepo->getUserCart($user);
        }

        $order->orderProducts()->sync($products->mapWithKeys(function ($variant) {
            return [
                $variant->id => [
                    'price' => $variant->product->sale_price ?? $variant->product->price,
                    'quantity' => $variant->pivot->quantity
                ]
            ];
        }));
        switch ($request->payment_method) {
            case 'momo':
                $response = $this->m2InitPayment($order, $user ?? $address);
                if ($response->resultCode === 0) {
                    // todo return more information
                    return response()->json([
                        'status' => 'success',
                        'message' => $response->message,
                        'order_id' => $response->orderId ?? null,
                        'pay_url' => $response->payUrl ?? null,
                        'deeplink' => $response->deeplink ?? null,
                    ]);
                } else {
                    \Log::debug($response->message);
                    return response()->json([
                        'error' => 'Có lỗi xảy ra. Vui lòng chọn phương thức thanh toán khác'
                    ]);
                }
                break;
            case 'cod':
                return response()->json([
                    'message' => 'Đặt hàng thành công',
                    'status' => 'success'
                ]);
                break;
            default:
                return abort(500);
        }
    }

    public function momoRedirect(Request $request)
    {
        $order = $this->orderRepo->find($request->orderId);

        if (!empty($order)) {
            if ($request->signature === $order->signature && $order->status == 0) {
                $order->update(['status' => 1]);
            };
        }
        dd("ok");

        //todo return sendMessage view
    }

    public function momoIpn(Request $request)
    {
        // todo test on host
        $order = $this->orderRepo->find($request->orderId);

        if (!empty($order)) {
            if ($request->signature === $order->signature && $order->status == 0) {
                $order->update(['status' => 1]);
            };
        }

        return response('', 204);
    }

    /**
     * @param Order $order
     * @param User $user
     * @return object $response
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    protected function m2InitPayment($order, $user)
    {
        $requestId = time() . '';
        $data = [
            'partnerCode' => config('services.momo.partner_code'),
            'requestId' => $requestId,
            'amount' => $order->totalPrice,
            'orderId' => $order->id,
            'orderInfo' => "Thanh toán hóa đơn #$order->id cho $user->last_name $user->first_name tại cửa hàng LifeWear",
            'redirectUrl' => route('momo.redirect'),
            'ipnUrl' => route('momo.ipn'),
            'requestType' => 'captureWallet',
            'extraData' => '',
            'orderGroupId' => '',
            'lang' => 'en'
        ];

        $rawSignature = "accessKey=" . config('services.momo.access_key') . "&amount={$data['amount']}&extraData={$data['extraData']}&ipnUrl={$data['ipnUrl']}&orderId={$data['orderId']}&orderInfo={$data['orderInfo']}&partnerCode={$data['partnerCode']}&redirectUrl={$data['redirectUrl']}&requestId={$data['requestId']}&requestType={$data['requestType']}";
        $signature = hash_hmac('sha256', $rawSignature, config('services.momo.secret_key'));
        $data = array_merge($data, ['signature' => $signature]);

        \Log::debug($order);
        $order->update([
            'request_id' => $requestId,
            'payment_signature' => $signature
        ]);

        return Http::post(config('services.momo.paygate') . '/v2/gateway/api/create', $data)->object();
    }
}
