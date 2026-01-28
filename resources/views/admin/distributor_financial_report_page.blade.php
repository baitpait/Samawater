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
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
        }

        .header-icon-wrapper i {
            font-size: 24px !important;
            color: #fff !important;
        }

        /* Balance Card */
        .balance-card {
            background: var(--success-gradient) !important;
            border-radius: 20px !important;
            padding: 2rem !important;
            box-shadow: var(--shadow-sm) !important;
            margin-bottom: 2rem !important;
        }

        .balance-card h3 {
            color: #fff !important;
            font-size: 32px !important;
            font-weight: 700 !important;
            margin: 0 !important;
        }

        .balance-card p {
            color: rgba(255, 255, 255, 0.9) !important;
            font-size: 16px !important;
            font-weight: 600 !important;
            margin: 0 0 0.5rem 0 !important;
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
        
        .btn-print-unified {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 700 !important;
            transition: all 0.2s ease !important;
            box-shadow: var(--shadow-sm) !important;
        }

        .btn-print-unified:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            transform: translateY(-2px) !important;
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

        @media print {
            body * { visibility: hidden !important; }
            #print-area, #print-area * { visibility: visible !important; }
            #print-area { position: absolute; left: 0; top: 0; width: 100%; }
            .no-print { display: none !important; }
            .card { box-shadow: none !important; border: 1px solid #ccc !important; }
            .balance-card { background: #f0f0f0 !important; }
        }
    </style>
@endsection

@section('header')
    <section class="header-operation-unified">
        <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div class="header-icon-wrapper">
                    <i class="la la-file-invoice-dollar"></i>
                </div>
                <h1 style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);">
                    التقرير المالي للموزع
                </h1>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <a href="{{ backpack_url('distributor') }}" class="btn btn-back-unified no-print">
                    <i class="la la-angle-double-right"></i> العودة للقائمة
                </a>
                <button onclick="window.print()" class="btn btn-print-unified no-print">
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
                    <i class="la la-user-tie"></i> {{ $entry->name }}
                </h3>
            </div>
        </div>

        {{-- Balance Card --}}
        <div class="balance-card">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p>الرصيد الحالي المستحق</p>
                    <h3>{{ number_format($entry->balance, 2) }} ₪</h3>
                </div>
                <div style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                    <i class="la la-wallet" style="font-size: 36px; color: #fff;"></i>
                </div>
            </div>
        </div>

        {{-- Withdraws Table --}}
        <div class="card">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-4 text-primary-deep d-flex align-items-center gap-2">
                    <i class="la la-history"></i> سجل السحوبات المالية
                </h4>
                
                <div class="table-responsive">
                    <table class="table table-clean align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th style="width: 150px;">التاريخ</th>
                                <th style="width: 150px;">المبلغ</th>
                                <th>ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($entry->cashWithdraws as $withdraw)
                                <tr>
                                    <td class="text-center text-primary-deep fw-bold">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $withdraw->created_at->format('Y-m-d') }}</td>
                                    <td class="text-center fw-bold">₪ {{ number_format($withdraw->total_amount, 2) }}</td>
                                    <td class="text-right">{{ $withdraw->notes ?: '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="la la-inbox d-block mb-2" style="font-size: 40px;"></i>
                                        لا توجد سحوبات مسجلة
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($entry->cashWithdraws->count())
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-start fw-bold">إجمالي السحوبات</td>
                                    <td class="text-center fw-bold text-primary-deep" style="font-size: 18px;">
                                        ₪ {{ number_format($entry->cashWithdraws->sum('total_amount'), 2) }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
