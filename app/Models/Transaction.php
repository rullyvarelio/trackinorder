<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'token_order',
        'total_price',
        'paid',
        'changes',
    ];

    public static function revenueThisYear()
    {
        return self::whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->sum('total_price');
    }

    public static function revenueThisMonth()
    {
        return self::whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ])->sum('total_price');
    }

    public static function revenueLastMonth()
    {
        return self::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth(),
        ])->sum('total_price');
    }

    public static function calculateGrowthRate()
    {
        $thisMonth = self::revenueThisMonth();
        $lastMonth = self::revenueLastMonth();

        return ($lastMonth > 0)
            ? (($thisMonth - $lastMonth) / $lastMonth) * 100
            : 0;
    }

    public static function totalRevenue()
    {
        return self::sum('total_price');
    }
}
