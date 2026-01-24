@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
@endsection

@extends(backpack_view('blank'))

@section('content')
<div class="container-fluid pb-4">

    {{-- ===============================
        Header - Unified Design
    =============================== --}}
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header">
        <div class="header-content-wrapper" style="display: flex; align-items: center; gap: 1rem; width: 100%; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <h1 class="text-capitalize mb-0" bp-section="page-heading">تفاصيل المشترك</h1>
            </div>
            <div class="page-header-actions">
                <a href="{{ url()->previous() }}" class="btn btn-light" style="background: rgba(255, 255, 255, 0.2); color: #fff; border: 1px solid rgba(255, 255, 255, 0.3);">
                    <i class="la la-arrow-right"></i>
                    رجوع
                </a>
            </div>
        </div>
    </section>

    {{-- Unified Header CSS --}}
    <style>
        section.header-operation {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
            border-radius: 20px !important;
            padding: 1.5rem 2rem !important;
            margin-bottom: 2rem !important;
            box-shadow: 0 10px 30px rgba(111, 106, 248, 0.3) !important;
            position: relative !important;
            overflow: hidden !important;
        }

        section.header-operation::before {
            content: '' !important;
            position: absolute !important;
            top: -50% !important;
            right: -50% !important;
            width: 200% !important;
            height: 200% !important;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%) !important;
            animation: pulse 3s ease-in-out infinite !important;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 0.8; }
        }

        section.header-operation h1 {
            color: #fff !important;
            font-size: 24px !important;
            font-weight: 700 !important;
            margin: 0 !important;
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
            position: relative !important;
            z-index: 1 !important;
        }

        section.header-operation .page-header-actions .btn {
            height: 42px !important;
            border-radius: 12px !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            padding: 0 18px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            transition: all 0.2s ease !important;
            position: relative !important;
            z-index: 1 !important;
        }

        section.header-operation .page-header-actions .btn:hover {
            background: rgba(255, 255, 255, 0.3) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.2) !important;
        }
    </style>

    {{-- ===============================
        Client Info Card
    =============================== --}}
    <div class="card filter-card mb-4">
        <div class="card-body">
            <div class="row g-4">

                {{-- اسم المشترك --}}
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">اسم المشترك</label>
                    <div class="fw-bold" style="color: #1f2937; font-size: 16px;">{{ $client->name ?? $row->client_name }}</div>
                </div>

                {{-- رقم العقد --}}
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">رقم العقد</label>
                    <div style="color: #6f6af8; font-weight: 600; font-size: 15px;">{{ $client->contract_no ?? $row->contract_no }}</div>
                </div>

                {{-- نوع المشترك --}}
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">نوع المشترك</label>
                    <div>
                        @php
                            $clientTypeMap = [
                                1 => 'فردي',
                                2 => 'مؤسسة',
                                3 => 'تجاري'
                            ];
                            $clientType = $client->client_type ?? null;
                        @endphp
                        @if($clientType && isset($clientTypeMap[$clientType]))
                            <span class="badge badge-soft-purple">{{ $clientTypeMap[$clientType] }}</span>
                        @else
                            <span>-</span>
                        @endif
                    </div>
                </div>

                {{-- المدينة --}}
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">المدينة</label>
                    <div style="color: #374151; font-size: 15px;">{{ $client->city->city_name ?? $row->city_name ?? '-' }}</div>
                </div>

                {{-- العنوان --}}
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">العنوان</label>
                    <div style="color: #374151; font-size: 15px;">{{ $client->address ?? '-' }}</div>
                </div>

                {{-- تاريخ بدء الاشتراك --}}
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">تاريخ بدء الاشتراك</label>
                    <div style="color: #374151; font-size: 15px;">{{ $client->subscription_start_date ? \Carbon\Carbon::parse($client->subscription_start_date)->format('Y-m-d') : '-' }}</div>
                </div>

                {{-- الهاتف الأول --}}
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">رقم الهاتف الأول</label>
                    @if(!empty($client->phone_one ?? $row->phone_one))
                        <div style="color: #374151; font-size: 15px; font-weight: 500;">
                            <i class="la la-phone" style="margin-left: 5px;"></i>
                            {{ $client->phone_one ?? $row->phone_one }}
                        </div>
                    @else
                        <div style="color: #9ca3af;">-</div>
                    @endif
                </div>

                {{-- الهاتف الثاني --}}
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">رقم الهاتف الثاني</label>
                    @if(!empty($client->phone_two ?? $row->phone_two))
                        <div style="color: #374151; font-size: 15px; font-weight: 500;">
                            <i class="la la-phone" style="margin-left: 5px;"></i>
                            {{ $client->phone_two ?? $row->phone_two }}
                        </div>
                    @else
                        <div style="color: #9ca3af;">-</div>
                    @endif
                </div>

                {{-- نوع الاشتراك --}}
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">نوع الاشتراك</label>
                    <div>
                        <span class="badge badge-soft-purple">
                            {{ $client->subscriptionType->type_name ?? $row->subscription_type_name ?? '-' }}
                        </span>
                    </div>
                </div>

                {{-- حالة الاشتراك --}}
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">حالة الاشتراك</label>
                    <div>
                        <span class="badge badge-success-custom">
                            {{ $client->subscriptionStatus->status_name ?? $row->subscription_status_name ?? '-' }}
                        </span>
                    </div>
                </div>

                {{-- ملاحظات --}}
                @if(!empty($client->notes))
                <div class="col-12">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">ملاحظات</label>
                    <div style="color: #374151; font-size: 14px; background: #f9fafb; padding: 12px; border-radius: 10px; border-right: 3px solid #6f6af8;">
                        {{ $client->notes }}
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>

    {{-- ===============================
        Delivery Info Card
    =============================== --}}
    <div class="card filter-card mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-4" style="color: #1f2937; font-size: 18px;">معلومات التسليم</h5>
            
            <div class="row g-4">

                {{-- آخر تسليم --}}
                <div class="col-md-3">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">تاريخ آخر تسليم</label>
                    <div class="fw-bold" style="color: #6f6af8; font-size: 15px;">{{ $row->last_delivery_date ?? '-' }}</div>
                </div>

                {{-- عدد التسليمات --}}
                <div class="col-md-3">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">عدد التسليمات</label>
                    <div style="color: #374151; font-size: 15px; font-weight: 600;">{{ $row->total_deliveries ?? 0 }}</div>
                </div>

                {{-- أيام بدون تسليم --}}
                <div class="col-md-3">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">أيام بدون تسليم</label>
                    <div class="fw-bold" style="color: #ef4444; font-size: 15px;">
                        {{ $row->days_since_last_delivery ?? 0 }} يوم
                    </div>
                </div>

                {{-- نسبة الالتزام --}}
                <div class="col-md-3">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">نسبة الالتزام</label>
                    <div>
                        <span class="badge
                            {{ ($row->percentage_delivery_rate ?? 0) < 50 ? 'badge-danger-custom' : (($row->percentage_delivery_rate ?? 0) < 75 ? 'badge-warning-custom' : 'badge-success-custom') }}">
                            {{ number_format($row->percentage_delivery_rate ?? 0, 2) }}%
                        </span>
                    </div>
                </div>

            </div>

            {{-- معلومات آخر تسليم --}}
            @if($lastDelivery)
            <div class="mt-4 pt-4" style="border-top: 2px solid #e5e7eb;">
                <h6 class="fw-bold mb-3" style="color: #6f6af8; font-size: 16px;">
                    <i class="la la-info-circle"></i> تفاصيل آخر تسليم
                </h6>
                <div class="row g-4">
                    <div class="col-md-3">
                        <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">القوارير المستلمة</label>
                        <div style="color: #22c55e; font-size: 15px; font-weight: 600;">
                            <i class="la la-arrow-down"></i> {{ $lastDelivery->bottle_received ?? 0 }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">القوارير الفارغة</label>
                        <div style="color: #ef4444; font-size: 15px; font-weight: 600;">
                            <i class="la la-arrow-up"></i> {{ $lastDelivery->bottle_empty ?? 0 }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">المبلغ المدفوع</label>
                        <div style="color: #6f6af8; font-size: 15px; font-weight: 600;">
                            <i class="la la-money"></i> {{ number_format($lastDelivery->paymant ?? 0, 2) }} ₪
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">الموزع</label>
                        <div style="color: #374151; font-size: 15px;">
                            {{ $lastDelivery->distributor->name ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- ===============================
        Recent Deliveries Table
    =============================== --}}
    @if($recentDeliveries && $recentDeliveries->count() > 0)
    <div class="card filter-card mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-4" style="color: #1f2937; font-size: 18px;">
                <i class="la la-history"></i> آخر التسليمات
            </h5>
            
            <div class="table-responsive">
                <table class="table table-clean align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px; border-radius: 12px 12px 0 0;">التاريخ</th>
                            <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">القوارير المستلمة</th>
                            <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">القوارير الفارغة</th>
                            <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">المبلغ المدفوع</th>
                            <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">الموزع</th>
                            <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px; text-align: center; width: 100px;">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentDeliveries as $delivery)
                        <tr style="background: #fcfdff; box-shadow: 0 4px 12px rgba(0,0,0,.06); border-radius: 12px; margin-bottom: 8px;">
                            <td style="padding: 12px; color: #374151; font-weight: 600;">
                                {{ \Carbon\Carbon::parse($delivery->delivery_date)->format('Y-m-d') }}
                            </td>
                            <td style="padding: 12px; color: #22c55e; font-weight: 600;">
                                <i class="la la-arrow-down"></i> {{ $delivery->bottle_received ?? 0 }}
                            </td>
                            <td style="padding: 12px; color: #ef4444; font-weight: 600;">
                                <i class="la la-arrow-up"></i> {{ $delivery->bottle_empty ?? 0 }}
                            </td>
                            <td style="padding: 12px; color: #6f6af8; font-weight: 600;">
                                <i class="la la-money"></i> {{ number_format($delivery->paymant ?? 0, 2) }} ₪
                            </td>
                            <td style="padding: 12px; color: #374151;">
                                {{ $delivery->distributor->name ?? '-' }}
                            </td>
                            <td style="padding: 12px; text-align: center;">
                                <a href="{{ url(config('backpack.base.route_prefix') . '/delivery/' . $delivery->id . '/edit') }}" 
                                   class="btn btn-sm btn-primary" 
                                   style="background: linear-gradient(135deg, #7d5bff 0%, #6f6af8 100%); border: none; border-radius: 10px; padding: 6px 16px; font-weight: 600; box-shadow: 0 2px 8px rgba(111, 106, 248, 0.3); transition: all 0.2s ease;"
                                   title="تعديل التسليم">
                                    <i class="la la-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection

@push('after_styles')
<style>
    /* ===============================
       Page Styles
    =============================== */
    .container-fluid {
        max-width: 1200px;
    }

    /* ===============================
       Cards
    =============================== */
    .filter-card {
        background: #fcfdff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.06);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .filter-card .card-body {
        padding: 1.5rem;
    }

    /* ===============================
       Form Labels
    =============================== */
    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #55607b;
        margin-bottom: 8px;
        display: block;
        font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* ===============================
       Badges
    =============================== */
    .badge {
        border-radius: 12px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-soft-purple {
        background: linear-gradient(135deg, #f5f3ff, #ede9fe);
        color: #6f6af8;
        border: 1px solid rgba(111, 106, 248, 0.2);
    }

    .badge-success-custom {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        color: #22c55e;
        border: 1px solid rgba(34, 197, 94, 0.2);
    }

    .badge-warning-custom {
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .badge-danger-custom {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    /* ===============================
       Table Styles
    =============================== */
    .table-clean {
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    .table-clean thead th {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9) !important;
        border: none !important;
        font-weight: 700;
        color: #374151;
        padding: 12px;
        text-align: right;
    }

    .table-clean tbody tr {
        background: #fcfdff;
        box-shadow: 0 4px 12px rgba(0,0,0,.06);
        border-radius: 12px;
        margin-bottom: 8px;
    }

    .table-clean tbody td {
        border: none;
        padding: 12px;
        vertical-align: middle;
    }

    .table-clean tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,.1);
        transition: all 0.2s ease;
    }

    .table-clean tbody .btn {
        transition: all 0.2s ease;
    }

    .table-clean tbody .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(111, 106, 248, 0.4) !important;
    }
</style>
@endpush
