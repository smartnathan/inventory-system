<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderLine extends Model
{
    //
    public function purchaseOrderHeader()
    {
        return $this->belongsTo(PurchaseOrderHeader::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
