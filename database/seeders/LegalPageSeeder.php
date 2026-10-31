<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\LegalPage;
use App\Models\LegalPageTranslation;
use Illuminate\Database\Seeder;

class LegalPageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            'terms-of-use' => [
                'sort_order' => 10,
                'ar' => [
                    'title' => 'الشروط والأحكام',
                    'content' => <<<'TEXT'
آخر تحديث: 31 أكتوبر 2026

باستخدام موقع دارك أو إنشاء حساب فيه، فإنك توافق على هذه الشروط. إذا لم توافق عليها، يرجى عدم استخدام الموقع.

1. دور المنصة
دارك منصة تقنية لعرض العقارات وتسهيل التواصل المباشر بين المالكين والباحثين عن عقار. المنصة ليست طرفًا في أي تفاوض أو عقد إيجار أو بيع، ولا تستلم الإيجارات أو العربون أو المكافآت، ولا تضمن إتمام أي صفقة أو استمرار توفر أي عقار.

2. الحسابات والبيانات
يجب تقديم معلومات صحيحة ومحدثة والمحافظة على سرية بيانات الدخول. أنت مسؤول عن الأنشطة التي تتم باستخدام حسابك، ويجب إبلاغ إدارة الموقع عند الاشتباه باستخدام غير مصرح به. يجب أن يكون استخدام الحساب قانونيًا وألا تنتحل صفة شخص آخر.

3. الإعلانات والتواصل
يتحمل ناشر الإعلان مسؤولية دقة المعلومات والصور والأسعار والموقع وامتلاكه الحق في نشرها. على المستخدمين التحقق بصورة مستقلة من هوية الطرف الآخر وملكية العقار وحالته وشروط الصفقة قبل الدفع أو التوقيع. لا ترسل أموالًا أو مستندات حساسة استجابةً لطلب غير موثوق.

4. السلوك المقبول
يُحظر نشر معلومات مضللة أو غير قانونية أو منتهكة لحقوق الغير، أو إساءة استخدام بيانات التواصل، أو المضايقة أو الاحتيال أو محاولة تعطيل الموقع. يمكن للإدارة مراجعة البلاغات واتخاذ إجراءات مناسبة، بما فيها تقييد الحساب أو إزالة المحتوى، مع مراعاة القوانين السارية.

5. توفر الخدمة والمحتوى
قد تتغير بعض ميزات الموقع أو تتوقف مؤقتًا للصيانة. لا نضمن خلو الإعلانات أو المحتوى من الأخطاء، ولا نتحمل مسؤولية الاتفاقات أو الخسائر الناشئة عن تعامل مباشر بين المستخدمين، بالقدر الذي يسمح به القانون.

6. التعديلات والقانون
قد تُحدّث هذه الشروط بنشر النسخة المعدلة هنا. تسري القوانين واجبة التطبيق على استخدام الموقع، وتخضع هذه الشروط للمراجعة القانونية المحلية قبل اعتمادها النهائي.
TEXT,
                ],
                'en' => [
                    'title' => 'Terms and Conditions',
                    'content' => <<<'TEXT'
Last updated: 31 October 2026

By using Dark or creating an account, you agree to these terms. Do not use the website if you do not agree.

1. The platform’s role
Dark is a technology platform for property listings and direct communication between property owners and people seeking property. The platform is not a party to negotiations, rental or sale agreements, does not collect rent, deposits or rewards, and does not guarantee that a transaction will be completed or that a listing remains available.

2. Accounts and information
Provide accurate, current information and keep your sign-in details secure. You are responsible for activity through your account and should notify the site administrator if you suspect unauthorized use. Accounts must be used lawfully and may not impersonate another person.

3. Listings and communication
Listing publishers are responsible for the accuracy of listing information, images, prices and location, and for having the right to publish them. Users should independently verify the other party’s identity, property ownership, condition and transaction terms before paying or signing. Do not send money or sensitive documents in response to an untrusted request.

4. Acceptable conduct
Do not publish misleading or unlawful information or content that infringes others’ rights; misuse contact details; harass or defraud others; or attempt to disrupt the website. The administrator may review reports and take appropriate action, including restricting an account or removing content, subject to applicable law.

5. Service and content availability
Features may change or be temporarily unavailable for maintenance. We do not guarantee that listings or other content are error-free and, to the extent permitted by law, are not responsible for agreements or losses arising from direct dealings between users.

6. Changes and applicable law
These terms may be updated by publishing a revised version here. Applicable law governs use of the website. Obtain local legal review before adopting these terms as final.
TEXT,
                ],
            ],
            'privacy-policy' => [
                'sort_order' => 20,
                'ar' => [
                    'title' => 'سياسة الخصوصية',
                    'content' => <<<'TEXT'
آخر تحديث: 31 أكتوبر 2026

توضح هذه السياسة كيف يتعامل موقع دارك مع البيانات عند استخدام المنصة. ينبغي على الإدارة مراجعة النص وتحديثه بما يطابق الخدمات الفعلية والقوانين واجبة التطبيق قبل اعتماده.

البيانات التي قد نجمعها
قد تشمل البيانات التي تقدمها عند التسجيل أو استخدام المنصة الاسم والبريد الإلكتروني ورقم الهاتف والموقع والصورة الشخصية ومستندات المالك، وبيانات الإعلانات والاستفسارات والشكاوى والمراسلات مع الإدارة. وقد تُعالج بيانات تقنية أساسية مثل معلومات الجلسة ونوع المتصفح وتفضيل اللغة لأغراض تشغيل الموقع وأمنه.

أغراض الاستخدام
نستخدم البيانات لتشغيل الحسابات والإعلانات، وتمكين التواصل المباشر، وإدارة الشكاوى والاشتراكات، وتحسين الخدمة وحمايتها، والرد على طلبات الدعم، والامتثال للالتزامات القانونية عند انطباقها.

المشاركة والحماية
تُعرض معلومات الإعلان التي ينشرها المستخدم للزوار بحسب إعدادات الموقع. قد تُشارك المعلومات اللازمة مع الطرف الذي يبدأ المستخدم التواصل معه، أو مع مزودي الخدمات الذين يساعدون في تشغيل الموقع، أو عند وجود طلب قانوني واجب. لا ترفع مستندات لا ترغب في حفظها لدى المنصة. نستخدم تدابير معقولة للحماية، لكن لا يمكن ضمان أمن النقل والتخزين بصورة مطلقة.

الاحتفاظ والاختيارات
نحتفظ بالبيانات ما دامت لازمة للأغراض المذكورة أو للمتطلبات القانونية والتشغيلية. يمكنك طلب تصحيح بيانات حسابك من صفحة الملف الشخصي، والتواصل مع إدارة الموقع بشأن طلبات الخصوصية أو حذف الحساب. قد يلزم الاحتفاظ ببعض البيانات لفترة لازمة لمعالجة الشكاوى أو الالتزامات القانونية.

ملفات الارتباط والتحديثات
قد يستخدم الموقع ملفات جلسة وملفات لازمة لحفظ تفضيلات مثل اللغة وتشغيل الوظائف الأساسية. يمكن تحديث هذه السياسة بنشر نسخة جديدة هنا. استخدم صفحة التواصل أو بيانات إدارة الموقع المنشورة لطرح الأسئلة المتعلقة بالخصوصية.
TEXT,
                ],
                'en' => [
                    'title' => 'Privacy Policy',
                    'content' => <<<'TEXT'
Last updated: 31 October 2026

This policy describes how Dark handles information when you use the platform. The administrator should review it against actual services and applicable law before adopting it as final.

Information we may collect
Information you provide when registering or using the platform may include your name, email address, phone number, location, profile image and owner documents, as well as listing, inquiry, complaint and support information. Basic technical information, such as session details, browser type and language preference, may be processed to operate and protect the website.

How information is used
We use information to operate accounts and listings, enable direct communication, manage complaints and subscriptions, improve and protect the service, respond to support requests and meet applicable legal obligations.

Sharing and protection
Listing information a user publishes is visible to visitors according to the website’s settings. Information needed to respond to a contact initiated by a user may be shared with the other party. Information may also be shared with service providers supporting the website or where legally required. Do not upload documents you do not want stored by the platform. Reasonable safeguards are used, but absolute security of transmission and storage cannot be guaranteed.

Retention and choices
Information is retained while needed for the purposes above or for legal and operational requirements. You can request corrections through your profile and contact the site administrator about privacy or account deletion requests. Some information may need to be retained to address complaints or legal obligations.

Cookies and updates
The website may use session and necessary cookies to save preferences such as language and to provide core features. This policy may be updated by publishing a new version here. Use the site’s contact page or published administrator contact details for privacy questions.
TEXT,
                ],
            ],
            'cookie-policy' => [
                'sort_order' => 30,
                'ar' => [
                    'title' => 'سياسة ملفات تعريف الارتباط',
                    'content' => <<<'TEXT'
آخر تحديث: 31 أكتوبر 2026

قد يستخدم موقع دارك ملفات تعريف الارتباط وتقنيات تخزين مشابهة لتشغيل الصفحات وتذكر تفضيل اللغة والحفاظ على جلسة تسجيل الدخول وتحسين موثوقية الخدمة.

الملفات الضرورية
تُستخدم ملفات الجلسة والملفات الضرورية لتقديم الوظائف التي يطلبها المستخدم، مثل تسجيل الدخول وحفظ تفضيلات اللغة. قد يؤدي تعطيلها إلى عدم عمل بعض أجزاء الموقع.

إدارة التفضيلات
يمكنك ضبط المتصفح لحظر ملفات الارتباط أو حذفها. قد تختلف خطوات الإدارة بحسب المتصفح، وقد يؤثر الحظر في وظائف الموقع. لا تستخدم المنصة ملفات تحليل أو إعلان خارجية إلا إذا أضافتها الإدارة وأوضحتها في هذه السياسة.

التغييرات
تُحدّث هذه السياسة عند تغيير استخدام الموقع لملفات الارتباط. هذه صياغة أولية، وعلى الإدارة التحقق من تقنيات الموقع الفعلية والمتطلبات القانونية قبل اعتمادها.
TEXT,
                ],
                'en' => [
                    'title' => 'Cookie Policy',
                    'content' => <<<'TEXT'
Last updated: 31 October 2026

Dark may use cookies and similar storage technologies to operate pages, remember your language preference, maintain sign-in sessions and improve service reliability.

Necessary cookies
Session and necessary cookies support features requested by the user, such as sign-in and language preferences. Disabling them may prevent parts of the website from working.

Managing preferences
You can configure your browser to block or delete cookies. The steps vary by browser, and blocking cookies may affect website features. Do not use analytics or advertising cookies from third parties unless the administrator adds them and explains them in this policy.

Changes
This policy will be updated if the website’s use of cookies changes. This is an initial template; the administrator should verify the website’s actual technologies and applicable legal requirements before adopting it.
TEXT,
                ],
            ],
            'platform-disclaimer' => [
                'sort_order' => 40,
                'ar' => [
                    'title' => 'إخلاء المسؤولية',
                    'content' => <<<'TEXT'
آخر تحديث: 31 أكتوبر 2026

دارك منصة تقنية للربط المباشر بين المالكين والباحثين عن عقار، وليست وسيطًا قانونيًا أو عقاريًا في الصفقة وليست طرفًا في العقد بين المستخدمين.

تُنشر بيانات العقارات من المستخدمين، وقد تتغير الأسعار أو التوفر أو التفاصيل. لا تعني إتاحة الإعلان التحقق من الملكية أو الهوية أو الحالة القانونية للعقار، ولا ينبغي اعتبار معلومات الموقع تقييمًا أو نصيحة قانونية أو مالية.

على كل مستخدم التحقق بنفسه من الطرف الآخر والعقار والمستندات والشروط، والاستعانة بمختص مستقل عند الحاجة، قبل تقديم أموال أو توقيع مستندات. لا تستلم المنصة الإيجارات أو العربون أو المكافآت ولا تضمن سدادها أو استردادها أو إتمام المعاملة.

إلى الحد الذي يسمح به القانون، لا تتحمل المنصة مسؤولية أفعال المستخدمين أو الاتفاقات المباشرة بينهم أو عدم دقة محتوى ينشره المستخدم. لا يحد هذا النص من أي حقوق لا يجوز استبعادها بموجب القانون. يجب مراجعة هذا الإخلاء قانونيًا قبل اعتماده.
TEXT,
                ],
                'en' => [
                    'title' => 'Platform Disclaimer',
                    'content' => <<<'TEXT'
Last updated: 31 October 2026

Dark is a technology platform that connects property owners and people seeking property directly. It is not a legal or real estate broker in a transaction and is not a party to contracts between users.

Property information is submitted by users, and prices, availability and details may change. The presence of a listing does not mean that ownership, identity or the legal status of the property has been verified. Website information is not a valuation or legal or financial advice.

Each user should independently verify the other party, property, documents and terms, and seek independent professional advice where appropriate, before transferring money or signing documents. The platform does not collect rent, deposits or rewards and does not guarantee their payment, recovery or completion of a transaction.

To the extent permitted by law, the platform is not responsible for user conduct, direct agreements between users or inaccuracies in user-submitted content. Nothing here excludes rights that cannot be excluded by law. Obtain legal review before adopting this disclaimer.
TEXT,
                ],
            ],
            'subscription-and-payments' => [
                'sort_order' => 45,
                'ar' => [
                    'title' => 'الاشتراكات والمدفوعات',
                    'content' => <<<'TEXT'
آخر تحديث: 31 أكتوبر 2026

توضح هذه الصفحة الخطط التي يوفرها موقع دارك لأصحاب العقارات. يجب مراجعتها عند تغيير الأسعار أو طريقة الدفع.

الخطة الأساسية
قد يحصل المالك المؤهل على خطة أساسية مجانية لمدة شهرين، بحد أقصى عقار واحد، وفق شروط أهلية الحساب والخطة المعروضة في الموقع. لا تُمدد الخطة تلقائيًا.

الخطة المميزة
تُحسب رسوم الخطة المميزة شهريًا بحسب الحد الأقصى للعقارات المختار وسعر العقار الشهري المعروض وقت تقديم الطلب. يجب مراجعة الإجمالي قبل الدفع. لا يجوز للمالك طلب سعة تقل عن عدد عقاراته الحالية.

المراجعة والدفع
يُقدّم طلب الاشتراك مع مرجع عملية الدفع عبر شام كاش، وتراجع الإدارة الطلب يدويًا. يظل الطلب قيد الانتظار ولا تُفعّل السعة الجديدة حتى اعتماد الطلب. إرسال المرجع لا يثبت استلام المبلغ ولا يضمن الموافقة.

التجديد والتواصل
لا يتم التجديد تلقائيًا؛ يلزم تقديم طلب جديد وفق الخطوات والأسعار المعروضة حينها. للأسئلة بشأن عملية أو طلب معلّق، تواصل مع إدارة الموقع مع ذكر مرجع العملية. يجب على الإدارة توضيح أي قواعد إضافية للإلغاء أو الاسترداد قبل تطبيقها وبما لا ينتقص من الحقوق القانونية للمستخدم.
TEXT,
                ],
                'en' => [
                    'title' => 'Subscriptions and Payments',
                    'content' => <<<'TEXT'
Last updated: 31 October 2026

This page describes the plans Dark offers to property owners. Review it whenever prices or payment methods change.

Basic plan
An eligible owner may receive a free basic plan for two months, limited to one property, subject to account and plan eligibility shown on the website. The plan does not renew automatically.

Premium plan
The premium plan is billed monthly based on the selected property capacity and the per-property monthly rate displayed when the request is submitted. Review the total before paying. An owner cannot request capacity below their current property count.

Review and payment
Submit the subscription request with a Sham Cash payment reference for manual administrator review. The request remains pending and the increased capacity is not active until approved. Providing a reference does not establish receipt of funds or guarantee approval.

Renewal and support
Renewal is not automatic; submit a new request under the steps and prices then displayed. Contact the site administrator about a transaction or pending request and include its reference. The administrator should disclose any additional cancellation or refund rules before applying them and without limiting rights provided by law.
TEXT,
                ],
            ],
            'community-and-complaints' => [
                'sort_order' => 50,
                'ar' => [
                    'title' => 'السلوك والشكاوى',
                    'content' => <<<'TEXT'
آخر تحديث: 31 أكتوبر 2026

يجب استخدام دارك باحترام وبما يتوافق مع القوانين. يُحظر الاحتيال وانتحال الهوية والتحرش والتمييز والتهديد ونشر معلومات مضللة أو استخدام بيانات الآخرين دون إذن.

يمكن للمستخدم إرسال شكوى عن مالك أو مستأجر أو بلاغ عن إعلان من خلال الأدوات المتاحة في الموقع. يرجى تقديم معلومات دقيقة وتفاصيل ذات صلة فقط، وتجنب نشر بيانات شخصية غير لازمة. تصل الشكاوى إلى الإدارة للمراجعة، ولا يعني إرسالها ثبوت الادعاء أو ضمان نتيجة أو تعويض.

قد تتواصل الإدارة لطلب معلومات إضافية، وقد تتخذ إجراءً مناسبًا على المحتوى أو الحساب وفقًا لسياسات المنصة والقوانين واجبة التطبيق. لا تستخدم الشكاوى للتهديد أو المضايقة أو تقديم معلومات كاذبة. في حالات الخطر العاجل، تواصل مع الجهات المختصة مباشرة ولا تعتمد على نموذج الشكوى في الموقع.

تتم معالجة بيانات الشكوى لأغراض المراجعة والمتابعة وفق سياسة الخصوصية. هذه السياسة إرشادية ويجب على الإدارة مواءمتها مع إجراءاتها الفعلية والقانون المحلي.
TEXT,
                ],
                'en' => [
                    'title' => 'Community and Complaints Policy',
                    'content' => <<<'TEXT'
Last updated: 31 October 2026

Use Dark respectfully and lawfully. Fraud, impersonation, harassment, discrimination, threats, misleading information and unauthorized use of another person’s contact details are prohibited.

Users may submit a complaint about an owner or renter, or report a listing, using the tools available on the website. Provide accurate, relevant information only and avoid sharing unnecessary personal data. A complaint is sent to the administrator for review; submission does not establish that a claim is true or guarantee an outcome or compensation.

The administrator may request further information and may take appropriate action on content or an account under platform policies and applicable law. Do not use complaints to threaten, harass or submit false information. In an immediate emergency, contact the appropriate authorities directly; do not rely on the website complaint form.

Complaint information is processed for review and follow-up under the Privacy Policy. This policy is a template and should be aligned with the administrator’s actual procedures and local law.
TEXT,
                ],
            ],
        ];

        $languages = Language::all()->keyBy('code');

        foreach ($pages as $slug => $data) {
            $page = LegalPage::firstOrCreate(
                ['slug' => $slug],
                ['is_published' => true, 'sort_order' => $data['sort_order']]
            );

            foreach (['ar', 'en'] as $locale) {
                $language = $languages->get($locale);
                if (! $language) {
                    continue;
                }

                LegalPageTranslation::firstOrCreate(
                    ['legal_page_id' => $page->id, 'language_id' => $language->id],
                    $data[$locale]
                );
            }
        }
    }
}
