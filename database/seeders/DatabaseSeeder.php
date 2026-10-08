<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $owner = User::updateOrCreate(['phone' => '0999999999'], ['name' => 'مالك تجريبي', 'email' => 'owner@dark.local', 'role' => 'owner', 'password' => 'password']);
        User::updateOrCreate(['phone' => '0888888888'], ['name' => 'مدير المنصة', 'email' => 'admin@dark.local', 'role' => 'admin', 'password' => 'password']);
        $renter = User::updateOrCreate(['phone' => '0777777777'], ['name' => 'مستأجر تجريبي', 'email' => 'renter@dark.local', 'role' => 'renter', 'password' => 'password']);
        foreach ([['admin','مدير النظام'],['owner','مالك'],['renter','مستأجر']] as [$name,$label]) { \App\Models\Role::firstOrCreate(['name'=>$name],['label'=>$label]); }
        foreach ([['manage-settings','إدارة الإعدادات','admin.section'],['manage-users','إدارة المستخدمين','admin.section'],['moderate-properties','مراجعة العقارات','admin.moderate'],['manage-roles','إدارة الأدوار','admin.roles.index'],['manage-permissions','إدارة الصلاحيات','admin.permissions.index'],['manage-subscriptions','إدارة الاشتراكات','admin.section'],['manage-complaints','إدارة الشكاوى','admin.section'],['view-properties','عرض العقارات','properties.index'],['create-property','إضافة عقار','owner.properties.create']] as [$name,$label,$route]) { \App\Models\Permission::updateOrCreate(['name'=>$name],['label'=>$label,'route_name'=>$route]); }
        $admin=User::where('phone','0888888888')->first(); $ownerRole=\App\Models\Role::where('name','owner')->first(); $adminRole=\App\Models\Role::where('name','admin')->first(); $renterRole=\App\Models\Role::where('name','renter')->first(); $admin->roles()->syncWithoutDetaching([$adminRole->id]); $owner->roles()->syncWithoutDetaching([$ownerRole->id]); $adminRole->permissions()->sync(\App\Models\Permission::pluck('id')); $ownerRole->permissions()->sync(\App\Models\Permission::whereIn('name',['view-properties','create-property'])->pluck('id')); $renterRole->permissions()->sync(\App\Models\Permission::where('name','view-properties')->pluck('id'));
        foreach ([['site_name','دارك','string'],['owner_bonus_note','المكافأة اختيارية بين الطرفين وليست مضمونة من المنصة.','string'],['trial_days','30','integer']] as [$key,$value,$type]) { \App\Models\Setting::updateOrCreate(['key'=>$key],['value'=>$value,'type'=>$type]); }
        foreach ([['ar','Arabic','العربية','rtl',true,true],['en','English','English','ltr',true,false]] as [$code,$name,$native,$direction,$active,$default]) { \App\Models\Language::updateOrCreate(['code'=>$code],['name'=>$name,'native_name'=>$native,'direction'=>$direction,'is_active'=>$active,'is_default'=>$default]); }
        foreach ([['default_language','ar','string'],['maintenance_mode','0','boolean'],['website_name','دارك','string'],['seo_title','دارك — عقارك مباشرة','string'],['seo_description','منصة عقارية سورية للربط المباشر بين المالك والمستأجر.','string'],['seo_keywords','عقارات سوريا، دمشق، إيجار، بيع، مالك','string'],['default_currency','USD','string'],['default_reward_enabled','0','boolean'],['default_reward_amount','0','integer']] as [$key,$value,$type]) { \App\Models\Setting::updateOrCreate(['key'=>$key],['value'=>$value,'type'=>$type]); }
        \App\Models\Property::updateOrCreate(['title' => 'شقة مضيئة في جرمانا'], ['user_id' => $owner->id, 'description' => 'شقة عملية وقريبة من الخدمات، مناسبة لعائلة صغيرة.', 'city' => 'Jaramana', 'neighborhood' => 'البلدية', 'address' => 'قرب الساحة الرئيسية', 'purpose' => 'rent', 'category' => 'residential', 'price' => 450, 'currency' => 'USD', 'bedrooms' => 2, 'floor' => 3, 'area' => 110, 'furnished' => true, 'status' => 'published', 'last_confirmed_at' => now(), 'published_at' => now()]);
        \App\Models\Property::updateOrCreate(['title' => 'محل تجاري في دمشق'], ['user_id' => $owner->id, 'description' => 'واجهة تجارية على شارع حيوي.', 'city' => 'Damascus', 'neighborhood' => 'أبو رمانة', 'purpose' => 'rent', 'category' => 'commercial', 'price' => 1200, 'currency' => 'USD', 'area' => 75, 'status' => 'published', 'last_confirmed_at' => now(), 'published_at' => now()]);
        $shop = \App\Models\Property::where('title','محل تجاري في دمشق')->first(); $flat = \App\Models\Property::where('title','شقة مضيئة في جرمانا')->first();
        \App\Models\Subscription::updateOrCreate(['sham_cash_reference'=>'DEMO-SHAM-001'],['user_id'=>$owner->id,'plan'=>'monthly','amount'=>10,'status'=>'approved','starts_at'=>now()->subDays(8),'ends_at'=>now()->addDays(22)]);
        \App\Models\Subscription::updateOrCreate(['sham_cash_reference'=>'DEMO-SHAM-002'],['user_id'=>$owner->id,'plan'=>'monthly','amount'=>10,'status'=>'pending']);
        \App\Models\Report::updateOrCreate(['property_id'=>$shop->id,'type'=>'old'],['reporter_id'=>$renter->id,'details'=>'يرجى التأكد من استمرار توفر المحل.', 'status'=>'open']);
        \App\Models\Report::updateOrCreate(['property_id'=>$flat->id,'type'=>'suspicious'],['reporter_id'=>$renter->id,'details'=>'الوصف يحتاج إلى مراجعة من فريق الإدارة.', 'status'=>'open']);
    }
}
