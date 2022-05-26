<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Repositories\Orders\OrderRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

class OrderController extends Controller
{
    protected $orderRepo;
    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }
    public function store(Request $request)
    {
        $user = $request->user();
        $attributes = $request->only(['address_id', 'coupon_id', 'payment_method']);

        $order = $user->orders()->create($attributes);
        $order->orderProducts()->sync($user->cartProducts->mapWithKeys(function ($variant) {
            return [
                $variant->id => [
                    'price' => $variant->product->sale_price ?? $variant->product->price,
                    'quantity' => $variant->pivot->quantity
                ]
            ];
        }));

        if ($request->input('payment_method') == 'momo') {
            $response = $this->m2InitPayment($order, $user);
            if ($response->resultCode == 0) {
                // todo return more information
                return response()->json([
                    // 'result_code' => $response->resultCode,
                    'message' => $response->message,
                    'order_id' => $response->orderId ?? null,
                    'pay_url' => $response->payUrl ?? null,
                    'deeplink' => $response->deeplink ?? null,
                ]);
            } else abort(500);
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

        //todo return sendMessage view
    }

    public function momoIpn(Request $request)
    {
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
            'orderInfo' => "Thanh toán hóa đơn #$order->id cho $user->full_name tại cửa hàng LifeWear",
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

        $order->update([
            'request_id' => $requestId,
            'signature' => $signature
        ]);

        return Http::post(config('services.momo.paygate') . '/v2/gateway/api/create', $data)->object();
    }
}
