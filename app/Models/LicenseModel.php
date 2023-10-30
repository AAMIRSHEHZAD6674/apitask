<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenseModel extends Model
{
    use HasFactory;
    protected $table ='licenses';
    protected $guarded =['*'];
    protected $fillable = [

        'owner_name',
        'business_name',
        'voucher_no',
        'amount',
        'cnic','paid_amount','transecton_id','branch_code','paid_date',
    ];
}
