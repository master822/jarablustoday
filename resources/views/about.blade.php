@extends('layouts.app')

@section('title', 'عن الموقع - Rizk')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white text-center py-4" style="background: #d4af37;">
                    <h2 class="mb-0 fw-bold">عن منصة Rizk</h2>
                </div>
                <div class="card-body p-5">
                    <h4 style="color: #d4af37;">🌟 منصتك الشاملة</h4>
                    <p>
                        <strong>Rizk</strong> هي منصة إلكترونية متكاملة تهدف إلى ربط البائعين والمشترين ومقدمي الخدمات في مكان واحد.
                    </p>
                    
                    <h5 style="color: #d4af37; margin-top: 30px;">🎯 رؤيتنا</h5>
                    <p>
                        نهدف إلى خلق بيئة تجارية آمنة وموثوقة تسهل عملية البيع والشراء والاستفادة من الخدمات المختلفة، 
                        مع التركيز على تقديم تجربة مستخدم مميزة تلبي احتياجات جميع الأطراف.
                    </p>
                    
                    <h5 style="color: #d4af37; margin-top: 30px;">💡 ما نقدمه</h5>
                    <ul>
                        <li><strong>🛍️ المنتجات:</strong> بيع وشراء المنتجات الجديدة والمستعملة</li>
                        <li><strong>🛠️ الخدمات:</strong> تقديم وطلب الخدمات المختلفة</li>
                        <li><strong>💼 فرص العمل:</strong> نشر فرص العمل والتواصل مع الباحثين</li>
                        <li><strong>🏷️ التخفيضات:</strong> عروض وتخفيضات خاصة من التجار</li>
                        <li><strong>📱 التواصل:</strong> نظام رسائل متكامل للتواصل بين المستخدمين</li>
                    </ul>
                    
                    <h5 style="color: #d4af37; margin-top: 30px;">👥 لمن هذه المنصة؟</h5>
                    <ul>
                        <li><strong>المستخدم العادي:</strong> تصفح وشراء المنتجات، إضافة منتجات مستعملة</li>
                        <li><strong>التاجر:</strong> إدارة متجرك، إضافة منتجات جديدة، إنشاء تخفيضات</li>
                        <li><strong>مقدم الخدمات:</strong> عرض خدماتك، إدارة فرص العمل</li>
                        <li><strong>المسؤول:</strong> إدارة المنصة والإشراف على جميع العمليات</li>
                    </ul>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('register') }}" class="btn text-white" style="background: #d4af37; padding: 12px 40px; border-radius: 10px;">
                            انضم إلينا الآن
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
