<?php
namespace App\Jobs;
use App\Models\Property; use Illuminate\Contracts\Queue\ShouldQueue; use Illuminate\Foundation\Bus\Dispatchable; use Illuminate\Queue\InteractsWithQueue; use Illuminate\Queue\SerializesModels; use Illuminate\Support\Facades\Log;
class NotifyPropertySubmitted implements ShouldQueue { use Dispatchable,InteractsWithQueue,SerializesModels; public function __construct(public int $propertyId){} public function handle():void{$property=Property::find($this->propertyId);if($property)Log::info('Property submitted for moderation',['property_id'=>$property->id,'owner_id'=>$property->user_id]);} }
