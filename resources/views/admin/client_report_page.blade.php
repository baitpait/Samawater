@extends(backpack_view('blank'))

@section('after_styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Cairo', sans-serif;
            background: #f8f9fa;
        }
        
        /* ============================================
           Header - Unified Design
           ============================================ */
        .report-header {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
            border-radius: 20px;
            padding: 30px 40px;
            margin-bottom: 30px;
            box-shadow: 0 8px 24px rgba(111, 106, 248, 0.25);
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        
        .report-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 0.5;
            }
            50% {
                opacity: 0.8;
            }
        }
        
        .report-header .icon-box {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .report-header .icon-box i {
            font-size: 28px;
            color: #fff;
        }
        
        .report-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            color: #fff;
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
        }
        
        .report-header .header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
            position: relative;
            z-index: 1;
        }
        
        .btn-pdf {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            padding: 10px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-pdf:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            color: #fff;
        }
        
        .btn-back {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            padding: 10px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Cairo', sans-serif;
        }
        
        .btn-back:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            color: #fff;
        }
        
        /* ============================================
           Stats Cards - Unified Design
           ============================================ */
        .stats-wrapper {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
        }
        
        .stat-card.success::before {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        
        .stat-card.danger::before {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }
        
        .stat-label {
            font-size: 15px;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .stat-card h2,
        .stat-card h5 {
            font-weight: 700;
            margin: 0;
            color: #1f2937;
            font-size: 32px;
        }
        
        .stat-card h5 {
            font-size: 20px;
            margin-top: 8px;
        }
        
        .stat-card small {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
        }
        
        /* ============================================
           Filter Card - Unified Design
           ============================================ */
        .filter-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 32px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: none;
        }
        
        .filter-card .card-title {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 2px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .filter-card .form-control {
            height: 56px;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            font-size: 16px;
            font-weight: 600;
            color: #374151;
            padding: 14px 24px;
            transition: all 0.3s ease;
            font-family: 'Cairo', sans-serif;
        }
        
        .filter-card .form-control:focus {
            border-color: #6f6af8;
            box-shadow: 0 0 0 4px rgba(111, 106, 248, 0.1);
            outline: none;
        }
        
        .btn-filter {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
            border: none;
            color: #fff;
            padding: 0;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(111, 106, 248, 0.3);
            height: 56px;
            min-width: 56px;
        }
        
        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(111, 106, 248, 0.4);
            color: #fff;
        }
        
        /* ============================================
           Table - Unified Design
           ============================================ */
        .table-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: none;
            overflow: hidden;
        }
        
        .report-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .report-table thead {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
        }
        
        .report-table thead th {
            padding: 16px 20px;
            text-align: center;
            font-weight: 700;
            font-size: 15px;
            color: #fff;
            border: none;
            font-family: 'Cairo', sans-serif;
        }
        
        .report-table thead th:first-child,
        .report-table tbody td:first-child {
            min-width: 140px;
            width: 140px;
        }
        
        .report-table thead th:first-child {
            border-top-right-radius: 12px;
        }
        
        .report-table thead th:last-child {
            border-top-left-radius: 12px;
        }
        
        .report-table tbody tr {
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.2s ease;
        }
        
        .report-table tbody tr:hover {
            background: #f9fafb;
        }
        
        .report-table tbody tr:last-child {
            border-bottom: none;
        }
        
        .report-table tbody td {
            padding: 16px 20px;
            text-align: center;
            font-size: 14px;
            color: #374151;
            font-weight: 600;
            font-family: 'Cairo', sans-serif;
        }
        
        .report-table .badge {
            padding: 6px 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
        }
        
        .badge-success-custom {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
        }
        
        .badge-warning-custom {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #fff;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.25);
        }
        
        .badge-info-custom {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: #fff;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.25);
        }
        
        .btn-edit-delivery {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border: none;
            color: #fff;
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.25);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .btn-edit-delivery:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.35);
            color: #fff;
        }
        
        /* ============================================
           Alert - Unified Design
           ============================================ */
        .alert-unified {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            border-radius: 16px;
            padding: 20px 24px;
            color: #fff;
            font-weight: 600;
            font-size: 15px;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.25);
            text-align: center;
        }
        
        /* ============================================
           Modal - Unified Design
           ============================================ */
        /* إصلاح z-index - استخدام قيم عالية جداً لتجاوز أي عنصر آخر */
        .modal-backdrop,
        .modal-backdrop.fade,
        .modal-backdrop.show {
            z-index: 9998 !important;
            background-color: rgba(0, 0, 0, 0.5) !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
        }
        
        /* الـ Modal يجب أن يكون فوق كل شيء */
        #editDeliveryModal.modal,
        #editDeliveryModal.modal.fade,
        #editDeliveryModal.modal.show {
            z-index: 9999 !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            display: block !important;
            overflow-x: hidden !important;
            overflow-y: auto !important;
            pointer-events: none !important;
        }
        
        /* التأكد من أن الـ Dialog و Content قابلان للتفاعل */
        #editDeliveryModal .modal-dialog {
            z-index: 10000 !important;
            position: relative !important;
            margin: 1.75rem auto !important;
            pointer-events: auto !important;
        }
        
        #editDeliveryModal .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            position: relative;
            z-index: 10000 !important;
            pointer-events: auto !important;
        }
        
        #editDeliveryModal .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 3.5rem);
        }
        
        /* التأكد من أن جميع العناصر داخل الـ Modal قابلة للتفاعل */
        #editDeliveryModal .modal-content *,
        #editDeliveryModal .modal-header *,
        #editDeliveryModal .modal-body *,
        #editDeliveryModal .modal-footer *,
        #editDeliveryModal input,
        #editDeliveryModal select,
        #editDeliveryModal button,
        #editDeliveryModal label {
            pointer-events: auto !important;
        }
        
        /* التأكد من أن الـ Menu يعمل بشكل صحيح */
        .sidebar,
        .sidebar-menu,
        .nav-item,
        .nav-link {
            position: relative !important;
            z-index: 1 !important;
        }
        
        /* إزالة أي تعارض مع العناصر الأخرى */
        body.modal-open {
            overflow: hidden;
        }
        
        .modal-header {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
            border-bottom: none;
            padding: 20px 28px;
        }
        
        .modal-title {
            font-weight: 700;
            font-size: 18px;
            color: #fff;
            font-family: 'Cairo', sans-serif;
        }
        
        .btn-close-custom {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: #fff;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        
        .btn-close-custom:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }
        
        .modal-body {
            padding: 28px;
        }
        
        .modal-body .form-label {
            font-size: 14px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 8px;
            font-family: 'Cairo', sans-serif;
        }
        
        .modal-body .form-control {
            height: 50px;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            font-size: 15px;
            padding: 12px 20px;
            transition: all 0.3s ease;
            font-family: 'Cairo', sans-serif;
        }
        
        .modal-body .form-control:focus {
            border-color: #6f6af8;
            box-shadow: 0 0 0 4px rgba(111, 106, 248, 0.1);
            outline: none;
        }
        
        .modal-footer {
            border-top: 2px solid #e5e7eb;
            padding: 20px 28px;
        }
        
        .btn-save-unified {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            color: #fff;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }
        
        .btn-save-unified:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            color: #fff;
        }
        
        .btn-close-unified {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            color: #fff;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }
        
        .btn-close-unified:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
            color: #fff;
        }
        
        /* ============================================
           Responsive
           ============================================ */
        @media (max-width: 768px) {
            .stats-wrapper {
                grid-template-columns: 1fr;
            }
            
            .report-header {
                padding: 20px 24px;
            }
            
            .report-header h1 {
                font-size: 22px;
            }
        }
    </style>
@endsection

@section('content')
<div class="container-fluid pb-4">
    {{-- ================= HEADER ================= --}}
    <div class="report-header">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div class="icon-box">
                    <i class="la la-chart-bar"></i>
                </div>
                <h1>تسليمات المشترك</h1>
        </div>
            <div class="header-actions" style="display: flex; gap: 12px; align-items: center;">
                <a href="{{ backpack_url('client') }}" class="btn-back" style="background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.3); color: #fff; padding: 10px 20px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; font-family: 'Cairo', sans-serif;">
                    <i class="la la-arrow-right"></i>
                    العودة إلى المشتركين
                </a>
        @if($client)
                <a href="{{ route('client.report.pdf',['client_id'=>$client->id]) }}" class="btn-pdf">
                    <i class="la la-file-pdf"></i>
                    PDF
                </a>
                @endif
            </div>
        </div>
    </div>

    {{-- ================= ALERT ================= --}}
    @if(!$client)
        <div class="alert-unified">
            👆 الرجاء اختيار مشترك من القائمة لعرض التقرير
        </div>
    @endif

    {{-- ================= CONTENT ================= --}}
    @if($client)
    {{-- ================= SUMMARY ================= --}}
        <div class="stats-wrapper">
            <div class="stat-card">
                <div class="stat-label">
                    <i class="la la-user" style="font-size: 20px; color: #6f6af8;"></i>
                    اسم المشترك
                </div>
                <h5>{{ $client->name }}</h5>
                <small>{{ $client->city->city_name ?? '-' }}</small>
        </div>

            <div class="stat-card success">
                <div class="stat-label">
                    <i class="la la-truck" style="font-size: 20px; color: #10b981;"></i>
                    عدد التسليمات
                </div>
                <h2>{{ $client->deliveries->count() }}</h2>
            </div>
    </div>

    {{-- ================= FILTER ================= --}}
        <div class="filter-card">
            <h3 class="card-title">
                <i class="la la-filter" style="font-size: 20px; color: #6f6af8;"></i>
                تصفية التسليمات
            </h3>

            <form method="GET" action="{{ route('client.report') }}" class="row g-3">
                <input type="hidden" name="client_id" value="{{ request('client_id') }}">

                <div class="col-md-5">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; font-size: 15px; font-family: 'Cairo', sans-serif;">من تاريخ</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}" style="height: 56px; font-size: 16px; font-weight: 600;">
                </div>

                <div class="col-md-5">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; font-size: 15px; font-family: 'Cairo', sans-serif;">إلى تاريخ</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}" style="height: 56px; font-size: 16px; font-weight: 600;">
                </div>

                <div class="col-md-2">
                    <label class="form-label" style="opacity: 0; margin-bottom: 10px;">&nbsp;</label>
                    <button type="submit" class="btn btn-filter w-100" style="display: flex; align-items: center; justify-content: center; height: 56px;">
                        <i class="la la-search" style="font-size: 22px;"></i>
                    </button>
                </div>
            </form>
    </div>

    {{-- ================= TABLE ================= --}}
        <div class="table-card">
            <div style="overflow-x: auto;">
                <table class="report-table">
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>الموزع</th>
                        <th>قوارير ممتلئة</th>
                        <th>قوارير فارغة</th>
                            <th>رصيد القوارير</th>
                            <th>الدفع</th>
                            <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($client->deliveries as $row)
                    <tr>
                                <td>{{ $row->delivery_date ? \Carbon\Carbon::parse($row->delivery_date)->format('Y-m-d') : '-' }}</td>
                        <td>{{ $row->distributor->name ?? '-' }}</td>
                        <td>
                                    <span class="badge badge-success-custom">
                                {{ $row->bottle_received }}
                            </span>
                        </td>
                        <td>
                                    <span class="badge badge-warning-custom">
                                {{ $row->bottle_empty }}
                            </span>
                        </td>
                                <td style="font-weight: 700; color: #1f2937;">
                            {{ $row->bottle_received - $row->bottle_empty }}
                        </td>
                                <td>
                                    <span class="badge badge-info-custom">
                                        {{ number_format($row->paymant ?? 0, 0) }} ₪
                                    </span>
                                </td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn-edit-delivery"
                                        data-id="{{ $row->id }}"
                                        data-delivery-id="{{ $row->id }}"
                                        title="تعديل"
                                        onclick="editDelivery({{ $row->id }})"
                                    >
                                        <i class="la la-pen"></i>
                                        تعديل
                                    </button>
                                </td>
                    </tr>
                @empty
                    <tr>
                                <td colspan="7" style="padding: 40px 20px; text-align: center; color: #6b7280; font-size: 16px;">
                            لا توجد عمليات مسجلة
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

{{-- ===============================
    Modal تعديل التوصيل - خارج content section
=============================== --}}
<div class="modal fade" id="editDeliveryModal" tabindex="-1" aria-hidden="true" style="z-index: 9999 !important;">
  <div class="modal-dialog modal-dialog-centered" style="z-index: 10000 !important;">
    <div class="modal-content" style="z-index: 10000 !important;">
      <form id="editDeliveryForm">
        <div class="modal-header">
          <h5 class="modal-title">تعديل التسليم</h5>
          <button type="button"
                  class="btn-close-custom"
                  onclick="closeEditModal()"
                  aria-label="Close">
            <i class="la la-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="delivery_id" id="delivery_id">
          <input type="hidden" name="client_id" id="client_id">

          <div class="mb-3">
            <label for="bottle_received" class="form-label">عدد العبوات المستلمة <span style="color: #ef4444;">*</span></label>
            <input type="number" name="bottle_received" id="bottle_received" class="form-control" min="0" required>
          </div>

          <div class="mb-3">
            <label for="bottle_empty" class="form-label">عدد القوارير الفارغة <span style="color: #ef4444;">*</span></label>
            <input type="number" name="bottle_empty" id="bottle_empty" class="form-control" min="0" required>
          </div>

          <div class="mb-3">
            <label for="paymant" class="form-label">الدفعة المالية <span style="color: #ef4444;">*</span></label>
            <input type="number" name="paymant" id="paymant" class="form-control" min="0" step="0.01" required>
          </div>

          <div class="mb-3">
            <label for="delivery_date" class="form-label">تاريخ التسليم <span style="color: #ef4444;">*</span></label>
            <input type="date" name="delivery_date" id="delivery_date" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="distributor_id" class="form-label">الموزع <span style="color: #ef4444;">*</span></label>
            <select name="distributor_id" id="distributor_id" class="form-control" required>
              <option value="">-- اختر الموزع --</option>
              @foreach($distributors ?? [] as $distributor)
                <option value="{{ $distributor->id }}">{{ $distributor->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn-save-unified">
            <i class="la la-save"></i>
            حفظ التعديلات
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@section('after_scripts')
<script>
// متغير عام للـ Modal
var deliveryModal = null;

// مسار التعديل - يتم تمريره من Blade
const deliveryEditBaseUrl = '{{ backpack_url("delivery") }}';

// دالة لإغلاق الـ Modal
function closeEditModal() {
    if (deliveryModal && typeof deliveryModal.hide === 'function') {
        deliveryModal.hide();
    } else if (typeof $ !== 'undefined' && $('#editDeliveryModal').length) {
        $('#editDeliveryModal').modal('hide');
    } else {
        // Fallback: إخفاء الـ Modal مباشرة
        const modalEl = document.getElementById('editDeliveryModal');
        if (modalEl) {
            modalEl.classList.remove('show');
            modalEl.style.display = 'none';
            // إزالة backdrop
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        }
    }
}

// دالة عامة لفتح الـ Modal وتعديل التوصيل
function editDelivery(deliveryId) {
    console.log('🖱️ تم الضغط على زر التعديل - ID:', deliveryId);
    
    if (!deliveryId) {
        alert('خطأ: معرف التوصيل غير موجود');
        return;
    }
    
    // تهيئة الـ Modal إذا لم يكن موجوداً
    if (!deliveryModal) {
        const modalEl = document.getElementById('editDeliveryModal');
        if (!modalEl) {
            alert('خطأ: عنصر الـ Modal غير موجود');
            return;
        }
        
        // التحقق من وجود Bootstrap (من Backpack أو من CDN)
        let BootstrapModal;
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            BootstrapModal = bootstrap.Modal;
        } else if (typeof window.bootstrap !== 'undefined' && window.bootstrap.Modal) {
            BootstrapModal = window.bootstrap.Modal;
        } else if (typeof $ !== 'undefined' && $.fn.modal) {
            // استخدام jQuery Modal إذا كان متاحاً
            BootstrapModal = null; // سنستخدم jQuery بدلاً من Bootstrap
        } else {
            console.error('❌ Bootstrap غير محمل');
            alert('خطأ: Bootstrap غير محمل');
            return;
        }
        
        if (BootstrapModal) {
            deliveryModal = new BootstrapModal(modalEl, {
                backdrop: true,
                keyboard: true,
                focus: true
            });
        } else if (typeof $ !== 'undefined' && $.fn.modal) {
            // استخدام jQuery Modal
            $(modalEl).modal({
                backdrop: true,
                keyboard: true,
                show: false
            });
            deliveryModal = {
                show: function() { $(modalEl).modal('show'); },
                hide: function() { $(modalEl).modal('hide'); }
            };
        }
    }
    
    console.log('📡 جارٍ جلب البيانات من السيرفر...');
    
    // جلب بيانات التوصيل
    fetch(`${deliveryEditBaseUrl}/${deliveryId}/edit`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => {
        console.log('📥 استجابة السيرفر:', res.status);
        if (!res.ok) {
            throw new Error('فشل جلب البيانات: ' + res.status);
        }
        return res.json();
    })
    .then(data => {
        console.log('✅ تم جلب البيانات:', data);
        
        if (data.id) {
            // ملء الحقول
            document.getElementById('delivery_id').value = data.id;
            document.getElementById('client_id').value = data.client_id ?? '';
            document.getElementById('bottle_received').value = data.bottle_received ?? 0;
            document.getElementById('bottle_empty').value = data.bottle_empty ?? 0;
            document.getElementById('paymant').value = data.paymant ?? 0;
            document.getElementById('delivery_date').value = data.delivery_date ?? '';
            
            // ملء حقل الموزع
            const distributorSelect = document.getElementById('distributor_id');
            if (distributorSelect && data.distributor_id) {
                distributorSelect.value = data.distributor_id ?? '';
            }
            
            console.log('📝 تم ملء الحقول، جارٍ فتح الـ Modal...');
            
            if (deliveryModal && typeof deliveryModal.show === 'function') {
                deliveryModal.show();
                console.log('✅ تم فتح الـ Modal');
            } else if (typeof $ !== 'undefined' && $('#editDeliveryModal').length) {
                $('#editDeliveryModal').modal('show');
                console.log('✅ تم فتح الـ Modal باستخدام jQuery');
            } else {
                console.error('❌ لا يمكن فتح الـ Modal');
                alert('خطأ: لا يمكن فتح نافذة التعديل');
            }
        } else {
            alert('خطأ: البيانات غير صحيحة');
        }
    })
    .catch(err => {
        console.error('❌ فشل جلب البيانات:', err);
        alert('حدث خطأ أثناء جلب البيانات: ' + err.message);
    });
}

// تهيئة الـ Modal عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ بدء تهيئة النظام...');
    
    const modalEl = document.getElementById('editDeliveryModal');
    if (modalEl) {
        // التحقق من وجود Bootstrap
        let BootstrapModal;
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            BootstrapModal = bootstrap.Modal;
        } else if (typeof window.bootstrap !== 'undefined' && window.bootstrap.Modal) {
            BootstrapModal = window.bootstrap.Modal;
        } else if (typeof $ !== 'undefined' && $.fn.modal) {
            // استخدام jQuery Modal
            $(modalEl).modal({
                backdrop: true,
                keyboard: true,
                show: false
            });
            deliveryModal = {
                show: function() { $(modalEl).modal('show'); },
                hide: function() { $(modalEl).modal('hide'); }
            };
            console.log('✅ تم إنشاء jQuery Modal');
            return;
        }
        
        if (BootstrapModal) {
            deliveryModal = new BootstrapModal(modalEl, {
                backdrop: true,
                keyboard: true,
                focus: true
            });
            console.log('✅ تم إنشاء Bootstrap Modal');
        }
        
        // تنظيف الحقول عند إغلاق الـ Modal
        modalEl.addEventListener('hidden.bs.modal', function () {
            const form = document.getElementById('editDeliveryForm');
            if (form) {
                form.reset();
            }
        });
    }
    
    // إضافة event listeners للأزرار
    document.querySelectorAll('.btn-edit-delivery').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id') || this.getAttribute('data-delivery-id') || this.dataset.id;
            if (id) {
                editDelivery(id);
            }
        });
    });
    
    // عند حفظ التعديلات
    const form = document.getElementById('editDeliveryForm');
    if (form) {
        form.addEventListener('submit', function(e){
            e.preventDefault();
            e.stopPropagation();

            const formData = new FormData(this);
            const deliveryId = formData.get('delivery_id');
            const clientId = formData.get('client_id');
            const deliveryDate = formData.get('delivery_date');
            const bottleReceived = formData.get('bottle_received');
            const bottleEmpty = formData.get('bottle_empty');
            const paymant = formData.get('paymant');
            const distributorId = formData.get('distributor_id');

            // التحقق من البيانات
            let errors = [];

            if (!deliveryId) {
                errors.push('معرف التوصيل غير موجود');
            }

            if (!clientId || clientId === '') {
                errors.push('يجب اختيار المشترك');
            }

            if (!deliveryDate || deliveryDate === '') {
                errors.push('تاريخ التوصيل مطلوب');
            }

            if (bottleReceived === '' || bottleReceived === null || bottleReceived === undefined) {
                errors.push('عدد العبوات المستلمة مطلوب');
            } else if (parseInt(bottleReceived) < 0) {
                errors.push('عدد العبوات المستلمة لا يمكن أن يكون سالباً');
            }

            if (bottleEmpty === '' || bottleEmpty === null || bottleEmpty === undefined) {
                errors.push('عدد العبوات الفارغة مطلوب');
            } else if (parseInt(bottleEmpty) < 0) {
                errors.push('عدد العبوات الفارغة لا يمكن أن يكون سالباً');
            }

            if (paymant === '' || paymant === null || paymant === undefined) {
                errors.push('الدفعة مطلوبة');
            } else if (parseFloat(paymant) < 0) {
                errors.push('الدفعة لا يمكن أن تكون سالبة');
            }

            if (!distributorId || distributorId === '') {
                errors.push('يجب اختيار الموزع');
            }

            // إذا كان هناك أخطاء، عرضها وإيقاف الإرسال
            if (errors.length > 0) {
                alert('يرجى تصحيح الأخطاء التالية:\n\n' + errors.join('\n'));
                return;
            }

            formData.append('_method', 'PUT');

            fetch(`${deliveryEditBaseUrl}/${deliveryId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => {
                if (!res.ok) {
                    return res.json().then(err => {
                        throw err;
                    });
                }
                return res.json();
            })
            .then(data => {
                if(data.status){
                    // إغلاق الـ Modal مباشرة
                    if (deliveryModal && typeof deliveryModal.hide === 'function') {
                        deliveryModal.hide();
                    } else if (typeof $ !== 'undefined' && $('#editDeliveryModal').length) {
                        $('#editDeliveryModal').modal('hide');
                    }
                    // تحديث الصفحة مباشرة بدون رسالة
                    location.reload();
                } else {
                    // عرض رسائل الخطأ
                    let errorMessage = data.message || 'حدث خطأ';
                    if (data.errors) {
                        const errors = Object.values(data.errors).flat();
                        errorMessage = errors.join('\n');
                    }
                    alert(errorMessage);
                }
            })
            .catch(err => {
                console.error('❌ خطأ في حفظ التعديلات:', err);
                let errorMessage = 'حدث خطأ أثناء حفظ التعديلات';
                
                // إذا كان الخطأ يحتوي على رسالة
                if (err && typeof err === 'object') {
                    if (err.message) {
                        errorMessage = err.message;
                    } else if (err.errors) {
                        const errors = Object.values(err.errors).flat();
                        errorMessage = errors.join('\n');
                    } else if (err.status === false && err.message) {
                        errorMessage = err.message;
                    }
                } else if (typeof err === 'string') {
                    errorMessage = err;
                }
                
                alert(errorMessage);
            });
        });
    }
    
    console.log('✅ تم تهيئة النظام بنجاح');
});
</script>
@endsection
