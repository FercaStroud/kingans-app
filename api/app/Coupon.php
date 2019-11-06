<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

Class Coupon extends Model
{
    use SoftDeletes;
    protected $table = 'coupons';
    public $timestamps = true;
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $fillable = [
        'name',
        'decription',
        'code',
        'required_number',
        'start',
        'end',
        'branch_id' ,
    ];
    protected $primaryKey = 'id';
}