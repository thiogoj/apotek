<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'obats';

    public function transaksi() {
        return $this->hasOne(Transaksi::class, 'id_obat');
    }
}
