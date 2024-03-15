<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function details()
    {
        return $this->hasMany(DetailTransaction::class);
    }

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected static function boot(){
        parent::boot();

        static::creating(function($product){
            $product->id = static::generatePrimaryKey();
        });
    }
    
    protected static function generatePrimaryKey(){
        $latestPrimaryKey = static::latest('id')->value('id');

        if(!$latestPrimaryKey){
            return 'P001';
        }

        $number = intval(substr($latestPrimaryKey, 1)) + 1;
        $newPrimaryKey = 'P' . str_pad($number, 3, '0', 'STR_PAD_LEFT');
    }

    // protected static function generatePrimaryKey()
    // {
    //     $latestPrimaryKey = static::latest('id')->value('id');

    //     if (!$latestPrimaryKey) {
    //         return 'P001';
    //     }

    //     $number = intval(substr($latestPrimaryKey, 1)) + 1;
    //     $newPrimaryKey = 'P' . str_pad($number, 3, '0', STR_PAD_LEFT);

    //     return $newPrimaryKey;
    // }

    public function scopeSearch($query, $filter) // nama_produk, harga, dan id
    {
        $query->when($filter ?? false, function ($query, $search) {
            return $query->where('nama_produk', 'like', '%' . $search . '%')
                ->orWhere('harga', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%');
        });
    }
}
