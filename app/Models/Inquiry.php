<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Inquiry extends Model { protected $fillable=['property_id','user_id','phone','message','status']; public function property(){return $this->belongsTo(Property::class);} }
