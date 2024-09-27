<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class FileAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'owner_id',
        'path',
        'owner_type',
    ];


    public function destroyCompletely(): void
    {
        $did = Storage::disk()->delete($this->path);
        $this->delete();

        return;
    }


    public function url(): string
    {
        return Storage::disk()->temporaryUrl($this->path, now()->addMinutes(30));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
