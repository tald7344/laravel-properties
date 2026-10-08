<?php
namespace App\Http\Controllers;
use App\Models\Property;
class AdminPropertiesController extends Controller { private function admin(){abort_unless(auth()->check()&&auth()->user()->role==='admin',403);} public function index(){$this->admin();$properties=Property::with('owner')->latest()->paginate(15);return view('admin.properties',compact('properties'));} public function show(Property $property){$this->admin();$property->load('owner');return view('admin.property-show',compact('property'));} }
