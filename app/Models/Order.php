<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable=
    [
        'order_number',
           'status',
           'delivery_type',
           'user_id',
           'copone_code',
        //    'discount_amount',
        //    'total_amount'
    ];
    //relation
    public function user()
    {
        return $this->beLongsTo(User::class);
    }
    //order items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    //genrate order number
    public static function generateOrderNumber()
    {
        // البحث عن آخر طلبية
        $lastOrder = DB::table('orders')->orderBy('id', 'desc')->first();

        // تعيين رقم الطلبية الافتراضي كـ 0001 إذا لم يكن هناك طلبيات سابقة
        if (!$lastOrder) {
            $newOrderNumber = 'ORD-0001';
        } else {
            // استخراج الرقم من رقم الطلبية الحالي (مثل 0001 من ORD-0001)
            $lastOrderNumber = (int) str_replace('ORD-', '', $lastOrder->order_number);

            // زيادة الرقم بمقدار 1
            $newOrderNumber = 'ORD-' . str_pad($lastOrderNumber + 1, 4, '0', STR_PAD_LEFT);
        }

        return $newOrderNumber;
    }

}
