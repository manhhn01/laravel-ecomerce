<?php

namespace App\Repositories\ReceivedNote;

use App\Models\Product;
use App\Models\ReceivedNote;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReceivedNoteRepository extends BaseRepository implements ReceivedNoteRepositoryInterface
{
    public function getModel()
    {
        return ReceivedNote::class;
    }

    public function create($attributes)
    {
        $note_products = $attributes['products'];

        $attach_products = [];
        foreach ($note_products as $note_prod) {
            try {
                $product = Product::findOrFail($note_prod['product_id']);

                $attach_products[$note_prod['product_id']] = [
                    'quantity' => $note_prod['quantity'],
                    'price' => $note_prod['price'],
                ];
            } catch (ModelNotFoundException $e) {
                throw new ModelNotFoundException('Không tìm thấy sản phẩm');
            }
        }

        $note = parent::create($attributes);

        $note->products()->attach($attach_products);

        if ($note->status === 1) {
            foreach ($note->products as $product) {
                $product->increment('quantity', $product->pivot->quantity);
            }
        }
    }

    public function update($id, $attributes)
    {
        try {
            $note = $this->model->find($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Không tìm thấy phiếu');
        }

        $note_products = $attributes['products'];

        $sync_products = [];
        foreach ($note_products as $new_product) {
            try {
                Product::findOrFail($new_product['product_id']); //trong kho

                $sync_products[$new_product['product_id']] = [ //luu san pham moi vao de sync
                    'quantity' => $new_product['quantity'],
                    'price' => $new_product['price'],
                ];
            } catch (ModelNotFoundException $e) {
                throw new ModelNotFoundException('Không tìm thấy sản phẩm');
            }
        }

        if ($note->status === 1) { //trang thai da giao
            // tra lai hang cu ve kho
            foreach ($note->products as $product) {
                $product->decrement('quantity', $product->pivot->quantity);
            }
        }

        $note = parent::update($id, $attributes);
        $note->products()->sync($sync_products);

        //cap nhat lai hang trong kho
        if ($note->status === 1) { //trang thai da giao
            foreach ($note->products as $product) {
                $product->increment('quantity', $product->pivot->quantity);
            }
        }
    }
}
