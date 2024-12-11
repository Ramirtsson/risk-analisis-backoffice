<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class ManifestFile extends Model
{
    use HasFactory;
    protected $fillable = ['file','path','manifest_id','type_manifest_document_id','status_id','user_id'];
    
    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return url('/' . $this->path);
    }
}
