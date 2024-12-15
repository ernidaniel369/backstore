<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyers extends Model
{
    use HasFactory;
    protected $fillable = ['purchase_id', 'status', 'email_user', 'email_paypal', 'id_user', 'total'];
}
