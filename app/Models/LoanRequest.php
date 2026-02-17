<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRequest extends Model
{
    use CrudTrait, HasFactory;

    protected $table = 'loan_request';

    protected $fillable = [
        'user_id',
        'item_name',
        'status',
        'loan_date',
        'return_date',
        'reason',
    ];

    protected $casts = [
        'loan_date' => 'date',
        'return_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
