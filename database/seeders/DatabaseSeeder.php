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
        $propertySeed = [
            ['title' => 'شقة مضيئة في جرمانا', 'description' => 'شقة عملية وقريبة من الخدمات، مناسبة لعائلة صغيرة.', 'city' => 'Jaramana', 'neighborhood' => 'البلدية', 'address' => 'قرب الساحة الرئيسية', 'purpose' => 'rent', 'category' => 'residential', 'price' => 450, 'currency' => 'USD', 'bedrooms' => 2, 'bathrooms' => 2, 'floor' => 3, 'area' => 110, 'furnished' => true, 'reward_available' => false, 'media' => ['images/properties/property-1.jpg', 'images/properties/property-2.jpg']],
            ['title' => 'محل تجاري في دمشق', 'description' => 'واجهة تجارية على شارع حيوي، مناسبة للأعمال المتنوعة.', 'city' => 'Damascus', 'neighborhood' => 'أبو رمانة', 'address' => 'شارع الوحدة', 'purpose' => 'rent', 'category' => 'commercial', 'price' => 1200, 'currency' => 'USD', 'bathrooms' => 1, 'area' => 75, 'furnished' => false, 'reward_available' => true, 'media' => ['images/properties/property-2.jpg', 'images/properties/property-3.jpg']],
            ['title' => 'فيلا عائلية في دير عطية', 'description' => 'فيلا واسعة مع حديقة وممر سيارات حديث.', 'city' => 'Damascus', 'neighborhood' => 'دير عطية', 'address' => 'منطقة الآراب', 'purpose' => 'sale', 'category' => 'residential', 'price' => 189000, 'currency' => 'USD', 'bedrooms' => 4, 'bathrooms' => 3, 'floor' => 2, 'area' => 260, 'furnished' => false, 'reward_available' => false, 'media' => ['images/properties/property-3.jpg', 'images/properties/property-4.jpg']],
            ['title' => 'بيت مستقل في المزة', 'description' => 'موقع هادئ وملائم للعائلات الباحثة عن مساحة.', 'city' => 'Damascus', 'neighborhood' => 'المزة', 'address' => 'حي روضة', 'purpose' => 'rent', 'category' => 'residential', 'price' => 650, 'currency' => 'USD', 'bedrooms' => 3, 'bathrooms' => 2, 'floor' => 2, 'area' => 170, 'furnished' => true, 'reward_available' => true, 'media' => ['images/properties/property-4.jpg', 'images/properties/property-5.jpg']],
            ['title' => 'أرض تجارية في حمص', 'description' => 'أرض مناسبة للاستثمار التجاري في قلب المدينة.', 'city' => 'Homs', 'neighborhood' => 'وسط المدينة', 'address' => 'شارع الميدان', 'purpose' => 'sale', 'category' => 'commercial', 'price' => 245000, 'currency' => 'USD', 'area' => 320, 'furnished' => false, 'reward_available' => false, 'media' => ['images/properties/property-5.jpg', 'images/properties/property-6.jpg']],
            ['title' => 'شقة حديثة في اللاذقية', 'description' => 'واجهة واسعة وإضاءة ممتازة مع مطبخ مكشوف.', 'city' => 'Latakia', 'neighborhood' => 'الحديقة', 'address' => 'امتداد البحر', 'purpose' => 'rent', 'category' => 'residential', 'price' => 560, 'currency' => 'USD', 'bedrooms' => 2, 'bathrooms' => 2, 'floor' => 6, 'area' => 130, 'furnished' => true, 'reward_available' => false, 'media' => ['images/properties/property-6.jpg', 'images/properties/property-7.jpg']],
            ['title' => 'منزل ثنائي الطابق في حلب', 'description' => 'تصميم كلاسيكي مع غرف واسعة وباحة خضراء.', 'city' => 'Aleppo', 'neighborhood' => 'الشيخ سعد', 'address' => 'الطريق الدولي', 'purpose' => 'sale', 'category' => 'residential', 'price' => 275000, 'currency' => 'USD', 'bedrooms' => 5, 'bathrooms' => 3, 'floor' => 2, 'area' => 300, 'furnished' => false, 'reward_available' => true, 'media' => ['images/properties/property-7.jpg', 'images/properties/property-8.jpg']],
            ['title' => 'مطعم جاهز في ريف دمشق', 'description' => 'موقع مميز مع تجهيزات كاملة وواجهة عرض.', 'city' => 'Damascus', 'neighborhood' => 'المنطقة الصناعية', 'address' => 'طريق المطار', 'purpose' => 'sale', 'category' => 'commercial', 'price' => 165000, 'currency' => 'USD', 'area' => 210, 'furnished' => true, 'reward_available' => false, 'media' => ['images/properties/property-8.jpg', 'images/properties/property-9.jpg']],
            ['title' => 'جناح فاخر في دمشق', 'description' => 'موقع هادئ ومناسب للعائلات مع تجهيز داخلي أنيق.', 'city' => 'Damascus', 'neighborhood' => 'التل', 'address' => 'حي الروضة', 'purpose' => 'rent', 'category' => 'residential', 'price' => 760, 'currency' => 'USD', 'bedrooms' => 3, 'bathrooms' => 2, 'floor' => 5, 'area' => 180, 'furnished' => true, 'reward_available' => true, 'media' => ['images/properties/property-9.jpg', 'images/properties/property-10.jpg']],
            ['title' => 'بيت بواجهة أنيقة في جرمانا', 'description' => 'بيت عصري بانسجام بين المساحات الخضراء والطابع المعماري.', 'city' => 'Jaramana', 'neighborhood' => 'الحدائق', 'address' => 'الشارع الرئيسي', 'purpose' => 'sale', 'category' => 'residential', 'price' => 320000, 'currency' => 'USD', 'bedrooms' => 4, 'bathrooms' => 3, 'floor' => 2, 'area' => 240, 'furnished' => false, 'reward_available' => false, 'media' => ['images/properties/property-10.jpg', 'images/properties/property-1.jpg']],
        ];

        foreach ($propertySeed as $propertyData) {
            \App\Models\Property::updateOrCreate(
                ['title' => $propertyData['title']],
                [
                    'user_id' => $owner->id,
                    'description' => $propertyData['description'],
                    'city' => $propertyData['city'],
                    'neighborhood' => $propertyData['neighborhood'],
                    'address' => $propertyData['address'],
                    'purpose' => $propertyData['purpose'],
                    'category' => $propertyData['category'],
                    'price' => $propertyData['price'],
                    'currency' => $propertyData['currency'],
                    'bedrooms' => $propertyData['bedrooms'] ?? null,
                    'bathrooms' => $propertyData['bathrooms'] ?? null,
                    'floor' => $propertyData['floor'] ?? null,
                    'area' => $propertyData['area'] ?? null,
                    'furnished' => $propertyData['furnished'],
                    'reward_available' => $propertyData['reward_available'],
                    'media' => $propertyData['media'],
                    'status' => 'published',
                    'last_confirmed_at' => now(),
                    'published_at' => now(),
                ]
            );
        }

        $shop = \App\Models\Property::where('title', 'محل تجاري في دمشق')->first(); $flat = \App\Models\Property::where('title', 'شقة مضيئة في جرمانا')->first();
        \App\Models\Subscription::updateOrCreate(['sham_cash_reference'=>'DEMO-SHAM-001'],['user_id'=>$owner->id,'plan'=>'monthly','amount'=>10,'status'=>'approved','starts_at'=>now()->subDays(8),'ends_at'=>now()->addDays(22)]);
        \App\Models\Subscription::updateOrCreate(['sham_cash_reference'=>'DEMO-SHAM-002'],['user_id'=>$owner->id,'plan'=>'monthly','amount'=>10,'status'=>'pending']);
        \App\Models\Report::updateOrCreate(['property_id'=>$shop->id,'type'=>'old'],['reporter_id'=>$renter->id,'details'=>'يرجى التأكد من استمرار توفر المحل.', 'status'=>'open']);
        \App\Models\Report::updateOrCreate(['property_id'=>$flat->id,'type'=>'suspicious'],['reporter_id'=>$renter->id,'details'=>'الوصف يحتاج إلى مراجعة من فريق الإدارة.', 'status'=>'open']);
    }
}
