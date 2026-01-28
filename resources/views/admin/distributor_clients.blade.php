@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
    
    <style>
        /* ============================================
           Unified Header Design
           ============================================ */
        section.header-operation-unified {
            background: var(--primary-deep) !important;
            border-radius: 20px !important;
            padding: 1.5rem 2rem !important;
            margin-bottom: 2rem !important;
            box-shadow: var(--shadow-md) !important;
            position: relative !important;
            overflow: visible !important;
            width: 100% !important;
            display: block !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
        }

        .header-icon-wrapper {
            width: 56px !important;
            height: 56px !important;
            background: rgba(255, 255, 255, 0.1) !important;
            border-radius: 16px !important;
            display: flex !items-center !important;
            justify-content: center !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
        }

        .header-icon-wrapper i {
            font-size: 24px !important;
            color: #fff !important;
        }

        .btn-back-unified {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 700 !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
        }

        .btn-back-unified:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            transform: translateY(-2px) !important;
            color: #fff !important;
        }

        /* Results Header */
        .results-header-modern {
            background: var(--primary-deep) !important;
            border-radius: 16px !important;
            padding: 1.5rem !important;
            margin-bottom: 1.5rem !important;
            box-shadow: var(--shadow-sm) !important;
            color: #fff !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }

        /* Unified Table Design */
        .table-clean {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            background: #fff !important;
            border-radius: 20px !important;
            overflow: visible !important;
            box-shadow: var(--shadow-md) !important;
        }

        .table-clean thead th {
            background: var(--primary-deep) !important;
            color: #fff !important;
            font-weight: 700 !important;
            padding: 1rem !important;
            border: none !important;
            font-size: 14px !important;
            text-align: center !important;
        }

        .table-clean tbody tr {
            border-bottom: 1px solid #f1f5f9 !important;
            transition: all 0.2s ease !important;
        }

        .table-clean tbody tr:hover {
            background: #f8fafc !important;
        }

        .table-clean tbody td {
            padding: 1rem !important;
            color: #334155 !important;
            font-weight: 600 !important;
            vertical-align: middle !important;
        }

        @media print {
            body * { visibility: hidden !important; }
            #print-area, #print-area * { visibility: visible !important; }
            #print-area { position: absolute; left: 0; top: 0; width: 100%; }
            .no-print { display: none !important; }
            .card { box-shadow: none !important; border: 1px solid #ccc !important; }
        }
    </style>
@endsection

@section('header')
    <section class="header-operation-unified">
        <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div class="header-icon-wrapper">
                    <i class="la la-users"></i>
                </div>
                <h1 style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);">
                    مشتركين الموزع
                </h1>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <a href="{{ backpack_url('distributor') }}" class="btn btn-back-unified no-print">
                    <i class="la la-angle-double-right"></i> العودة للقائمة
                </a>
                <button onclick="window.print()" class="btn btn-back-unified no-print">
                    <i class="la la-print"></i> طباعة
                </button>
            </div>
        </div>
    </section>
@endsection

@section('content')
<div class="container-fluid">
    <div id="print-area">
        {{-- Distributor Name Card --}}
        <div class="card mb-4">
            <div class="card-body text-center p-4">
                <h3 class="fw-bold mb-0 text-primary-deep">
                    <i class="la la-user-tie"></i> {{ $distributor->name }}
                </h3>
            </div>
        </div>

        {{-- Results Header --}}
        <div class="results-header-modern">
            <div class="d-flex align-items-center gap-3">
                <i class="la la-users" style="font-size: 24px;"></i>
                <h5 class="mb-0 fw-bold">إجمالي عدد المشتركين</h5>
            </div>
            <h3 class="mb-0 fw-bold">{{ $clients->total() }}</h3>
        </div>

        {{-- Clients Table --}}
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-clean align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>اسم المشترك</th>
                                <th>الهاتف</th>
                                <th>المدينة</th>
                                <th>تاريخ الاشتراك</th>
                                <th>حالة الاشتراك</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $i => $client)
                                <tr>
                                    <td class="text-center text-primary-deep fw-bold">{{ $clients->firstItem() + $i }}</td>
                                    <td class="ps-4 fw-bold">{{ $client->name }}</td>
                                    <td class="text-center">{{ $client->phone_one ?? '-' }}</td>
                                    <td class="text-center">{{ $client->city->city_name ?? '-' }}</td>
                                    <td class="text-center">{{ $client->subscription_start_date ? \Carbon\Carbon::parse($client->subscription_start_date)->format('Y-m-d') : '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary-deep text-white">
                                            {{ optional($client->subscriptionStatus)->status_name ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">لا يوجد مشتركين مسجلين لهذا الموزع</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-top">
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
