<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Property extends Model {
    protected $fillable = ['user_id','title','description','city','neighborhood','address','purpose','category','price','currency','bedrooms','bathrooms','floor','area','furnished','reward_available','media','amenities','video_url','status','last_confirmed_at','published_at'];
    protected $casts = ['media'=>'array','amenities'=>'array','furnished'=>'boolean','reward_available'=>'boolean','last_confirmed_at'=>'datetime','published_at'=>'datetime'];
    public function owner() { return $this->belongsTo(User::class, 'user_id'); }
    public function inquiries() { return $this->hasMany(Inquiry::class); }
}
