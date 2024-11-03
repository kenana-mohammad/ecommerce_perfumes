<?php

namespace App\Observers;

use App\Models\OrderItem;
use App\Models\Product;

class DecreaseProductQuantityObserver
{
    /**
     * Handle the OrderItem "created" event.
     */
    public function created(OrderItem $orderItem): void
    {
        $product = Product::find($orderItem->product_id);

        if ($product) {
            $products = request()->input('products');
            $requestedQuantity = 0;

            if (is_array($products)) {
                foreach ($products as $productData) {
                    if ($productData['product_id'] == $orderItem->product_id) {
                        $requestedQuantity = $productData['quantity'];
                        break;
                    }
                }
            }

            if ($product->quantity >= $requestedQuantity) {
                $product->quantity -= $requestedQuantity;
                $product->save();
            } else {
                throw new \Exception("الكمية المطلوبة غير متوفرة لهذا المنتج.");
            }
        }
    
    }
    

    /**
     * Handle the OrderItem "updated" event.
     */
    public function updated(OrderItem $orderItem): void
    {
        //
    }

    /**
     * Handle the OrderItem "deleted" event.
     */
    public function deleted(OrderItem $orderItem): void
    {
        //
    }

    /**
     * Handle the OrderItem "restored" event.
     */
    public function restored(OrderItem $orderItem): void
    {
        //
    }

    /**
     * Handle the OrderItem "force deleted" event.
     */
    public function forceDeleted(OrderItem $orderItem): void
    {
        //
    }
}
