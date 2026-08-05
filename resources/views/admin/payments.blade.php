@extends('layouts.app')

@section('title', 'طلبات الدفع')

@section('content')
<div class="container py-4">
    <h4 class="section-title-rizk">💰 طلبات الدفع</h4>
    
    <div class="card-rizk p-3">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المستخدم</th>
                        <th>الباقة</th>
                        <th>المبلغ</th>
                        <th>إثبات الدفع</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->user->name ?? 'غير معروف' }}</td>
                            <td>{{ $payment->plan == 'medium' ? 'متوسطة' : 'ذهبية' }}</td>
                            <td>${{ number_format($payment->amount, 2) }}</td>
                            <td>
                                @if($payment->payment_proof)
                                    <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $payment->status == 'approved' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ $payment->status }}
                                </span>
                            </td>
                            <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                            <td>
                                @if($payment->status == 'pending')
                                    <form action="{{ route('admin.payment.approve', $payment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.payment.reject', $payment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">لا توجد طلبات دفع</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $payments->links() }}
    </div>
</div>
@endsection
