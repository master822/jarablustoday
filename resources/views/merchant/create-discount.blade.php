@extends('layouts.app')

@section('title', 'إضافة تخفيض')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-rizk p-4">
                <h5 style="color: var(--text-primary);">إضافة تخفيض جديد</h5>
                <form action="{{ route('merchant.discounts.store') }}" method="POST">
                    @csrf
                    
                    <!-- اختيار المنتج -->
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">اختر المنتج *</label>
                        <select name="product_id" id="product_id" class="form-select form-rizk" required>
                            <option value="">-- اختر المنتج --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                        data-name="{{ $product->name }}"
                                        data-description="{{ $product->description }}"
                                        data-price="{{ $product->price }}"
                                        data-condition="{{ $product->condition }}">
                                    {{ $product->name }} - {{ number_format($product->price, 2) }} TL
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- معلومات المنتج (تتعبأ تلقائياً) -->
                    <div id="productInfo" class="card-rizk p-3 mb-3" style="display: none; background: var(--bg-body); border: 1px solid rgba(212, 175, 55, 0.1);">
                        <div class="row">
                            <div class="col-6">
                                <small style="color: var(--text-muted);">اسم المنتج</small>
                                <p id="display_name" style="color: var(--text-primary); font-weight: 600;"></p>
                            </div>
                            <div class="col-6">
                                <small style="color: var(--text-muted);">السعر</small>
                                <p id="display_price" style="color: var(--text-primary); font-weight: 600;"></p>
                            </div>
                            <div class="col-6">
                                <small style="color: var(--text-muted);">نوع المنتج</small>
                                <p id="display_condition" style="color: var(--text-primary); font-weight: 600;"></p>
                            </div>
                            <div class="col-12">
                                <small style="color: var(--text-muted);">الوصف</small>
                                <p id="display_description" style="color: var(--text-primary);"></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- اسم التخفيض -->
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">اسم التخفيض *</label>
                        <input type="text" name="name" class="form-control form-rizk" required>
                    </div>
                    
                    <!-- وصف التخفيض -->
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">وصف التخفيض</label>
                        <textarea name="description" class="form-control form-rizk" rows="3"></textarea>
                    </div>
                    
                    <!-- نسبة التخفيض -->
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">نسبة التخفيض *</label>
                        <input type="number" name="percentage" class="form-control form-rizk" min="1" max="100" required>
                    </div>
                    
                    <button type="submit" class="btn btn-rizk-primary w-100">إضافة التخفيض</button>
                    <a href="{{ route('merchant.discounts') }}" class="btn btn-rizk-outline w-100 mt-2">إلغاء</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('product_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const productInfo = document.getElementById('productInfo');
        
        if (this.value) {
            productInfo.style.display = 'block';
            document.getElementById('display_name').textContent = selectedOption.dataset.name || '-';
            document.getElementById('display_description').textContent = selectedOption.dataset.description || '-';
            document.getElementById('display_price').textContent = selectedOption.dataset.price ? 
                parseFloat(selectedOption.dataset.price).toFixed(2) + ' TL' : '-';
            
            const conditionMap = {
                'new': 'جديد',
                'used': 'مستعمل',
                'like_new': 'مثل الجديد',
                'good': 'جيد',
                'fair': 'مقبول',
                'other': 'أخرى'
            };
            document.getElementById('display_condition').textContent = conditionMap[selectedOption.dataset.condition] || selectedOption.dataset.condition || '-';
        } else {
            productInfo.style.display = 'none';
        }
    });
</script>
@endsection
