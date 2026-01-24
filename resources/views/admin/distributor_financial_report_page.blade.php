@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
    
    <style>
        /* ============================================
           Unified Header Design
           ============================================ */
        section.header-operation,
        section.header-operation.container-fluid,
        section.header-operation.animated,
        section.header-operation.fadeIn {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
            border-radius: 20px !important;
            padding: 1.5rem 2rem !important;
            margin-bottom: 2rem !important;
            box-shadow: 0 10px 30px rgba(111, 106, 248, 0.3) !important;
            position: relative !important;
            overflow: hidden !important;
            width: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: wrap !important;
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
            0%, 100% {
                opacity: 0.5;
            }
            50% {
                opacity: 0.8;
            }
        }

        section.header-operation h1,
        section.header-operation h1.text-capitalize,
        section.header-operation h1.mb-0 {
            color: #fff !important;
            font-size: 24px !important;
            font-weight: 700 !important;
            margin: 0 !important;
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
            position: relative !important;
            z-index: 1 !important;
            display: flex !important;
            align-items: center !important;
            gap: 1rem !important;
        }

        /* Unified Card Design */
        .filter-card {
            background: #fcfdff !important;
            border-radius: 20px !important;
            border: none !important;
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.06) !important;
            margin-bottom: 1.5rem !important;
        }

        .filter-card .card-body {
            padding: 1.5rem !important;
        }

        /* Balance Card */
        .balance-card {
            background: linear-gradient(135deg, #34d399 0%, #22c55e 100%) !important;
            border-radius: 20px !important;
            padding: 2rem !important;
            box-shadow: 0 10px 30px rgba(34, 211, 153, 0.3) !important;
            margin-bottom: 2rem !important;
        }

        .balance-card h3 {
            color: #fff !important;
            font-size: 32px !important;
            font-weight: 700 !important;
            margin: 0 !important;
            font-family: 'Cairo', sans-serif !important;
        }

        .balance-card p {
            color: rgba(255, 255, 255, 0.9) !important;
            font-size: 16px !important;
            font-weight: 600 !important;
            margin: 0 0 0.5rem 0 !important;
            font-family: 'Cairo', sans-serif !important;
        }

        /* Unified Table Design */
        .table-clean {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            background: #fff !important;
            border-radius: 20px !important;
            overflow: hidden !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06) !important;
        }

        .table-clean thead th {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
            color: #fff !important;
            font-weight: 600 !important;
            padding: 1rem !important;
            border: none !important;
            font-family: 'Cairo', sans-serif !important;
            font-size: 14px !important;
            text-align: center !important;
        }

        .table-clean tbody tr {
            border-bottom: 1px solid #e5e7eb !important;
            transition: all 0.2s ease !important;
        }

        .table-clean tbody tr:hover {
            background: #f7f9ff !important;
        }

        .table-clean tbody td {
            padding: 1rem !important;
            color: #1f2937 !important;
            font-family: 'Cairo', sans-serif !important;
            font-size: 14px !important;
            vertical-align: middle !important;
        }
        
        /* ملاحظات - دعم النصوص الطويلة */
        .table-clean tbody td:last-child {
            text-align: right !important;
            word-wrap: break-word !important;
            word-break: break-word !important;
            white-space: normal !important;
            line-height: 1.6 !important;
            max-width: 400px !important;
        }

        .table-clean tbody tr:last-child td {
            border-bottom: none !important;
        }

        .table-clean tfoot {
            background: #f7f9ff !important;
        }

        .table-clean tfoot td {
            background: #f7f9ff !important;
            font-weight: 700 !important;
            color: #1f2937 !important;
            padding: 1rem !important;
            font-size: 16px !important;
        }

        /* Unified Buttons */
        .btn-print-unified {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
            border: none !important;
            color: #fff !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            font-family: 'Cairo', sans-serif !important;
            transition: all 0.2s ease !important;
            box-shadow: 0 4px 12px rgba(111, 106, 248, 0.3) !important;
        }

        .btn-print-unified:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(111, 106, 248, 0.4) !important;
        }

        .btn-back-unified {
            background: rgba(255, 255, 255, 0.2) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            color: #fff !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            font-family: 'Cairo', sans-serif !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
        }

        .btn-back-unified:hover {
            background: rgba(255, 255, 255, 0.3) !important;
            transform: translateY(-2px) !important;
            color: #fff !important;
        }

        /* Print Styles */
        @media print {
            body * {
                visibility: hidden !important;
            }

            #print-area,
            #print-area * {
                visibility: visible !important;
            }

            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #ccc !important;
            }

            .balance-card {
                background: #f0f0f0 !important;
            }
        }
    </style>
@endsection

@section('header')
    {{-- Unified Header Design - الهوية البصرية الموحدة --}}
    <section class="header-operation-unified" style="background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%); border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(111, 106, 248, 0.3); position: relative; overflow: hidden;">
        {{-- Background Animation Effect --}}
        <div style="content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite; pointer-events: none;"></div>
        
        {{-- Header Content --}}
        <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <i class="la la-file-invoice-dollar" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
                <h1 style="color: #fff; font-size: 24px; font-weight: 700; margin: 0; font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                    التقرير المالي
                </h1>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <a href="{{ backpack_url('distributor') }}" class="btn btn-back-unified no-print">
                    <i class="la la-angle-double-right"></i> العودة إلى قائمة الموزعين
                </a>
                <button onclick="window.print()" class="btn btn-print-unified no-print">
                    <i class="la la-print"></i> طباعة التقرير
                </button>
            </div>
        </div>
    </section>
@endsection

@section('content')
<div class="container-fluid">
    <div id="print-area">
        
        {{-- Distributor Name Card --}}
        <div class="card filter-card mb-4">
            <div class="card-body text-center">
                <h3 style="color: #1f2937; font-size: 22px; font-weight: 700; margin: 0; font-family: 'Cairo', sans-serif;">
                    <i class="la la-user-tie" style="margin-left: 8px; color: #6f6af8;"></i>
                    {{ $entry->name }}
                </h3>
            </div>
        </div>

        {{-- Balance Card --}}
        <div class="balance-card">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p>الرصيد الحالي</p>
                    <h3>{{ number_format($entry->balance, 2) }} <span style="font-size: 24px;">₪</span></h3>
                </div>
                <div style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                    <i class="la la-wallet" style="font-size: 36px; color: #fff;"></i>
                </div>
            </div>
        </div>

        {{-- Withdraws Table --}}
        <div class="card filter-card">
            <div class="card-body">
                <h4 style="color: #1f2937; font-size: 18px; font-weight: 700; margin: 0 0 1.5rem 0; font-family: 'Cairo', sans-serif; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="la la-money-bill-wave" style="color: #6f6af8;"></i>
                    سجل السحوبات
                </h4>
                
                <div class="table-responsive">
                    <table class="table table-clean align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th style="width: 120px;">التاريخ</th>
                                <th style="width: 150px;">المبلغ</th>
                                <th style="min-width: 200px;">ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($entry->cashWithdraws as $withdraw)
                                <tr>
                                    <td style="text-align: center; font-weight: 600; color: #6f6af8;">{{ $loop->iteration }}</td>
                                    <td style="text-align: center; color: #1f2937;">{{ $withdraw->created_at->format('Y-m-d') }}</td>
                                    <td style="text-align: center; font-weight: 600; color: #1f2937;">₪ {{ number_format($withdraw->total_amount, 2) }}</td>
                                    <td style="text-align: right; padding-right: 1.5rem; word-wrap: break-word; max-width: 400px; white-space: normal; line-height: 1.6;">
                                        @if($withdraw->notes && trim($withdraw->notes) !== '')
                                            <span style="color: #1f2937;">{{ $withdraw->notes }}</span>
                                        @else
                                            <span style="color: #9ca3af; font-style: italic;">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center" style="padding: 3rem 1rem; color: #6b7280;">
                                        <i class="la la-inbox" style="font-size: 48px; color: #d1d5db; margin-bottom: 1rem; display: block;"></i>
                                        <p style="margin: 0; font-size: 16px; font-family: 'Cairo', sans-serif;">لا توجد سحوبات</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        
                        @if($entry->cashWithdraws->count())
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="text-align: left; padding-right: 1rem;">
                                        <strong style="font-size: 16px; color: #1f2937;">إجمالي السحوبات</strong>
                                    </td>
                                    <td style="font-weight: 700; color: #1f2937; font-size: 18px; text-align: center;">
                                        ₪ {{ number_format($entry->cashWithdraws->sum('total_amount'), 2) }}
                                    </td>
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
