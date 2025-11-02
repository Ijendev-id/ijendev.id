<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'nama_klien','jenis_klien','email','telepon','alamat','website','logo','deskripsi_klien'
    ];

    public function projects(): HasMany {
        return $this->hasMany(Project::class);
    }

    public function contacts(): HasMany {
        return $this->hasMany(Contact::class);
    }

    // Accessor kecil untuk logo url publik
    public function getLogoUrlAttribute(): ?string {
        return $this->logo ? asset('storage/'.$this->logo) : null;
    }
}
