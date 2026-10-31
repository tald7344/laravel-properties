<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LegalPage extends Model
{
    protected $fillable = ['slug', 'is_published', 'sort_order'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }

    public function translations(): HasMany
    {
        return $this->hasMany(LegalPageTranslation::class);
    }
}
