<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TypeManifestDocument extends Model
{
    use HasFactory;
    protected $fillable = ['name',
                           'status_id',
                           'user_id'];

    protected $with=["status"];

    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function documentManifests(): HasMany
    {
        return $this->hasMany(ManifestFile::class, 'type_manifest_document_id', 'id');
    }
}
