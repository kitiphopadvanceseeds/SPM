@extends('layouts.style')

@section('style')
<style>
    /* Card สรุปยอดและกล่องเนื้อหา */
    .audit-card {
        border: none;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .audit-card:hover {
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
    }

    /* Summary Stat Cards */
    .stat-card {
        border-radius: 14px;
        padding: 18px 20px;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        min-height: 95px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }

    .stat-card .stat-title {
        font-size: 14px;
        font-weight: 500;
        opacity: 0.95;
        margin-bottom: 4px;
    }

    .stat-card .stat-value {
        font-size: 30px;
        font-weight: 700;
        line-height: 1.1;
    }

    .stat-card .stat-icon {
        font-size: 44px;
        opacity: 0.28;
        position: absolute;
        right: 15px;
        bottom: 10px;
    }

    /* โทนสีของการ์ดสรุปยอด */
    .bg-stat-total {
        background: linear-gradient(135deg, #1d6bf3, #0d47a1);
    }

    .bg-stat-success {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .bg-stat-danger {
        background: linear-gradient(135deg, #ef4444, #b91c1c);
    }

    .bg-stat-crud {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    /* Action Badges */
    .badge-action {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 50px;
        display: inline-block;
        letter-spacing: 0.5px;
    }

    .badge-login-success {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .badge-login-fail {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .badge-logout {
        background-color: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .badge-create {
        background-color: #dbeafe;
        color: #1e40af;
        border: 1px solid #bfdbfe;
    }

    .badge-update {
        background-color: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .badge-delete {
        background-color: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fca5a5;
    }

    .badge-toggle {
        background-color: #e0e7ff;
        color: #3730a3;
        border: 1px solid #c7d2fe;
    }

    .badge-other {
        background-color: #f3f4f6;
        color: #374151;
        border: 1px solid #e5e7eb;
    }

    .badge-branch {
        background-color: #e2e8f0;
        color: #334155;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 11px;
    }

    .table-name-code {
        color: #0284c7;
        font-family: Consolas, monospace;
        font-weight: 600;
        font-size: 12px;
    }

    /* ฟอร์มและตัวกรอง */
    .filter-label {
        font-size: 12px;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 4px;
    }

    .form-control-custom {
        border-radius: 8px;
        border: 1px solid #d1d5db;
        padding: 6px 12px;
        font-size: 13px;
    }

    .form-control-custom:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.15);
    }

    /* ตาราง */
    #auditTable {
        font-size: 13px;
        border-collapse: separate;
        border-spacing: 0;
        width: 100% !important;
    }

    #auditTable thead th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 600;
        border-bottom: 2px solid #e2e8f0;
        padding: 12px 10px;
        white-space: nowrap;
    }

    #auditTable tbody td {
        padding: 10px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    #auditTable tbody tr:hover td {
        background-color: #f8fafc;
    }

    /* JSON Pretty Viewer */
    .json-box {
        background-color: #0f172a;
        color: #38bdf8;
        border-radius: 8px;
        padding: 12px;
        font-family: Consolas, 'Courier New', monospace;
        font-size: 12px;
        max-height: 280px;
        overflow-y: auto;
        white-space: pre-wrap;
        word-break: break-word;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-3 py-2">

    <!-- Header Section -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h4 class="mb-0 fw-bold text-dark d-flex align-items-center">
                <i class="bi bi-shield-check text-primary me-2" style="font-size: 26px;"></i>
                ระบบบันทึกกิจกรรม (Audit Log)
            </h4>
            <small class="text-muted">ตรวจสอบประวัติการเข้าใช้งาน และการเปลี่ยนแปลงข้อมูลทั้งหมดในระบบ</small>
        </div>
    </div>

    <!-- Filter Section Card -->
    <div class="card audit-card mb-3">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                <div class="d-flex align-items-center fw-semibold text-secondary" style="font-size: 14px;">
                    <i class="bi bi-funnel text-primary me-2"></i>
                    ค้นหาและกรองประวัติกิจกรรม
                </div>
                <div class="text-muted" style="font-size: 12px;">
                    <i class="bi bi-info-circle text-primary me-1"></i>
                    ระบบจะแสดงเฉพาะข้อมูลที่มี Prefix <span class="text-danger fw-bold">spm_seed_</span>
                </div>
            </div>

            <form id="filterForm" class="row g-2 align-items-end">
                <!-- วันที่เริ่มต้น -->
                <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                    <label class="filter-label">วันที่เริ่มต้น</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-calendar3"></i></span>
                        <input type="text" class="form-control form-control-custom" id="start_date" name="start_date" placeholder="วัน/เดือน/ปี" autocomplete="off">
                    </div>
                </div>

                <!-- วันที่สิ้นสุด -->
                <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                    <label class="filter-label">วันที่สิ้นสุด</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-calendar3"></i></span>
                        <input type="text" class="form-control form-control-custom" id="end_date" name="end_date" placeholder="วัน/เดือน/ปี" autocomplete="off">
                    </div>
                </div>

                <!-- ประเภทกิจกรรม (Action) -->
                <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                    <label class="filter-label">ประเภทกิจกรรม [ACTION]</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-activity"></i></span>
                        <select class="form-select form-control-custom" id="action_filter" name="action">
                            <option value="all">-- ทั้งหมด --</option>
                            @foreach ($actions as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- ตาราง (Table Name) -->
                <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                    <label class="filter-label">ตาราง [TABLE NAME]</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-table"></i></span>
                        <select class="form-select form-control-custom" id="table_filter" name="table_name">
                            <option value="all">-- ทั้งหมด --</option>
                            @foreach ($tables as $tName)
                                <option value="{{ $tName }}">{{ $tName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- ค้นหาอิสระ -->
                <div class="col-12 col-sm-8 col-md-8 col-lg-3">
                    <label class="filter-label">ค้นหา (ชื่อ / IP / รายละเอียด / ID)</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control form-control-custom" id="keyword" name="keyword" placeholder="พิมพ์เพื่อค้นหา..." autocomplete="off">
                    </div>
                </div>

                <!-- ปุ่มค้นหาและรีเซ็ต -->
                <div class="col-12 col-sm-4 col-md-4 col-lg-1 d-flex gap-1">
                    <button type="button" id="btnSearch" class="btn btn-primary btn-sm w-100" title="ค้นหา">
                        <i class="bi bi-search"></i>
                    </button>
                    <button type="button" id="btnReset" class="btn btn-outline-secondary btn-sm" title="รีเซ็ตการค้นหา">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Stats Cards (4 Cards) -->
    <div class="row g-3 mb-3">
        <!-- รายการทั้งหมด -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card bg-stat-total">
                <div>
                    <div class="stat-title">รายการทั้งหมด</div>
                    <div class="stat-value" id="stat_total">0</div>
                </div>
                <i class="bi bi-list-check stat-icon"></i>
            </div>
        </div>

        <!-- เข้าระบบสำเร็จ -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card bg-stat-success">
                <div>
                    <div class="stat-title">เข้าระบบสำเร็จ</div>
                    <div class="stat-value" id="stat_login_success">0</div>
                </div>
                <i class="bi bi-box-arrow-in-right stat-icon"></i>
            </div>
        </div>

        <!-- เข้าระบบล้มเหลว -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card bg-stat-danger">
                <div>
                    <div class="stat-title">เข้าระบบล้มเหลว</div>
                    <div class="stat-value" id="stat_login_fail">0</div>
                </div>
                <i class="bi bi-shield-x stat-icon"></i>
            </div>
        </div>

        <!-- สร้าง / แก้ไข / ลบ [CRUD] -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card bg-stat-crud">
                <div>
                    <div class="stat-title">สร้าง / แก้ไข / ลบ [CRUD]</div>
                    <div class="stat-value" id="stat_crud">0</div>
                </div>
                <i class="bi bi-pencil-square stat-icon"></i>
            </div>
        </div>
    </div>

    <!-- Table Section Card -->
    <div class="card audit-card">
        <div class="card-header bg-white py-3 px-3 border-bottom d-flex justify-content-between align-items-center">
            <div class="fw-bold text-dark d-flex align-items-center" style="font-size: 15px;">
                <i class="bi bi-card-list text-primary me-2" style="font-size: 18px;"></i>
                ตารางบันทึกกิจกรรม (Audit Log Data)
            </div>
            <span class="badge bg-light text-secondary border fw-normal" style="font-size: 12px;">
                แสดงสูงสุด 1,000 รายการล่าสุด
            </span>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table id="auditTable" class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 40px;">ดู</th>
                            <th class="text-center" style="width: 40px;">#</th>
                            <th style="min-width: 130px;">วันเวลา</th>
                            <th style="min-width: 170px;">ผู้ใช้งาน</th>
                            <th class="text-center" style="min-width: 70px;">สาขา</th>
                            <th class="text-center" style="min-width: 110px;">Action</th>
                            <th style="min-width: 120px;">ตาราง</th>
                            <th class="text-center" style="min-width: 70px;">Record ID</th>
                            <th style="min-width: 200px;">คำอธิบาย</th>
                            <th style="min-width: 120px;">ข้อมูลเก่า/ใหม่</th>
                        </tr>
                    </thead>
                    <tbody id="auditTableBody">
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Modal สำหรับดูรายละเอียดของ Log (JSON / Diff Viewer) -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white py-2 px-3">
                <h6 class="modal-title fw-bold d-flex align-items-center" id="detailModalLabel">
                    <i class="bi bi-info-circle me-2"></i>
                    รายละเอียดบันทึกกิจกรรม (Audit Log Detail)
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <!-- ข้อมูลทั่วไป -->
                <div class="row g-2 mb-3 pb-3 border-bottom" style="font-size: 13px;">
                    <div class="col-md-6">
                        <span class="text-muted">วันเวลา:</span>
                        <strong id="modal_created_at" class="ms-1">-</strong>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted">ประเภท Action:</span>
                        <span id="modal_action" class="ms-1">-</span>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted">ผู้ทำรายการ:</span>
                        <strong id="modal_user" class="ms-1">-</strong>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted">สาขา/บริษัท:</span>
                        <span id="modal_branch" class="ms-1">-</span>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted">ชื่อตาราง:</span>
                        <code id="modal_table" class="ms-1">-</code>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted">Record ID:</span>
                        <strong id="modal_record_id" class="ms-1">-</strong>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted">IP Address:</span>
                        <span id="modal_ip" class="ms-1">-</span>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted">User Agent:</span>
                        <span id="modal_user_agent" class="ms-1 text-truncate d-inline-block align-middle" style="max-width: 240px;">-</span>
                    </div>
                    <div class="col-12">
                        <span class="text-muted">คำอธิบาย:</span>
                        <div id="modal_description" class="p-2 mt-1 bg-light rounded text-dark">-</div>
                    </div>
                </div>

                <!-- ข้อมูลก่อนหน้า vs ข้อมูลใหม่ -->
                <div class="row g-2">
                    <div class="col-12 col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold text-danger" style="font-size: 12px;">
                                <i class="bi bi-file-earmark-minus me-1"></i>
                                ข้อมูลก่อนหน้า (Old Values)
                            </span>
                        </div>
                        <div id="modal_old_values" class="json-box">-</div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold text-success" style="font-size: 12px;">
                                <i class="bi bi-file-earmark-plus me-1"></i>
                                ข้อมูลใหม่ (New Values)
                            </span>
                        </div>
                        <div id="modal_new_values" class="json-box">-</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-2 px-3 bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // จัดการวันที่เริ่มต้น (ย้อนหลัง 30 วัน) และสิ้นสุด (วันนี้)
        const today = new Date();
        const past30Days = new Date();
        past30Days.setDate(today.getDate() - 30);

        function formatDateToISO(date) {
            const y = date.getFullYear();
            const m = String(date.getMonth() + 1).padStart(2, '0');
            const d = String(date.getDate()).padStart(2, '0');
            return `${y}-${m}-${d}`;
        }

        function formatDateToThaiDisplay(date) {
            const y = date.getFullYear() + 543;
            const m = String(date.getMonth() + 1).padStart(2, '0');
            const d = String(date.getDate()).padStart(2, '0');
            return `${d}/${m}/${y}`;
        }

        function parseThaiDateToISO(thaiDateStr) {
            if (!thaiDateStr || !thaiDateStr.includes('/')) return '';
            const parts = thaiDateStr.split('/');
            if (parts.length !== 3) return '';
            const d = parts[0];
            const m = parts[1];
            const y = parseInt(parts[2], 10) - 543;
            return `${y}-${m}-${d}`;
        }

        let isoStartDate = formatDateToISO(past30Days);
        let isoEndDate = formatDateToISO(today);

        // กำหนด Datepicker ในรูปแบบวัน/เดือน/พ.ศ.
        $("#start_date").datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            onSelect: function(dateText) {
                isoStartDate = parseThaiDateToISO(dateText);
            }
        }).val(formatDateToThaiDisplay(past30Days));

        $("#end_date").datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            onSelect: function(dateText) {
                isoEndDate = parseThaiDateToISO(dateText);
            }
        }).val(formatDateToThaiDisplay(today));

        // ฟังก์ชันโหลดข้อมูล Audit Log ผ่าน AJAX
        function loadAuditLogData() {
            $("#loadingOverlay").show();

            const currentStart = parseThaiDateToISO($("#start_date").val()) || isoStartDate;
            const currentEnd = parseThaiDateToISO($("#end_date").val()) || isoEndDate;

            $.ajax({
                url: "{{ route('audit.log.data', [], false) }}",
                type: "GET",
                data: {
                    start_date: currentStart,
                    end_date: currentEnd,
                    action: $("#action_filter").val(),
                    table_name: $("#table_filter").val(),
                    keyword: $("#keyword").val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        // อัปเดตสถิติ Summary Cards
                        $("#stat_total").text((response.stats.total || 0).toLocaleString());
                        $("#stat_login_success").text((response.stats.login_success || 0).toLocaleString());
                        $("#stat_login_fail").text((response.stats.login_fail || 0).toLocaleString());
                        $("#stat_crud").text((response.stats.crud_count || 0).toLocaleString());

                        // สร้างตารางข้อมูล
                        renderTable(response.data);
                    } else {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด",
                            text: response.message || "ไม่สามารถโหลดข้อมูล Audit Log ได้",
                            icon: "error"
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Audit Log Error:", error);
                    Swal.fire({
                        title: "เกิดข้อผิดพลาดในการเชื่อมต่อ",
                        text: xhr.responseText || error,
                        icon: "error"
                    });
                },
                complete: function() {
                    $("#loadingOverlay").fadeOut();
                }
            });
        }

        // ฟังก์ชันวาดตาราง DataTable
        function renderTable(data) {
            const $tbody = $("#auditTableBody");

            // ทำลาย DataTable เก่าก่อนสร้างใหม่
            if ($.fn.DataTable.isDataTable('#auditTable')) {
                $('#auditTable').DataTable().clear().destroy();
            }

            $tbody.empty();

            if (!data || data.length === 0) {
                $tbody.html('<tr><td colspan="10" class="text-center text-muted py-4">ไม่พบข้อมูลประวัติกิจกรรมตามเงื่อนไขที่เลือก</td></tr>');
                return;
            }

            let rowsHtml = '';
            data.forEach(function(item) {
                // Action Badge Generator
                let badgeClass = 'badge-other';
                if (item.action === 'LOGIN_SUCCESS') badgeClass = 'badge-login-success';
                else if (item.action === 'LOGIN_FAIL') badgeClass = 'badge-login-fail';
                else if (item.action === 'LOGOUT') badgeClass = 'badge-logout';
                else if (item.action === 'CREATE') badgeClass = 'badge-create';
                else if (item.action === 'UPDATE') badgeClass = 'badge-update';
                else if (item.action === 'DELETE') badgeClass = 'badge-delete';
                else if (item.action === 'TOGGLE' || item.action === 'toggle') badgeClass = 'badge-toggle';

                // รายละเอียดผู้ใช้
                let userDetail = `<div class="fw-semibold text-dark">${item.user_name}</div>`;
                if (item.user_id) {
                    userDetail += `<small class="text-muted">ID: ${item.user_id}</small>`;
                }

                // ข้อมูลเก่า/ใหม่ตัวอย่าง
                let dataPreview = '-';
                if (item.new_values) {
                    dataPreview = `<code class="text-truncate d-inline-block" style="max-width: 140px;" title="${item.new_values}">${item.new_values}</code>`;
                } else if (item.old_values) {
                    dataPreview = `<code class="text-truncate d-inline-block text-secondary" style="max-width: 140px;" title="${item.old_values}">${item.old_values}</code>`;
                }

                rowsHtml += `
                    <tr>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 btn-view-detail" data-id="${item.id}" title="ดูรายละเอียด">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                        <td class="text-center text-muted">${item.seq}</td>
                        <td class="text-nowrap">${item.created_at}</td>
                        <td>${userDetail}</td>
                        <td class="text-center"><span class="badge-branch">${item.branch_code}</span></td>
                        <td class="text-center"><span class="badge-action ${badgeClass}">${item.action}</span></td>
                        <td><span class="table-name-code">${item.table_name}</span></td>
                        <td class="text-center">${item.record_id}</td>
                        <td><span class="text-truncate d-inline-block" style="max-width: 280px;" title="${item.description}">${item.description}</span></td>
                        <td>${dataPreview}</td>
                    </tr>
                `;
            });

            $tbody.html(rowsHtml);

            // เริ่มต้นใช้งาน DataTable
            $('#auditTable').DataTable({
                pageLength: 25,
                lengthMenu: [10, 25, 50, 100],
                order: [[2, 'desc']],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/th.json'
                },
                responsive: true
            });
        }

        // ปุ่มค้นหา
        $("#btnSearch").on("click", function() {
            loadAuditLogData();
        });

        // ค้นหาเมื่อกด Enter ในช่อง Keyword
        $("#keyword").on("keypress", function(e) {
            if (e.which === 13) {
                e.preventDefault();
                loadAuditLogData();
            }
        });

        // ปุ่มรีเซ็ต
        $("#btnReset").on("click", function() {
            $("#action_filter").val("all");
            $("#table_filter").val("all");
            $("#keyword").val("");
            isoStartDate = formatDateToISO(past30Days);
            isoEndDate = formatDateToISO(today);
            $("#start_date").val(formatDateToThaiDisplay(past30Days));
            $("#end_date").val(formatDateToThaiDisplay(today));
            loadAuditLogData();
        });

        // ปุ่มเปิดดูรายละเอียด Modal
        $(document).on("click", ".btn-view-detail", function() {
            const logId = $(this).data("id");
            if (!logId) return;

            $("#loadingOverlay").show();

            $.ajax({
                url: `{{ url('/audit-log/detail', [], false) }}/${logId}`,
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.success && res.data) {
                        const d = res.data;
                        $("#modal_created_at").text(d.created_at || '-');
                        $("#modal_action").html(`<span class="badge bg-primary">${d.action || '-'}</span>`);
                        $("#modal_user").text(`${d.username || '-'} (ID: ${d.user_id || '-'})`);
                        $("#modal_branch").text(d.branch_name || d.branch_id || '-');
                        $("#modal_table").text(d.table_name || '-');
                        $("#modal_record_id").text(d.record_id || '-');
                        $("#modal_ip").text(d.ip_address || '-');
                        $("#modal_user_agent").text(d.user_agent || '-').attr('title', d.user_agent || '');
                        $("#modal_description").text(d.description || '-');

                        // จัดการแสดงผล JSON Pretty
                        if (d.old_values) {
                            $("#modal_old_values").text(JSON.stringify(d.old_values, null, 2));
                        } else {
                            $("#modal_old_values").text("ไม่มีข้อมูลก่อนหน้า");
                        }

                        if (d.new_values) {
                            $("#modal_new_values").text(JSON.stringify(d.new_values, null, 2));
                        } else {
                            $("#modal_new_values").text("ไม่มีข้อมูลใหม่");
                        }

                        $("#detailModal").modal("show");
                    }
                },
                error: function() {
                    Swal.fire({
                        title: "ผิดพลาด",
                        text: "ไม่สามารถดึงรายละเอียด Audit Log ได้",
                        icon: "error"
                    });
                },
                complete: function() {
                    $("#loadingOverlay").fadeOut();
                }
            });
        });

        // โหลดข้อมูลครั้งแรกเมื่อเปิดหน้า
        loadAuditLogData();
    });
</script>
@endsection
