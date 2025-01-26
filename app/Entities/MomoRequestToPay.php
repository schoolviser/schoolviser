<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class MomoRequestToPay extends Model
{
    protected $fillable = [
        'transaction_id',
        'payer_id',
        'amount',
        'currency',
        'payer_message',
        'payee_note',
        'status',
        'transaction_status',
        'momo_transaction_id',
        'response_details',
        'callback',
        'callback_data'
    ];

    protected $casts = [
        'callback_data' => 'array'
    ];


    /**
     * Polymorphic relationship to the payable model.
     */
    public function model()
    {
        return $this->morphTo();
    }
}

