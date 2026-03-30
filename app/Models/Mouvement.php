<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mouvement extends Model
{
    // هادي ضرورية باش ما يعطيكش Error ديال Fillable
    protected $fillable = ['product_id', 'user_id', 'type', 'quantite', 'motif'];

    // علاقة الموفمو بالمنتج (باش نعرفو هاد الحركة ديال أي سلعة)
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // علاقة الموفمو بالمستخدم (شكون لي خرج السلعة)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
