<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Report extends Model { protected $fillable=['property_id','reporter_id','type','details','status']; public function property(){return $this->belongsTo(Property::class);} public function reporter(){return $this->belongsTo(User::class,'reporter_id');} }
