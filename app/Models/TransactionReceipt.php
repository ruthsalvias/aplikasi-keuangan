<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'path',
        'uploaded_by',
    ];

    /**
     * The transaction this receipt belongs to.
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * (Optional) The user who uploaded the receipt.
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Full URL accessor.
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
