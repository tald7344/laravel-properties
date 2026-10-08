<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model;
class Setting extends Model { protected $fillable=['key','value','type']; public static function value(string $key,mixed $default=null):mixed{$s=static::where('key',$key)->first();if(!$s)return $default;return match($s->type){ 'boolean'=>(bool)$s->value,'integer'=>(int)$s->value,'json'=>json_decode($s->value,true),default=>$s->value };} }
