@extends('layouts.app')

@section('title', 'تعديل المنتج')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-rizk p-4">
                <h4 class="text-center mb-4" style="color: var(--text-primary);">تعديل المنتج</h4>
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="updateForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- الحقول المخفية المطلوبة -->
                    <input type="hidden" name="is_used" value="{{ $product->is_used ? '1' : '0' }}">
                    
                    <!-- اسم المنتج -->
                    <div class="mb-3">
                        <label for="name" class="form-label" style="color: var(--text-primary);">اسم المنتج *</label>
                        <input type="text" name="name" id="name" class="form-control form-rizk" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <!-- الوصف -->
                    <div class="mb-3">
                        <label for="description" class="form-label" style="color: var(--text-primary);">الوصف *</label>
                        <textarea name="description" id="description" class="form-control form-rizk" rows="5" required>{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <!-- السعر -->
                    <div class="mb-3">
                        <label for="price" class="form-label" style="color: var(--text-primary);">السعر *</label>
                        <input type="number" name="price" id="price" class="form-control form-rizk" step="0.01" value="{{ old('price', $product->price) }}" required>
                        @error('price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <!-- حالة المنتج -->
<div class="mb-3">
    <label for="condition" class="form-label" style="color: var(--text-primary);">حالة المنتج</label>
    <select name="condition" id="condition" class="form-select form-rizk">
        <option value="ممتاز" {{ $product->condition == 'ممتاز' ? 'selected' : '' }}>ممتاز</option>
        <option value="جيد جدا" {{ $product->condition == 'جيد جدا' ? 'selected' : '' }}>جيد جداً</option>
        <option value="جيد" {{ $product->condition == 'جيد' ? 'selected' : '' }}>جيد</option>
        <option value="مقبول" {{ $product->condition == 'مقبول' ? 'selected' : '' }}>مقبول</option>
        <option value="بحال الجديد" {{ $product->condition == 'بحال الجديد' ? 'selected' : '' }}>بحال الجديد</option>
        <option value="new" {{ $product->condition == 'new' ? 'selected' : '' }}>جديد</option>
        <option value="used" {{ $product->condition == 'used' ? 'selected' : '' }}>مستعمل</option>
        <option value="like_new" {{ $product->condition == 'like_new' ? 'selected' : '' }}>مثل الجديد</option>
        <option value="good" {{ $product->condition == 'good' ? 'selected' : '' }}>جيد (إنجليزي)</option>
        <option value="fair" {{ $product->condition == 'fair' ? 'selected' : '' }}>مقبول (إنجليزي)</option>
        <option value="excellent" {{ $product->condition == 'excellent' ? 'selected' : '' }}>ممتاز (إنجليزي)</option>
        <option value="very_good" {{ $product->condition == 'very_good' ? 'selected' : '' }}>جيد جداً (إنجليزي)</option>
        <option value="other" {{ $product->condition == 'other' ? 'selected' : '' }}>أخرى</option>
    </select>
    @error('condition')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
                    
                    <!-- الصور الحالية -->
                    @if($product->images)
                        @php
                            $images = json_decode($product->images, true);
                        @endphp
                        @if(is_array($images) && count($images) > 0)
                            <div class="mb-3">
                                <label class="form-label" style="color: var(--text-primary);">الصور الحالية</label>
                                <div class="row g-2">
                                    @foreach($images as $image)
                                        <div class="col-4">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $image) }}" 
                                                     class="img-thumbnail" 
                                                     style="width: 100%; height: 150px; object-fit: cover;">
                                                <div class="position-absolute top-0 end-0 p-1">
                                                    <button type="button" 
                                                            class="btn btn-danger btn-sm remove-image" 
                                                            data-image="{{ $image }}">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="delete_images" id="delete_images" value="">
                            </div>
                        @endif
                    @endif
                    
                    <!-- إضافة صور جديدة -->
                    <div class="mb-3">
                        <label for="images" class="form-label" style="color: var(--text-primary);">إضافة صور جديدة</label>
                        <input type="file" name="images[]" id="images" class="form-control form-rizk" accept="image/*" multiple>
                        <small class="text-muted">يمكنك اختيار عدة صور في وقت واحد</small>
                    </div>
                    
                    <!-- معاينة الصور الجديدة -->
                    <div id="newImagePreviewSection" style="display: none;" class="mb-3">
                        <label class="form-label" style="color: var(--text-primary);">معاينة الصور الجديدة</label>
                        <div id="newPreviewContainer" class="row g-2"></div>
                    </div>
                    
                    <!-- الأزرار -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-rizk-primary">تحديث المنتج</button>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-rizk-outline">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // معاينة الصور الجديدة
    document.getElementById('images').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('newPreviewContainer');
        const previewSection = document.getElementById('newImagePreviewSection');
        const files = e.target.files;
        
        previewContainer.innerHTML = '';
        
        if (files.length > 0) {
            previewSection.style.display = 'block';
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                
                reader.onload = function(event) {
                    const col = document.createElement('div');
                    col.className = 'col-4';
                    col.innerHTML = `
                        <img src="${event.target.result}" 
                             class="img-thumbnail" 
                             style="width: 100%; height: 150px; object-fit: cover;">
                    `;
                    previewContainer.appendChild(col);
                };
                
                reader.readAsDataURL(file);
            }
        } else {
            previewSection.style.display = 'none';
        }
    });
    
    // حذف الصور الموجودة
    document.querySelectorAll('.remove-image').forEach(button => {
        button.addEventListener('click', function() {
            const image = this.dataset.image;
            const deleteImagesInput = document.getElementById('delete_images');
            const currentValue = deleteImagesInput.value;
            
            if (currentValue) {
                deleteImagesInput.value = currentValue + ',' + image;
            } else {
                deleteImagesInput.value = image;
            }
            
            // إخفاء الصورة المحذوفة
            this.closest('.col-4').style.display = 'none';
        });
    });
</script>
@endsection
