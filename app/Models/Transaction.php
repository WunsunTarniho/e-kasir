<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function details()
    {
        return $this->hasMany(DetailTransaction::class);
    }

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            $transaction->id = static::generatePrimaryKey();
        });
    }

    protected static function generatePrimaryKey()
    {
        $latestPrimaryKey = static::latest('id')->value('id');

        if (!$latestPrimaryKey) {
            return 'T001';
        }

        $number = intval(substr($latestPrimaryKey, 1)) + 1;
        $newPrimaryKey = 'T' . str_pad($number, 3, '0', STR_PAD_LEFT);

        return $newPrimaryKey;
    }

    public function scopeSearch($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->whereHas('customer', function ($query) use ($search) {
                $query->where('nama_pelanggan', 'like', '%' . $search . '%');
            })->orWhere('id', 'like', '%' . $search . '%');
        });

        $query->when($filters['start_date'] ?? false, function ($query, $search){
            return $query->whereDate('created_at', '>=', $search);
        });

        $query->when($filters['end_date'] ?? false, function ($query, $search){
            return $query->whereDate('created_at', '<=', $search);
        });
    }
}
