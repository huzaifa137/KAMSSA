

<?php $__env->startSection('content'); ?>

    <style>
        :root {
            --primary: #026837;
            --primary-light: #1a6b30;
            --primary-pale: #e8f5ec;
            --accent-th: #1565C0;
            --accent-id: #6A1B9A;
            --accent-ple: #E65100;
            --border-radius: 12px;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .gs-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: var(--border-radius);
            padding: 28px 32px;
            color: white;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: var(--shadow);
        }

        .gs-header h2 {
            margin: 0;
            font-size: 1.6rem;
            font-weight: 700;
        }

        .gs-header p {
            margin: 4px 0 0;
            opacity: 0.85;
            font-size: 0.92rem;
        }

        /* Category Tabs */
        .category-tabs {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .cat-tab {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 24px;
            border-radius: 50px;
            border: 2px solid #dee2e6;
            background: white;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.25s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            color: #555;
            min-width: 180px;
            justify-content: center;
        }

        .cat-tab .cat-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
        }

        .cat-tab[data-cat="TH"] .cat-dot {
            background: var(--accent-th);
        }

        .cat-tab[data-cat="ID"] .cat-dot {
            background: var(--accent-id);
        }

        .cat-tab[data-cat="PLE"] .cat-dot {
            background: var(--accent-ple);
        }

        .cat-tab.active[data-cat="TH"] {
            border-color: var(--accent-th);
            background: var(--accent-th);
            color: white;
        }

        .cat-tab.active[data-cat="ID"] {
            border-color: var(--accent-id);
            background: var(--accent-id);
            color: white;
        }

        .cat-tab.active[data-cat="PLE"] {
            border-color: var(--accent-ple);
            background: var(--accent-ple);
            color: white;
        }

        .cat-tab.active .cat-dot {
            background: rgba(255, 255, 255, 0.7);
        }

        .cat-tab:not(.active):hover {
            border-color: #aaa;
            transform: translateY(-2px);
        }

        /* Panel */
        .settings-panel {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .panel-header {
            padding: 20px 28px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .panel-header .category-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .badge-TH {
            background: #EBF3FF;
            color: var(--accent-th);
        }

        .badge-ID {
            background: #F3E8FF;
            color: var(--accent-id);
        }

        .badge-PLE {
            background: #FFF3E0;
            color: var(--accent-ple);
        }

        .panel-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        /* Sub-tabs for Marks / Points */
        .type-tabs {
            display: flex;
            border-bottom: 1px solid #e8e8e8;
            padding: 0 28px;
            background: #fafafa;
        }

        .type-tab {
            padding: 14px 24px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            color: #888;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .type-tab.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }

        .type-tab:hover:not(.active) {
            color: #444;
        }

        /* Table */
        .gs-table-wrap {
            padding: 24px 28px;
        }

        .gs-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.9rem;
        }

        .gs-table thead th {
            background: var(--primary-pale);
            color: var(--primary);
            font-weight: 700;
            padding: 12px 16px;
            font-size: 0.82rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 2px solid #c8e6d0;
        }

        .gs-table thead th:first-child {
            border-radius: 8px 0 0 0;
        }

        .gs-table thead th:last-child {
            border-radius: 0 8px 0 0;
        }

        .gs-table tbody tr {
            transition: background 0.15s;
        }

        .gs-table tbody tr:hover {
            background: #f9f9f9;
        }

        .gs-table tbody td {
            padding: 13px 16px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }

        .grade-pill {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.82rem;
            letter-spacing: 0.3px;
        }

        .pill-D1 {
            background: #d4edda;
            color: #155724;
        }

        .pill-D2 {
            background: #cce5ff;
            color: #004085;
        }

        .pill-C3 {
            background: #fff3cd;
            color: #856404;
        }

        .pill-C4 {
            background: #ffeaa7;
            color: #6c5700;
        }

        .pill-P5 {
            background: #fde8d8;
            color: #7c3700;
        }

        .pill-P6 {
            background: #f8d7da;
            color: #721c24;
        }

        .pill-F7,
        .pill-FAIL {
            background: #f5c6cb;
            color: #6d1117;
        }

        .pill-MUMTAZ {
            background: linear-gradient(135deg, #ffd700, #ffb300);
            color: #3d2b00;
        }

        .pill-FIRST {
            background: #d1ecf1;
            color: #0c5460;
        }

        .pill-SECOND {
            background: #e2e3e5;
            color: #383d41;
        }

        .pill-THIRD {
            background: #fff3cd;
            color: #856404;
        }

        .pill-PASS {
            background: #d4edda;
            color: #155724;
        }

        .pill-default {
            background: #e9ecef;
            color: #495057;
        }

        .mark-range {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: #333;
            background: #f4f4f4;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 0.88rem;
            white-space: nowrap;
        }

        /* Edit inline */
        .editable-field {
            border: none;
            background: transparent;
            width: 100%;
            font-size: 0.9rem;
            padding: 4px 6px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .editable-field:focus {
            outline: none;
            background: #f0f7ff;
            border: 1.5px solid #007bff;
        }

        .btn-action {
            border: none;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-save {
            background: #d4edda;
            color: #155724;
        }

        .btn-save:hover {
            background: #28a745;
            color: white;
        }

        .btn-delete {
            background: #f8d7da;
            color: #721c24;
        }

        .btn-delete:hover {
            background: #dc3545;
            color: white;
        }

        .btn-add-grade {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 9px 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.88rem;
        }

        .btn-add-grade:hover {
            background: var(--primary-light);
            transform: translateY(-1px);
        }

        .btn-reset {
            background: white;
            color: #dc3545;
            border: 2px solid #dc3545;
            border-radius: 8px;
            padding: 7px 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-reset:hover {
            background: #dc3545;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: #999;
        }

        .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 12px;
            display: block;
        }

        /* Modal */
        .gs-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .gs-modal-overlay.show {
            display: flex;
        }

        .gs-modal {
            background: white;
            border-radius: var(--border-radius);
            width: 480px;
            max-width: 95vw;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: modalIn 0.25s ease;
        }

        @keyframes modalIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .gs-modal-header {
            background: var(--primary);
            color: white;
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .gs-modal-header h5 {
            margin: 0;
            font-weight: 700;
        }

        .gs-modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.3rem;
            cursor: pointer;
        }

        .gs-modal-body {
            padding: 24px;
        }

        .gs-modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.88rem;
            color: #444;
            margin-bottom: 5px;
            display: block;
        }

        .form-input {
            width: 100%;
            padding: 9px 14px;
            border: 1.5px solid #dee2e6;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .info-note {
            background: #f0f7ff;
            border-left: 4px solid #007bff;
            padding: 12px 16px;
            border-radius: 0 8px 8px 0;
            font-size: 0.85rem;
            color: #004085;
            margin-bottom: 20px;
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 40px;
            color: #888;
        }

        @media (max-width: 600px) {
            .cat-tab {
                min-width: unset;
                flex: 1;
                padding: 12px 14px;
                font-size: 0.85rem;
            }

            .gs-table-wrap {
                padding: 16px;
            }

            .panel-header {
                padding: 16px;
            }
        }

        .gs-table thead th {
            background: #026837;
            color: #FFF;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <div class="side-app">

        
        <div class="gs-header">
            <div>
                <h2><i class="fas fa-sliders-h me-2"></i> Grading Settings</h2>
                <p>Configure mark thresholds and classifications per examination category. Each mock body can adapt these
                    independently.</p>
            </div>
            <div style="text-align:right; opacity:0.85; font-size:0.82rem; line-height:1.6;">
                <div><i class="fas fa-shield-alt me-1"></i> Admin Only</div>
                <div><i class="fas fa-sync-alt me-1"></i> Live Configuration</div>
            </div>
        </div>

        
        <div class="category-tabs">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="cat-tab <?php echo e($loop->first ? 'active' : ''); ?>" data-cat="<?php echo e($code); ?>">
                    <span class="cat-dot"></span>
                    <span><?php echo e($label); ?></span>
                    <span style="font-size:0.78rem; opacity:0.7;">(<?php echo e($code); ?>)</span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="settings-panel">
            <div class="panel-header">
                <div>
                    <span class="category-badge badge-TH" id="activeCatBadge" style="display:none;">
                        <i class="fas fa-book me-1"></i> <span id="activeCatLabel">Thanawi</span>
                    </span>
                    <div id="categoryTitle" style="font-weight:700; font-size:1.1rem; color:#222;">
                        Loading grades…
                    </div>
                    <div style="font-size:0.82rem; color:#888; margin-top:2px;">
                        Adjust the marks range and comment for each grade. Changes apply immediately to results computation.
                    </div>
                </div>
                <div class="panel-actions">
                    <button class="btn-add-grade" id="btnAddGrade">
                        <i class="fas fa-plus-circle"></i> Add Grade
                    </button>
                    <button class="btn-reset" id="btnResetDefaults">
                        <i class="fas fa-undo"></i> Reset to Defaults
                    </button>
                </div>
            </div>

            
            <div class="type-tabs">
                <div class="type-tab active" data-type="Marks">
                    <i class="fas fa-chart-bar"></i> Marks Grading
                </div>
                <div class="type-tab" data-type="Points">
                    <i class="fas fa-trophy"></i> Classification
                </div>
            </div>

            
            <div class="gs-table-wrap">
                <div class="loading-spinner" id="loadingSpinner">
                    <i class="fas fa-spinner fa-spin fa-2x mb-2"></i><br>Loading grades…
                </div>
                <div id="gradesTableContainer">
                    <table class="gs-table" id="gradesTable">
                        <thead>
                            <tr>
                                <th style="width:80px;">#</th>
                                <th style="width:130px;">Grade</th>
                                <th style="width:160px;">Mark Range (%)</th>
                                <th>Comment / Label</th>
                                <th style="width:80px; text-align:center;">Weight</th>
                                <th style="width:130px; text-align:center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="gradesTableBody">
                            <tr>
                                <td colspan="6" class="empty-state"><i class="fas fa-spinner fa-spin"></i> Loading…</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    
    <div class="gs-modal-overlay" id="addGradeModal">
        <div class="gs-modal">
            <div class="gs-modal-header">
                <h5><i class="fas fa-plus me-2"></i> Add New Grade</h5>
                <button class="gs-modal-close" id="closeAddModal">&times;</button>
            </div>
            <div class="gs-modal-body">
                <div class="info-note">
                    <i class="fas fa-info-circle me-1"></i>
                    Adding a grade for: <strong id="modalCatLabel">—</strong> &nbsp;|&nbsp; Type: <strong
                        id="modalTypeLabel">—</strong>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
                    <div>
                        <label class="form-label">Grade Code *</label>
                        <input type="text" id="newGrade" class="form-input" placeholder="e.g. D1, A, PASS" maxlength="30">
                    </div>
                    <div>
                        <label class="form-label">Weight *</label>
                        <input type="number" id="newWeight" class="form-input" placeholder="1" min="1" max="99">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
                    <div>
                        <label class="form-label">From Mark (%) *</label>
                        <input type="number" id="newFrom" class="form-input" placeholder="0" min="0" max="100" step="0.01">
                    </div>
                    <div>
                        <label class="form-label">To Mark (%) *</label>
                        <input type="number" id="newTo" class="form-input" placeholder="100" min="0" max="100" step="0.01">
                    </div>
                </div>

                <div style="margin-bottom:8px;">
                    <label class="form-label">Comment / Label</label>
                    <input type="text" id="newComment" class="form-input" placeholder="e.g. Distinction 1, مُمتاز"
                        maxlength="100">
                </div>
            </div>
            <div class="gs-modal-footer">
                <button class="btn-reset" id="cancelAddModal" style="border-color:#6c757d; color:#6c757d;">Cancel</button>
                <button class="btn-add-grade" id="submitAddGrade">
                    <i class="fas fa-save me-1"></i> Save Grade
                </button>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

    <script>
        $(document).ready(function () {

            let activeCategory = 'TH';
            let activeType = 'Marks';
            let gradesData = { marks: [], points: [] };

            const categoryColors = { TH: '#1565C0', ID: '#6A1B9A', PLE: '#E65100' };
            const categoryLabels = { TH: 'Thanawi', ID: 'Idaad', PLE: 'Primary (PLE)' };

            // ── Category tab click ──────────────────────────────────────────
            $('.cat-tab').on('click', function () {
                $('.cat-tab').removeClass('active');
                $(this).addClass('active');
                activeCategory = $(this).data('cat');
                loadGrades(activeCategory);
            });

            // ── Type sub-tab click ─────────────────────────────────────────
            $('.type-tab').on('click', function () {
                $('.type-tab').removeClass('active');
                $(this).addClass('active');
                activeType = $(this).data('type');
                renderTable();
            });

            // ── Load grades via AJAX ───────────────────────────────────────
            function loadGrades(cat) {
                $('#loadingSpinner').show();
                $('#gradesTableContainer').hide();

                $.get(`/grading-settings/category/${cat}`, function (data) {
                    gradesData = data;
                    updateHeader(cat);
                    renderTable();
                    $('#loadingSpinner').hide();
                    $('#gradesTableContainer').show();
                }).fail(function () {
                    Swal.fire('Error', 'Failed to load grades. Please try again.', 'error');
                    $('#loadingSpinner').hide();
                    $('#gradesTableContainer').show();
                });
            }

            function updateHeader(cat) {
                $('#categoryTitle').text(categoryLabels[cat] + ' Grading Configuration');
            }

            // ── Render table rows ──────────────────────────────────────────
            function renderTable() {
                const rows = activeType === 'Marks' ? gradesData.marks : gradesData.points;
                const tbody = $('#gradesTableBody');
                tbody.empty();

                if (!rows || rows.length === 0) {
                    tbody.html(`<tr><td colspan="6" class="empty-state">
                        <i class="fas fa-inbox"></i>
                        No grades configured yet. Click <strong>Add Grade</strong> to get started.
                    </td></tr>`);
                    return;
                }

                rows.forEach((g, i) => {
                    const pillClass = getPillClass(g.grade);
                    tbody.append(`
                        <tr data-id="${g.id}">
                            <td style="color:#999; font-size:0.82rem; font-weight:600;">${i + 1}</td>
                            <td>
                                <span class="grade-pill ${pillClass}">${g.grade}</span>
                            </td>
                            <td>
                                <div style="display:flex; align-items:center; gap:6px;">
                                    <input type="number" class="editable-field edit-from"
                                        value="${g.from_mark}" min="0" max="100" step="0.01"
                                        style="width:70px; text-align:center;">
                                    <span style="color:#999;">–</span>
                                    <input type="number" class="editable-field edit-to"
                                        value="${g.to_mark}" min="0" max="100" step="0.01"
                                        style="width:70px; text-align:center;">
                                </div>
                            </td>
                            <td>
                                <input type="text" class="editable-field edit-comment"
                                    value="${g.comment || ''}" placeholder="Comment…" maxlength="100">
                            </td>
                            <td style="text-align:center;">
                                <input type="number" class="editable-field edit-weight"
                                    value="${g.weight}" min="1" max="99"
                                    style="width:55px; text-align:center;">
                            </td>
                            <td style="text-align:center;">
                                <div style="display:flex; gap:6px; justify-content:center;">
                                    <button class="btn-action btn-save btn-save-grade" data-id="${g.id}" data-grade="${g.grade}">
                                        <i class="fas fa-check"></i> Save
                                    </button>
                                    <button class="btn-action btn-delete btn-delete-grade" data-id="${g.id}" data-grade="${g.grade}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `);
                });
            }

            function getPillClass(grade) {
                if (!grade) return 'pill-default';
                const g = grade.toUpperCase().replace(/\s+/g, '');
                if (g === 'D1') return 'pill-D1';
                if (g === 'D2') return 'pill-D2';
                if (g === 'C3') return 'pill-C3';
                if (g === 'C4') return 'pill-C4';
                if (g === 'P5') return 'pill-P5';
                if (g === 'P6') return 'pill-P6';
                if (g === 'F7' || g === 'FAIL') return 'pill-FAIL';
                if (g === 'MUMTAZ') return 'pill-MUMTAZ';
                if (g.includes('FIRST')) return 'pill-FIRST';
                if (g.includes('SECOND')) return 'pill-SECOND';
                if (g.includes('THIRD')) return 'pill-THIRD';
                if (g === 'PASS') return 'pill-PASS';
                return 'pill-default';
            }

            // ── Save individual grade ──────────────────────────────────────
            $(document).on('click', '.btn-save-grade', function () {
                const id = $(this).data('id');
                const row = $(this).closest('tr');
                const grade = $(this).data('grade');
                const from = row.find('.edit-from').val();
                const to = row.find('.edit-to').val();
                const comment = row.find('.edit-comment').val();
                const weight = row.find('.edit-weight').val();

                if (parseFloat(to) < parseFloat(from)) {
                    Swal.fire('Validation Error', 'To mark must be ≥ From mark.', 'warning');
                    return;
                }

                $.ajax({
                    url: `/grading-settings/${id}`,
                    method: 'PUT',
                    data: { grade, from_mark: from, to_mark: to, comment, weight, _token: '<?php echo e(csrf_token()); ?>' },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: res.message, showConfirmButton: false, timer: 2000 });
                            loadGrades(activeCategory);
                        }
                    },
                    error: function (xhr) {
                        const msg = xhr.responseJSON?.message || 'Failed to save. Please check your values.';
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });

            // ── Delete grade ───────────────────────────────────────────────
            $(document).on('click', '.btn-delete-grade', function () {
                const id = $(this).data('id');
                const grade = $(this).data('grade');

                Swal.fire({
                    title: `Delete "${grade}"?`,
                    text: 'This grade will be removed from the system.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, Delete',
                }).then(result => {
                    if (!result.isConfirmed) return;

                    $.ajax({
                        url: `/grading-settings/${id}`,
                        method: 'DELETE',
                        data: { _token: '<?php echo e(csrf_token()); ?>' },
                        success: function (res) {
                            if (res.success) {
                                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: res.message, showConfirmButton: false, timer: 2000 });
                                loadGrades(activeCategory);
                            }
                        }
                    });
                });
            });

            // ── Reset defaults ─────────────────────────────────────────────
            $('#btnResetDefaults').on('click', function () {
                Swal.fire({
                    title: `Reset ${categoryLabels[activeCategory]} to Defaults?`,
                    html: 'This will <strong>overwrite all current grades</strong> for this category with the system defaults.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, Reset',
                }).then(result => {
                    if (!result.isConfirmed) return;

                    $.ajax({
                        url: `/grading-settings/reset/${activeCategory}`,
                        method: 'POST',
                        data: { _token: '<?php echo e(csrf_token()); ?>' },
                        success: function (res) {
                            if (res.success) {
                                Swal.fire({ icon: 'success', title: 'Reset!', text: res.message, confirmButtonColor: '#026837' })
                                    .then(() => loadGrades(activeCategory));
                            }
                        },
                        error: function () { Swal.fire('Error', 'Could not reset grades.', 'error'); }
                    });
                });
            });

            // ── Add Grade Modal ────────────────────────────────────────────
            $('#btnAddGrade').on('click', function () {
                $('#modalCatLabel').text(categoryLabels[activeCategory] + ' (' + activeCategory + ')');
                $('#modalTypeLabel').text(activeType);
                $('#newGrade, #newFrom, #newTo, #newComment, #newWeight').val('');
                $('#addGradeModal').addClass('show');
            });

            $('#closeAddModal, #cancelAddModal').on('click', function () {
                $('#addGradeModal').removeClass('show');
            });

            $('#addGradeModal').on('click', function (e) {
                if ($(e.target).is('#addGradeModal')) $(this).removeClass('show');
            });

            $('#submitAddGrade').on('click', function () {
                const grade = $('#newGrade').val().trim();
                const from = $('#newFrom').val();
                const to = $('#newTo').val();
                const comment = $('#newComment').val().trim();
                const weight = $('#newWeight').val();

                if (!grade || from === '' || to === '' || !weight) {
                    Swal.fire('Validation', 'Please fill in Grade, From, To, and Weight.', 'warning');
                    return;
                }

                if (parseFloat(to) < parseFloat(from)) {
                    Swal.fire('Validation Error', 'To mark must be ≥ From mark.', 'warning');
                    return;
                }

                $.ajax({
                    url: '/grading-settings',
                    method: 'POST',
                    data: {
                        category: activeCategory,
                        type: activeType,
                        grade, from_mark: from, to_mark: to, comment, weight,
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function (res) {
                        if (res.success) {
                            $('#addGradeModal').removeClass('show');
                            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: res.message, showConfirmButton: false, timer: 2500 });
                            loadGrades(activeCategory);
                        }
                    },
                    error: function (xhr) {
                        const msg = xhr.responseJSON?.error || 'Could not add grade.';
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });

            // ── Initial load ───────────────────────────────────────────────
            loadGrades('TH');
        });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts-side-bar.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Desktop\huzaiphar\ple-examination-boards-updated\resources\views/GradingSettings/index.blade.php ENDPATH**/ ?>