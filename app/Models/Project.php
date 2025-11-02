<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $fillable = [
        'client_id','nama_proyek','kategori_proyek','deskripsi_proyek','fitur_utama',
        'teknologi_digunakan','status_proyek','tanggal_mulai','tanggal_selesai',
        'nilai_proyek','url_demo','repo_url','gambar_proyek','catatan_tambahan'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'nilai_proyek' => 'decimal:2',
    ];

    public function client(): BelongsTo {
        return $this->belongsTo(Client::class);
    }

    public function getGambarUrlAttribute(): ?string {
        return $this->gambar_proyek ? asset('storage/'.$this->gambar_proyek) : null;
    }
}
