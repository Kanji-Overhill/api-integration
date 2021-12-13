<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'estatus',
        'amount',
        'cipUrl',
        'transactionCode',
        'paymentConcept',
        'additionalData',
        'userName',
        'userEmail',
        'userLastName',
        'userDocumentType',
        'userDocumentNumber',
        'userPhone',
        'created_at',
        'updated_at'
    ];
}
