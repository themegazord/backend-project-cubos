<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Validator;

class Installment extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'id_billing',
        'status',
        'debtor_id',
        'emission_date',
        'due_date',
        'overdue_payment',
        'amount',
        'paid_amount'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function debtor(): BelongsTo {
        return $this->belongsTo(Debtor::class, 'debtor_id', 'id');
    }
}
