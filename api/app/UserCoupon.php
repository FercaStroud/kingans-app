<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

Class UserCoupon extends Model
{
    use SoftDeletes;
    protected $table = 'user_coupons';
    public $timestamps = true;
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $fillable = [
        'user_id',
        'coupon_id',
    ];
    protected $primaryKey = 'id';
}