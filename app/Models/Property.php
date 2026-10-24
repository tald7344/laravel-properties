<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model {
    protected $fillable = ['user_id','title','description','city','neighborhood','address','purpose','category','price','currency','bedrooms','bathrooms','floor','area','furnished','reward_available','media','amenities','video_url','status','last_confirmed_at','published_at'];
    protected $casts = ['media'=>'array','amenities'=>'array','furnished'=>'boolean','reward_available'=>'boolean','last_confirmed_at'=>'datetime','published_at'=>'datetime'];

    public function owner() { return $this->belongsTo(User::class, 'user_id'); }
    public function inquiries() { return $this->hasMany(Inquiry::class); }

    public function mediaUrls(): array
    {
        $items = $this->media ?? [];

        if (! is_array($items)) {
            $items = [$items];
        }

        return array_values(array_filter(array_map(fn ($item) => $this->resolveMediaUrl($item), $items), fn ($item) => ! empty($item)));
    }

    public function imageUrl(?int $index = 0): ?string
    {
        $images = $this->mediaUrls();

        return $images[$index] ?? null;
    }

    protected function resolveMediaUrl($value): ?string
    {
        if (blank($value)) {
            return null;
        }

        if (is_array($value)) {
            $value = $value['path'] ?? $value['url'] ?? null;
        }

        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        if (preg_match('#^https?://|^//#', $value)) {
            return $value;
        }

        $normalized = ltrim($value, '/');

        if (str_starts_with($normalized, 'storage/')) {
            return asset($normalized);
        }

        if (str_starts_with($normalized, 'images/')) {
            return asset($normalized);
        }

        if (str_contains($normalized, 'images/properties/') || str_contains($normalized, 'property-')) {
            return asset($normalized);
        }

        return asset('storage/' . $normalized);
    }
}
