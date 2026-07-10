<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'pengaturans';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_kades',
        'nip_kades',
        'jabatan',
    ];
}
