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

        /* Results Header */
        .results-header {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            border-radius: 16px !important;
            padding: 1.5rem !important;
            margin-bottom: 1.5rem !important;
            box-shadow: 0 8px 24px rgba(239, 68, 68, 0.2) !important;
        }

        .results-header h2 {
            color: #fff !important;
            font-size: 24px !important;
            font-weight: 700 !important;
            margin: 0 !important;
            font-family: 'Cairo', sans-serif !important;
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important;
        }

        .results-header .count {
            color: #fff !important;
            font-size: 20px !important;
            font-weight: 600 !important;
            margin: 0 !important;
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
            text-align: center !important;
            vertical-align: middle !important;
        }

        .table-clean tbody tr:last-child td {
            border-bottom: none !important;
        }

        /* Badge Styles */
        .badge {
            padding: 0.5rem 1rem !important;
            border-radius: 12px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            font-family: 'Cairo', sans-serif !important;
        }

        .badge-info {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
            color: #fff !important;
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

            .results-header {
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
                <i class="la la-users" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
                <h1 style="color: #fff; font-size: 24px; font-weight: 700; margin: 0; font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                    مشتركين الموزع
                </h1>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <a href="{{ backpack_url('distributor') }}" class="btn btn-back-unified no-print">
                    <i class="la la-angle-double-right"></i> العودة إلى قائمة الموزعين
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
        <div class="card filter-card mb-4">
            <div class="card-body text-center">
                <h3 style="color: #1f2937; font-size: 22px; font-weight: 700; margin: 0; font-family: 'Cairo', sans-serif;">
                    <i class="la la-user-tie" style="margin-left: 8px; color: #6f6af8;"></i>
                    {{ $distributor->name }}
                </h3>
            </div>
        </div>

        {{-- Results Header --}}
        <div class="results-header">
            <h2>
                <i class="la la-users"></i>
                عدد المشتركين
            </h2>
            <p class="count">{{ $clients->total() }}</p>
        </div>

        {{-- Clients Table --}}
        <div class="card filter-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-clean align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>اسم المشترك</th>
                                <th style="width: 150px;">الهاتف</th>
                                <th style="width: 120px;">المدينة</th>
                                <th style="width: 130px;">تاريخ الاشتراك</th>
                                <th style="width: 150px;">حالة الاشتراك</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $i => $client)
                                <tr>
                                    <td style="text-align: center; font-weight: 600; color: #6f6af8;">{{ $clients->firstItem() + $i }}</td>
                                    <td style="text-align: right; padding-right: 1.5rem; font-weight: 600; color: #1f2937;">{{ $client->name }}</td>
                                    <td style="text-align: center; color: #1f2937;">{{ $client->phone_one ?? '-' }}</td>
                                    <td style="text-align: center; color: #1f2937;">{{ $client->city->city_name ?? '-' }}</td>
                                    <td style="text-align: center; color: #1f2937;">
                                        {{ $client->subscription_start_date
                                            ? \Carbon\Carbon::parse($client->subscription_start_date)->format('Y-m-d')
                                            : '-' }}
                                    </td>
                                    <td style="text-align: center;">
                                        @if($client->subscriptionStatus)
                                            <span class="badge badge-info">
                                                {{ $client->subscriptionStatus->status_name }}
                                            </span>
                                        @else
                                            <span style="color: #9ca3af;">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center" style="padding: 3rem 1rem; color: #6b7280;">
                                        <i class="la la-inbox" style="font-size: 48px; color: #d1d5db; margin-bottom: 1rem; display: block;"></i>
                                        <p style="margin: 0; font-size: 16px; font-family: 'Cairo', sans-serif;">لا يوجد مشتركين لهذا الموزع</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($clients->hasPages())
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $clients->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
