<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'type', // 'income' atau 'expense'
        'amount',
        'transaction_date',
        'description',
        'receipt_image_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // Penting untuk memastikan date diolah sebagai Carbon instance
        'transaction_date' => 'date', 
        // Menyimpan nilai uang sebagai float saat diakses, tapi sebaiknya tetap decimal di DB
        'amount' => 'float', 
    ];
    
    // Konstanta untuk Tipe Transaksi
    public const TYPE_INCOME = 'income';
    public const TYPE_EXPENSE = 'expense';

    /**
     * Get the user that owns the Transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get receipts associated with the transaction (one-to-many).
     */
    public function receipts(): HasMany
    {
        return $this->hasMany(TransactionReceipt::class);
    }
    
    // --- Accessors/Mutators untuk Gambar ---
    
    /**
     * Get the full URL path for the receipt image.
     */
    public function getReceiptImageUrlAttribute(): ?string
    {
        // Prefer existing receipts table if available
        $first = null;
        if (method_exists($this, 'receipts')) {
            $first = $this->receipts()->latest()->first();
        }

        if ($first && $first->path) {
            return asset('storage/' . $first->path);
        }

        if ($this->receipt_image_path) {
            return asset('storage/' . $this->receipt_image_path);
        }

        return null;
    }
}