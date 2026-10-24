<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Report extends Model { protected $fillable=['property_id','reporter_id','subject_type','subject_name','subject_contact','type','details','status']; public function property(){return $this->belongsTo(Property::class);} public function reporter(){return $this->belongsTo(User::class,'reporter_id');} }
