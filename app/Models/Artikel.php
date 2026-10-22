<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     *
     * @var string
     */
    protected $table = 'artikel';

    /**
     * Nama primary key.
     *
     * @var string
     */
    protected $primaryKey = 'Id';

    /**
     * Indikasi apakah ID auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Tipe data primary key.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Nonaktifkan timestamp otomatis (created_at & updated_at).
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Id',
        'Judul',
        'Isi',
        'Tanggal',
        'Link',
        'Image',
    ];

    /**
     * Boot model untuk meng-handle auto-generate Id jika kosong.
     */
    protected static function booted()
    {
        static::creating(function ($artikel) {
            if (empty($artikel->Id)) {
                $artikel->Id = ((int) static::max('Id')) + 1;
            }
        });
    }
}
