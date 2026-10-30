<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyContactRequest;
use App\Http\Requests\PropertyReportRequest;
use App\Http\Requests\PropertySearchRequest;
use App\Models\Property;
use App\Services\PropertiesService;

class PropertyController extends Controller
{
    public function __construct(private readonly PropertiesService $properties)
    {
    }

    public function landing()
    {
        return view('home', $this->properties->landing());
    }

    public function index(PropertySearchRequest $request)
    {
        return view('properties.index', $this->properties->listing($request->validated()));
    }

    public function search(PropertySearchRequest $request)
    {
        return response()->json($this->properties->search($request->validated()));
    }

    public function show(Property $property)
    {
        return view('properties.show', [
            'property' => $this->properties->show($property),
            'contactEnabled' => $property->owner?->activeSubscription() !== null,
        ]);
    }

    public function contact(PropertyContactRequest $request, Property $property)
    {
        $this->properties->contact($property, $request->user()?->id, $request->validated());

        return back()->with('success', __('تم تسجيل طلب التواصل. سيتواصل المالك معك مباشرة.'));
    }

    public function report(PropertyReportRequest $request, Property $property)
    {
        $this->properties->report($property, $request->user()?->id, $request->validated());

        return back()->with('success', __('شكرًا، وصل البلاغ وسيتم مراجعته.'));
    }
}
