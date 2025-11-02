<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    protected $fillable = ['client_id','nama_cp','jabatan_cp','email_cp','telepon_cp'];

    public function client(): BelongsTo {
        return $this->belongsTo(Client::class);
    }
}
