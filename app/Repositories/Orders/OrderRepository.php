<?php

namespace App\Repositories\Orders;

use App\Exceptions\ExpiredCouponException;
use App\Exceptions\InvalidQuantityException;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Statistic;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function getModel()
    {
        return Order::class;
    }

    public function create($attributes)
    {
        $order_prods = $attributes['products'];
        if (isset($attributes['coupon_id'])) {
            try {
                $coupon = Coupon::findOrFail($attributes['coupon_id']);
            } catch (ModelNotFoundException $e) {
                throw new ModelNotFoundException('Không tìm thấy mã giảm giá');
            }
            if (!$coupon->isUsable) {
                // throw new ExpiredCouponException('Mã giảm giá đã hết hạn');
            }
        }

        $attach_products = [];
        foreach ($order_prods as $order_prod) {
            try {
                $product = Product::findOrFail($order_prod['product_id']);

                if ($order_prod['quantity'] > $product->quantity) {
                    // throw new InvalidQuantityException('Số lượng sản phẩm lớn hơn số lượng có hoặc đã hết hàng');
                }

                $attach_products[$order_prod['product_id']] = [
                    'quantity' => $order_prod['quantity'],
                    'price' => $product->price,
                ];
            } catch (ModelNotFoundException $e) {
                throw new ModelNotFoundException('Không tìm thấy sản phẩm');
            }
        }

        $order = parent::create($attributes);

        $order->products()->attach($attach_products);
        // cach 2
        // foreach ($order_prods as $order_prod) {
        //     $order->products()->attach( $order_prod["product_id"], ['quantity' => $order_prod["quantity"], 'price' => $order_prod["price"]]);
        // }

        if (isset($order->coupon)) {
            $order->coupon->decrement('remain');
        }

        //status = 3: trang thai huy
        if ($order->status !== 3) {
            foreach ($order->products as $product) {
                $product->decrement('quantity', $product->pivot->quantity);
            }
            $this->updateStatistic($order);
        }
    }

    public function update($id, $attributes)
    {
        try {
            $order = $this->model->find($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Không tìm thấy đơn hàng');
        }

        $order_prods = $attributes['products'];
        if (isset($attributes['coupon_id'])) {
            try {
                Coupon::findOrFail($attributes['coupon_id']);
            } catch (ModelNotFoundException $e) {
                throw new ModelNotFoundException('Không tìm thấy mã giảm giá');
            }
        }

        $sync_products = [];
        try {
            foreach ($order_prods as $new_product) {
                $product = Product::findOrFail($new_product['product_id']); //trong kho
                $old_product = $order->products->firstWhere('id', $new_product['product_id']); //trong don hang
                if (!empty($old_product)) { //sản phẩm được cập nhật số lư
                    if ($product->quantity + $old_product->pivot->quantity - $new_product['quantity'] < 0) {
                        throw new InvalidQuantityException('Sản phẩm đã hết hàng');
                    }
                    $product_price = $old_product->pivot->price;
                } else {
                    if ($new_product['quantity'] > $product->quantity) { //san pham duoc them moi vao don hang
                        throw new InvalidQuantityException('Số lượng sản phẩm lớn hơn số lượng có hoặc đã hết hàng');
                    }
                    $product_price = $product->price;
                }
                $sync_products[$new_product['product_id']] = [
                    'quantity' => $new_product['quantity'],
                    'price' => $product_price,
                ];
            }
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Không tìm thấy sản phẩm');
        }

        // tra lai hang cu ve kho
        if ($order->status !== 3) { //trang thai huy
            foreach ($order->products as $product) {
                $product->increment('quantity', $product->pivot->quantity);
            }
        }
        if (isset($order->coupon)) {
            $order->coupon->increment('remain');
        }

        $order = parent::update($id, $attributes);
        // thay cho attach
        $order->products()->sync($sync_products);

        //cap nhat lai hang trong kho
        if ($order->status !== 3) { //trang thai huy
            foreach ($order->products as $product) {
                $product->decrement('quantity', $product->pivot->quantity);
            }
        }

        if (isset($order->coupon)) {
            $order->coupon->decrement('remain');
        }
    }

    public function updateStatistic($order)
    {
        $statistic = Statistic::whereDate('created_at', $order->created_at)->first();

        if (empty($statistic)) {
            Statistic::create([
                "order_total" => 1,
                "product_total" => $order->totalProduct,
                "proceeds" => $order->totalPrice
            ]);
        } else {
            $statistic->update([
                "order_total" => $statistic->order_total + 1,
                "product_total" => $statistic->product_total + $order->totalProduct,
                "proceeds" => $statistic->proceeds + $order->totalPrice
            ]);
        }
    }

    public function filterAndPage($filters, $perPage = 30, $sortBy = 'created_at', $order = 'desc')
    {
        $orders = $this->model->with('address.ward.district.province', 'buyer', 'orderProducts')->orderBy($sortBy, $order);
        if (!empty($filters)) {
            //todo
        }

        return $orders->paginate($perPage);
    }
}
