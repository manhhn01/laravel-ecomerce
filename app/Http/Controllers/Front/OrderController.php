<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        /** @var User */
        $user = $request->user();

        $attributes = $request->only(['address_id', 'coupon_id']);

        /** @var Order */
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
            $data = [
                'partnerCode' => config('services.momo.partner_code'),
                'requestId' => time() . '',
                // 'partnerName' => 'Momo partner',
                'amount' => 50000,
                'orderId' => $order->id,
                'orderInfo' => "Thanh toán hóa đơn #$order->id cho $user->full_name tại cửa hàng LifeWear",
                'redirectUrl' => route('momo.redirect'), //todo redirect to backend
                'ipnUrl' => route('momo.ipn'),
                'requestType' => 'captureWallet',
                'extraData' => '',
                'orderGroupId' => '',
                'lang' => 'en'
            ];

            $data += [
                'signature' => hash_hmac('sha256', "accessKey=" . config('services.momo.access_key') . "&amount={$data['amount']}&extraData={$data['extraData']}&ipnUrl={$data['ipnUrl']}&orderId={$data['orderId']}&orderInfo={$data['orderInfo']}&partnerCode={$data['partnerCode']}&redirectUrl={$data['redirectUrl']}&requestId={$data['requestId']}&requestType={$data['requestType']}", config('services.momo.secret_key'))
            ];

            $response = Http::post(config('services.momo.paygate') . '/v2/gateway/api/create', $data)->object();
            // if ($response->resultCode == 0) {
            return response()->json([
                'result_code' => $response->resultCode,
                'message' => $response->message,
                'pay_url' => $response->payUrl ?? null,
                'deeplink' => $response->deeplink ?? null,
                'order_id' => $response->orderId ?? null,
            ]);
            // } else abort(500);
        }
    }

    public function momoRedirect(Request $request){
        dd($request->all());
    }

    public function momoIpn(Request $request)
    {
        \Log::debug($request->all());
        return response('', 204);
    }
}
