@extends('layouts.app')

@section('title', 'سياسة الخصوصية - Rizk')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white text-center py-4" style="background: #d4af37;">
                    <h2 class="mb-0 fw-bold">سياسة الخصوصية</h2>
                </div>
                <div class="card-body p-5">
                    <p class="text-muted text-center mb-4">آخر تحديث: {{ date('Y-m-d') }}</p>
                    
                    <h5 style="color: #d4af37;">📋 مقدمة</h5>
                    <p>
                        في منصة <strong>Rizk</strong>، نلتزم بحماية خصوصيتك وسرية معلوماتك الشخصية. 
                        توضح هذه السياسة كيفية جمعنا واستخدامنا وحمايتنا لمعلوماتك.
                    </p>
                    
                    <h5 style="color: #d4af37; margin-top: 30px;">🔍 المعلومات التي نجمعها</h5>
                    <ul>
                        <li><strong>معلومات الحساب:</strong> الاسم، البريد الإلكتروني، رقم الهاتف، المدينة</li>
                        <li><strong>معلومات المنتجات والخدمات:</strong> المنتجات التي تبيعها، الخدمات التي تقدمها</li>
                        <li><strong>معلومات التواصل:</strong> الرسائل التي تتبادلها مع المستخدمين الآخرين</li>
                        <li><strong>معلومات الاستخدام:</strong> الصفحات التي تزورها، المنتجات التي تشاهدها</li>
                    </ul>
                    
                    <h5 style="color: #d4af37; margin-top: 30px;">🛡️ كيفية استخدام معلوماتك</h5>
                    <ul>
                        <li>توفير خدمات المنصة الأساسية (البيع، الشراء، الخدمات)</li>
                        <li>تحسين تجربة المستخدم وتطوير المنصة</li>
                        <li>التواصل معك بشأن طلباتك واستفساراتك</li>
                        <li>إرسال إشعارات وتحديثات مهمة</li>
                    </ul>
                    
                    <h5 style="color: #d4af37; margin-top: 30px;">🔒 أمان المعلومات</h5>
                    <p>
                        نستخدم إجراءات أمنية متقدمة لحماية معلوماتك من الوصول غير المصرح به، 
                        التعديل، الكشف، أو التدمير. تشمل هذه الإجراءات:
                    </p>
                    <ul>
                        <li>تشفير البيانات الحساسة</li>
                        <li>استخدام HTTPS لتأمين الاتصال</li>
                        <li>المراقبة المستمرة للأنظمة</li>
                    </ul>
                    
                    <h5 style="color: #d4af37; margin-top: 30px;">📧 مشاركة المعلومات</h5>
                    <p>
                        لا نقوم ببيع أو تأجير أو مشاركة معلوماتك الشخصية مع أطراف ثالثة إلا في الحالات التالية:
                    </p>
                    <ul>
                        <li>عندما تطلب ذلك بشكل صريح</li>
                        <li>عندما يقتضي القانون ذلك</li>
                        <li>لحماية حقوقنا وممتلكاتنا</li>
                    </ul>
                    
                    <h5 style="color: #d4af37; margin-top: 30px;">🍪 ملفات تعريف الارتباط (Cookies)</h5>
                    <p>
                        نستخدم ملفات تعريف الارتباط لتحسين تجربتك على المنصة، مثل تذكر تفضيلاتك 
                        والحفاظ على حالة تسجيل الدخول.
                    </p>
                    
                    <h5 style="color: #d4af37; margin-top: 30px;">✉️ التواصل معنا</h5>
                    <p>
                        إذا كان لديك أي أسئلة أو استفسارات حول سياسة الخصوصية، يمكنك التواصل معنا عبر:
                    </p>
                    <ul>
                        <li><strong>البريد الإلكتروني:</strong> <a href="mailto:mastersniper823@gmail.com" style="color: #d4af37;">mastersniper823@gmail.com</a></li>
                        <li><strong>الهاتف:</strong> <a href="tel:+963939128784" style="color: #d4af37;">+963 939 128 784</a></li>
                    </ul>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted small">باستخدامك لمنصة Rizk، فإنك توافق على سياسة الخصوصية هذه.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
