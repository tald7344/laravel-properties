<?php
namespace App\Http\Controllers;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class AdminSettingsController extends Controller {
    private function admin(){abort_unless(auth()->check()&&auth()->user()->role==='admin',403);}
    public function index(){ $this->admin(); $settings=Setting::pluck('value','key'); $languages=Language::where('is_active',true)->orderByDesc('is_default')->orderBy('name')->get(); return view('admin.settings',compact('settings','languages')); }
    public function update(Request $r){
        $this->admin();
        $d=$r->validate([
            'default_language'=>['required','string',Rule::exists('languages','code')->where('is_active',true)], 'maintenance_mode'=>'nullable|boolean',
            'website_name'=>'required|string|max:150', 'trial_days'=>'required|integer|min:0|max:3650',
            'seo_title'=>'nullable|string|max:255', 'seo_description'=>'nullable|string|max:500',
            'seo_keywords'=>'nullable|string|max:500', 'default_currency'=>'required|in:USD,SYP',
            'default_reward_enabled'=>'nullable|boolean', 'default_reward_amount'=>'nullable|numeric|min:0',
        ]);
        $d['maintenance_mode']=$r->boolean('maintenance_mode');
        $d['default_reward_enabled']=$r->boolean('default_reward_enabled');
        foreach($d as $key=>$value){
            $type=is_bool($value)?'boolean':(is_numeric($value)&&in_array($key,['trial_days','default_reward_amount'],true)?'integer':'string');
            Setting::updateOrCreate(['key'=>$key],['value'=>is_bool($value)?(int)$value:$value,'type'=>$type]);
        }
        return back()->with('success','تم حفظ إعدادات الموقع.');
    }
}
