<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected static function boot(){
        parent::boot();

        static::creating(function($customer){
            $customer->id = static::generatePrimaryKey();
        });
    }

    protected static function generatePrimaryKey(){
        $lastPrimaryKey = static::latest('id')->value('id');

        if(!$lastPrimaryKey){
            return 'C001';
        }

        $number = intval(substr($lastPrimaryKey, 1)) + 1;
        $newPrimaryKey = 'C' . str_pad($number, 3, '0', STR_PAD_LEFT);

        return $newPrimaryKey;
    }

    public function scopeSearch($query, $filter){
        $query->when($filter ?? false, function($query, $search){
            return $query->where('nama_pelanggan', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->orWhere('no_telp', 'like', '%' . $search . '%');
        });
    }
}
