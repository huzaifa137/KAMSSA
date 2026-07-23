<?php
use App\Http\Controllers\Helper;
?>
@extends('layouts-side-bar.master')
@section('content')

    <style>
        /* ═══════════════════════════════════════════
                                           FONTS & BASE
                                        ═══════════════════════════════════════════ */
        @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap');

        :root {
            --forest: #026837;
            --forest-mid: #1a6b30;
            --green: #287C44;
            --green-light: #3da05a;
            --mint: #e8f5e9;
            --mint-deep: #c8e6c9;
            --amber: #f59e0b;
            --amber-light: #fef3c7;
            --sky: #0ea5e9;
            --sky-light: #e0f2fe;
            --coral: #f43f5e;
            --coral-light: #ffe4e6;
            --slate: #64748b;
            --card-shadow: 0 4px 24px rgba(13, 75, 31, 0.10);
            --card-shadow-hover: 0 12px 40px rgba(13, 75, 31, 0.18);
            --radius: 16px;
            --radius-sm: 10px;
        }

        body,
        .side-app {
            font-family: sans-serif;
            background: #f0f4f1;
        }

        /* ═══════════════════════════════════════════
                                           HERO BANNER
                                        ═══════════════════════════════════════════ */
        .reg-hero {
            background: linear-gradient(135deg, #026837 0%, #1a6b30 45%, #287C44 100%);
            border-radius: 20px;
            padding: 36px 40px 32px;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
        }

        .reg-hero::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 260px;
            height: 260px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .reg-hero::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: 30%;
            width: 320px;
            height: 320px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 50%;
        }

        .reg-hero h1 {
            font-family: 'Syne', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: #fff;
            margin: 0 0 6px;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 1;
        }

        .reg-hero p {
            color: rgba(255, 255, 255, 0.75);
            margin: 0;
            font-size: 14px;
            position: relative;
            z-index: 1;
        }

        .reg-hero .school-chip {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #fff;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            position: relative;
            z-index: 1;
            white-space: nowrap;
        }

        /* ═══════════════════════════════════════════
                                           ANALYTICS STAT CARDS
                                        ═══════════════════════════════════════════ */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        @media(max-width:992px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:576px) {
            .stat-grid {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }
        }

        .stat-card {
            background: #fff;
            border-radius: var(--radius);
            padding: 22px 20px 18px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: 1.5px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--card-shadow-hover);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 0 0 var(--radius) var(--radius);
        }

        .stat-card.amber::after {
            background: var(--amber);
        }

        .stat-card.sky::after {
            background: var(--sky);
        }

        .stat-card.green::after {
            background: var(--green);
        }

        .stat-card.coral::after {
            background: var(--coral);
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 14px;
        }

        .stat-card.amber .stat-icon {
            background: var(--amber-light);
            color: #b45309;
        }

        .stat-card.sky .stat-icon {
            background: var(--sky-light);
            color: #0369a1;
        }

        .stat-card.green .stat-icon {
            background: var(--mint);
            color: var(--forest);
        }

        .stat-card.coral .stat-icon {
            background: var(--coral-light);
            color: #be123c;
        }

        .stat-number {
            font-family: 'Syne', sans-serif;
            font-size: 34px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-card.amber .stat-number {
            color: #b45309;
        }

        .stat-card.sky .stat-number {
            color: #0369a1;
        }

        .stat-card.green .stat-number {
            color: var(--forest);
        }

        .stat-card.coral .stat-number {
            color: #be123c;
        }

        .stat-label {
            font-size: 12px;
            color: var(--slate);
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        /* ═══════════════════════════════════════════
                                           STEP WIZARD NAV
                                        ═══════════════════════════════════════════ */
        .step-nav {
            display: flex;
            gap: 0;
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            margin-bottom: 28px;
            overflow: hidden;
        }

        .step-tab {
            flex: 1;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            border: none;
            background: transparent;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
            position: relative;
        }

        .step-tab:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 20%;
            bottom: 20%;
            width: 1px;
            background: #e9ecef;
        }

        .step-tab.active {
            background: var(--mint);
            border-bottom-color: var(--green);
        }

        .step-tab:hover:not(.active) {
            background: #f8f9fa;
        }

        .step-num {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 13px;
            flex-shrink: 0;
            transition: all 0.3s;
        }

        .step-tab.active .step-num {
            background: var(--green);
            color: #fff;
        }

        .step-tab:not(.active) .step-num {
            background: #e9ecef;
            color: var(--slate);
        }

        .step-tab.done .step-num {
            background: var(--forest);
            color: #fff;
        }

        .step-info {
            text-align: left;
        }

        .step-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 13px;
            color: var(--forest);
            margin: 0;
            line-height: 1.2;
        }

        .step-sub {
            font-size: 11px;
            color: var(--slate);
            margin: 0;
        }

        .step-tab:not(.active) .step-title {
            color: var(--slate);
        }

        /* ═══════════════════════════════════════════
                                           STEP PANELS
                                        ═══════════════════════════════════════════ */
        .step-panel {
            display: none;
            animation: fadeSlide 0.35s ease;
        }

        .step-panel.active {
            display: block;
        }

        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ═══════════════════════════════════════════
                                           MAIN CARD
                                        ═══════════════════════════════════════════ */
        .reg-card {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .reg-card-header {
            background: linear-gradient(135deg, var(--forest) 0%, var(--green) 100%);
            padding: 20px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .reg-card-header h4 {
            font-family: 'Syne', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: #fff;
            margin: 0;
        }

        .reg-card-header .header-badge {
            background: rgba(255, 255, 255, 0.18);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .reg-card-body {
            padding: 28px;
        }

        /* ═══════════════════════════════════════════
                                           SECTION LABELS
                                        ═══════════════════════════════════════════ */
        .form-section-label {
            font-family: 'Syne', sans-serif;
            font-size: 12px;
            font-weight: 700;
            color: var(--green);
            letter-spacing: 1.2px;
            text-transform: uppercase;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--mint-deep);
            margin-bottom: 20px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-section-label i {
            font-size: 13px;
        }

        /* ═══════════════════════════════════════════
                                           FORM CONTROLS
                                        ═══════════════════════════════════════════ */
        .reg-label {
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
            letter-spacing: 0.2px;
        }

        .reg-label .req {
            color: var(--coral);
            margin-left: 2px;
        }

        .reg-input,
        .reg-select {
            border: 1.5px solid #e5e7eb;
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            font-size: 14px;
            color: #111;
            transition: all 0.2s;
            width: 100%;
            background: #fafafa;
            font-family: 'DM Sans', sans-serif;
        }

        .reg-input:focus,
        .reg-select:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(40, 124, 68, 0.12);
            background: #fff;
            outline: none;
        }

        .reg-input[readonly] {
            background: var(--mint);
            color: var(--forest);
            font-weight: 600;
            border-color: var(--mint-deep);
        }

        .student-id-display {
            background: linear-gradient(135deg, var(--mint) 0%, #d1fae5 100%);
            border: 2px dashed var(--green);
            border-radius: var(--radius-sm);
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .student-id-display .id-icon {
            width: 36px;
            height: 36px;
            background: var(--green);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 15px;
            flex-shrink: 0;
        }

        .student-id-display input {
            border: none;
            background: transparent;
            font-family: 'Syne', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--forest);
            width: 100%;
        }

        .student-id-display input:focus {
            outline: none;
        }

        /* ═══════════════════════════════════════════
                                           BUTTONS
                                        ═══════════════════════════════════════════ */
        .btn-primary-reg {
            background: linear-gradient(135deg, var(--green) 0%, var(--forest-mid) 100%);
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-reg:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(40, 124, 68, 0.35);
            color: #fff;
        }

        .btn-secondary-reg {
            background: #fff;
            color: var(--slate);
            border: 1.5px solid #e5e7eb;
            padding: 11px 24px;
            border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-secondary-reg:hover {
            background: #f8f9fa;
            border-color: #d1d5db;
        }

        .btn-filter-reg {
            background: linear-gradient(135deg, var(--green) 0%, var(--forest) 100%);
            color: #fff;
            border: none;
            padding: 10px 22px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 42px;
        }

        .btn-filter-reg:hover {
            box-shadow: 0 4px 14px rgba(40, 124, 68, 0.3);
            transform: translateY(-1px);
        }

        /* ═══════════════════════════════════════════
                                           STATUS BADGES
                                        ═══════════════════════════════════════════ */
        .sbadge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }

        .sbadge-amber {
            background: var(--amber-light);
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .sbadge-sky {
            background: var(--sky-light);
            color: #075985;
            border: 1px solid #bae6fd;
        }

        .sbadge-green {
            background: var(--mint);
            color: var(--forest);
            border: 1px solid var(--mint-deep);
        }

        .sbadge-teal {
            background: #ccfbf1;
            color: #065f46;
            border: 1px solid #99f6e4;
        }

        .sbadge-coral {
            background: var(--coral-light);
            color: #9f1239;
            border: 1px solid #fecdd3;
        }

        /* ═══════════════════════════════════════════
                                           TABLE
                                        ═══════════════════════════════════════════ */
        .reg-table-wrap {
            border-radius: var(--radius-sm);
            overflow: hidden;
            border: 1.5px solid #e9ecef;
        }

        .reg-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .reg-table thead th {
            background: var(--forest);
            color: #fff;
            padding: 13px 16px;
            font-family: 'Syne', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border: none;
        }

        .reg-table tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
            vertical-align: middle;
        }

        .reg-table tbody tr:last-child td {
            border-bottom: none;
        }

        .reg-table tbody tr:hover {
            background: #f8fffe;
        }

        /* DataTable overrides */
        .dataTables_wrapper {
            font-family: 'DM Sans', sans-serif;
        }

        .dataTables_length label,
        .dataTables_filter label {
            font-size: 13px;
            color: var(--slate);
            font-weight: 500;
        }

        .dataTables_length select,
        .dataTables_filter input {
            border: 1.5px solid #e5e7eb !important;
            border-radius: 8px !important;
            padding: 5px 10px !important;
            font-size: 13px !important;
        }

        .dataTables_filter input:focus {
            border-color: var(--green) !important;
            box-shadow: 0 0 0 3px rgba(40, 124, 68, 0.1) !important;
            outline: none !important;
        }

        .dataTables_paginate .paginate_button {
            border-radius: 8px !important;
            border: 1.5px solid #e5e7eb !important;
            color: var(--slate) !important;
            font-size: 13px !important;
            padding: 5px 11px !important;
            margin: 0 2px !important;
            transition: all 0.2s !important;
        }

        .dataTables_paginate .paginate_button.current,
        .dataTables_paginate .paginate_button:hover {
            background: var(--green) !important;
            border-color: var(--green) !important;
            color: #fff !important;
        }

        .dataTables_info {
            font-size: 12px;
            color: var(--slate);
        }

        /* ═══════════════════════════════════════════
                                           PHOTO UPLOAD (keeping existing style)
                                        ═══════════════════════════════════════════ */
        .photo-upload-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: var(--radius);
            padding: 22px;
            border: 2px dashed #d1d5db;
            transition: all 0.3s ease;
        }

        .photo-upload-section:hover {
            border-color: var(--green);
            box-shadow: 0 4px 16px rgba(40, 124, 68, 0.1);
        }

        .photo-upload-label {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            color: var(--forest);
            font-size: 14px;
            margin-bottom: 16px;
            display: block;
            border-left: 4px solid var(--green);
            padding-left: 12px;
        }

        .photo-preview {
            width: 110px;
            height: 130px;
            object-fit: cover;
            border-radius: 12px;
            border: 3px solid #fff;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
            transition: all 0.3s;
        }

        .photo-preview:hover {
            transform: scale(1.03);
            border-color: var(--green);
        }

        .photo-preview-container {
            position: relative;
            display: inline-block;
        }

        .photo-preview-container::after {
            content: '\f030';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.55);
            color: white;
            padding: 6px 10px;
            border-radius: 16px;
            font-size: 11px;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }

        .photo-preview-container:hover::after {
            opacity: 1;
        }

        .photo-actions {
            margin-left: 20px;
            flex: 1;
        }

        .photo-upload-input {
            position: relative;
            margin-bottom: 10px;
        }

        .photo-upload-input input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            z-index: 2;
        }

        .custom-file-upload {
            display: block;
            padding: 10px 18px;
            background: linear-gradient(135deg, var(--green), var(--forest-mid));
            color: #fff;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s;
        }

        .custom-file-upload:hover {
            box-shadow: 0 4px 12px rgba(40, 124, 68, 0.3);
            transform: translateY(-1px);
        }

        .btn-remove-photo {
            display: block;
            width: 100%;
            padding: 9px 16px;
            background: #fff;
            border: 1.5px solid #fecdd3;
            color: #be123c;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }

        .btn-remove-photo:hover {
            background: #be123c;
            color: #fff;
        }

        .file-info {
            font-size: 11px;
            color: var(--slate);
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .upload-status {
            margin-top: 8px;
            font-size: 12px;
            display: none;
        }

        .upload-status.success {
            color: #16a34a;
            display: block;
        }

        .upload-status.error {
            color: #dc2626;
            display: block;
        }

        .upload-status.loading {
            color: #d97706;
            display: block;
        }

        @keyframes photoPulse {
            0% {
                transform: scale(1);
                opacity: 0.7;
            }

            50% {
                transform: scale(1.05);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .photo-preview.updated {
            animation: photoPulse 0.5s ease;
        }

        /* ═══════════════════════════════════════════
                                           STEP 3 — FILTER BAR
                                        ═══════════════════════════════════════════ */
        .filter-bar {
            background: var(--mint);
            border-radius: var(--radius-sm);
            padding: 18px 22px;
            border: 1.5px solid var(--mint-deep);
            margin-bottom: 22px;
            display: flex;
            align-items: flex-end;
            gap: 14px;
            flex-wrap: wrap;
        }

        .filter-bar .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .filter-bar label {
            font-size: 12px;
            font-weight: 600;
            color: var(--forest);
            margin: 0;
        }

        .filter-bar select {
            border: 1.5px solid var(--mint-deep);
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 13px;
            background: #fff;
            color: #111;
            min-width: 160px;
            font-family: 'DM Sans', sans-serif;
        }

        .filter-bar select:focus {
            border-color: var(--green);
            outline: none;
            box-shadow: 0 0 0 3px rgba(40, 124, 68, 0.1);
        }

        /* ═══════════════════════════════════════════
                                           EMPTY STATE
                                        ═══════════════════════════════════════════ */
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: var(--slate);
        }

        .empty-state .empty-icon {
            width: 72px;
            height: 72px;
            background: var(--mint);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: var(--green);
            margin: 0 auto 18px;
        }

        .empty-state h5 {
            font-family: 'Syne', sans-serif;
            color: var(--forest);
            font-size: 16px;
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: 13px;
            margin: 0;
        }

        /* ═══════════════════════════════════════════
                                           SWAL Z-INDEX FIXES
                                        ═══════════════════════════════════════════ */
        .swal2-container {
            z-index: 9999 !important;
        }

        .swal2-popup {
            z-index: 10000 !important;
        }

        .modal {
            z-index: 1050;
        }

        .modal-backdrop {
            z-index: 1040;
        }

        body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) {
            overflow-y: hidden !important;
        }

        .modal-open .swal2-container {
            z-index: 10000 !important;
        }

        /* ═══════════════════════════════════════════
                                           RESPONSIVE
                                        ═══════════════════════════════════════════ */
        @media(max-width:768px) {
            .reg-hero {
                padding: 24px 20px 20px;
            }

            .reg-hero h1 {
                font-size: 20px;
            }

            .reg-card-body {
                padding: 20px 16px;
            }

            .step-tab .step-info {
                display: none;
            }

            .step-tab {
                justify-content: center;
            }

            .filter-bar {
                flex-direction: column;
            }

            .filter-bar select {
                min-width: 100%;
            }

            .photo-actions {
                margin-left: 0;
                margin-top: 14px;
                width: 100%;
            }
        }

        /* Warning/Yellow stat card */
        .stat-card.warning::after {
            background: #f59e0b !important;
            height: 3px !important;
        }

        .stat-card.warning .stat-icon {
            background: #fef3c7 !important;
            color: #b45309 !important;
        }

        .stat-card.warning .stat-number {
            color: #b45309 !important;
        }

        /* Purple stat card */
        .stat-card.purple::after {
            background: #8b5cf6 !important;
            height: 3px !important;
        }

        .stat-card.purple .stat-icon {
            background: #ede9fe !important;
            color: #6d28d9 !important;
        }

        .stat-card.purple .stat-number {
            color: #6d28d9 !important;
        }

        /* Make photo preview clickable for upload */
        .clickable-photo-preview {
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }

        .clickable-photo-preview:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .clickable-photo-preview::after {
            content: '\f030';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
            white-space: nowrap;
        }

        .clickable-photo-preview:hover::after {
            content: '\f030 Click to change photo';
            opacity: 1;
        }

        /* Document preview styles */
        .document-preview-container {
            position: relative;
            display: inline-block;
        }

        .document-preview {
            width: 110px;
            height: 130px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            border: 3px solid #fff;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 10px;
        }

        .document-preview:hover {
            transform: scale(1.03);
            border-color: var(--green);
        }

        .document-preview i {
            font-size: 48px;
            margin-bottom: 8px;
        }

        .document-preview span {
            font-size: 11px;
            color: var(--slate);
            word-break: break-all;
            max-width: 90px;
        }

        .file-name {
            background: var(--mint);
            padding: 6px 12px;
            border-radius: 8px;
            display: inline-block;
            font-size: 11px;
        }

        /* PDF specific */
        .document-preview.pdf i {
            color: #dc2626;
        }

        /* Image specific */
        .document-preview.image {
            padding: 0;
            overflow: hidden;
        }

        .document-preview.image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Word document */
        .document-preview.word i {
            color: #2b5797;
        }

        /* Excel document */
        .document-preview.excel i {
            color: #217346;
        }
    </style>

    <div class="side-app" style="padding: 20px;">

        {{-- ══════════════════════════════
        HERO BANNER
        ══════════════════════════════ --}}
        <div class="reg-hero d-flex justify-content-between align-items-center flex-wrap" style="gap:16px;">
            <div>
                <h1><i class="fas fa-user-graduate" style="opacity:0.85; margin-right:10px;"></i>Student Registration Portal
                </h1>
                <p>Register new students, attach photos, and submit for admin approval — all in one place.</p>
            </div>
            <div class="school-chip">
                <i class="fas fa-school mr-2"></i>{{ $school->House }}
            </div>
        </div>

        {{-- ══════════════════════════════
        ANALYTICS STAT CARDS
        (loaded via JS after page load)
        ══════════════════════════════ --}}
        <div class="stat-grid" id="analyticsGrid">
            <div class="stat-card purple">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-number" id="stat-pending-photo">—</div>
                <div class="stat-label">Pending Photo Attachment</div>
            </div>
            <div class="stat-card sky">
                <div class="stat-icon"><i class="fas fa-image"></i></div>
                <div class="stat-number" id="stat-attached">—</div>
                <div class="stat-label">Image Attached, Awaiting Submit</div>
            </div>
            <div class="stat-card warning">
                <div class="stat-icon">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div class="stat-number" id="stat-submitted">—</div>
                <div class="stat-label">Submitted for Admin Approval</div>
            </div>
            <div class="stat-card green">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-number" id="stat-approved">—</div>
                <div class="stat-label">Approved & Enrolled</div>
            </div>
            <div class="stat-card coral">
                <div class="stat-icon"><i class="fas fa-ticket-alt"></i></div>
                <div class="stat-number" id="stat-slots-remaining">—</div>
                <div class="stat-label">Registration Slots Left</div>
            </div>
        </div>

        {{-- Registration Status Banner (slots / period) --}}
        <div id="regStatusBanner"
            style="display:none; margin-bottom:18px; border-radius:12px; padding:14px 20px; font-size:13px; font-weight:600;">
        </div>

        {{-- ══════════════════════════════
        STEP WIZARD TABS
        ══════════════════════════════ --}}
        <div class="step-nav">
            <button class="step-tab active" onclick="switchStep(1, this)">
                <div class="step-num">1</div>
                <div class="step-info">
                    <p class="step-title">Register Student</p>
                    <p class="step-sub">Fill in student details</p>
                </div>
            </button>
            <button class="step-tab" onclick="switchStep(2, this)">
                <div class="step-num">2</div>
                <div class="step-info">
                    <p class="step-title">Registered Students</p>
                    <p class="step-sub">View & manage records</p>
                </div>
            </button>
            <button class="step-tab" onclick="switchStep(3, this)">
                <div class="step-num">3</div>
                <div class="step-info">
                    <p class="step-title">Submit for Approval</p>
                    <p class="step-sub">Send to admin review</p>
                </div>
            </button>
        </div>

        {{-- ══════════════════════════════════════════════════════
        STEP 1 — REGISTER STUDENT
        ══════════════════════════════════════════════════════ --}}
        <div class="step-panel active" id="panel-1">
            <div class="reg-card">
                <div class="reg-card-header">
                    <h4><i class="fas fa-user-plus mr-2"></i>New Student Registration</h4>
                    <span class="header-badge"><i class="fas fa-info-circle mr-1"></i>Step 1 of 3</span>
                </div>
                <div class="reg-card-body">

                    <form id="schoolRegistrationForm">
                        @csrf

                        {{-- Identity & ID --}}
                        <div class="form-section-label"><i class="fas fa-id-card"></i> Student Identity & Classification
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="reg-label">Category <span class="req">*</span></label>
                                <select name="category" id="category" class="reg-select select2" required>
                                    <option value="">-- Select Category --</option>
                                    @include('partials.examination-level-options', ['show_group' => false])
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="reg-label">Admission Year <span class="req">*</span></label>
                                <select name="admission_year" id="admission_year" class="reg-select select2" required>
                                    <option value="">-- Select Year --</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year->year_en }}" {{ $year->year_en == $currentYear ? 'selected' : '' }}>
                                            {{ $year->year_en }} - {{ $year->year_ar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="reg-label">Student ID <span class="req">*</span> <span
                                        style="font-weight:400;color:var(--slate);">(Auto-generated)</span></label>
                                <div class="student-id-display">
                                    <div class="id-icon"><i class="fas fa-hashtag"></i></div>
                                    <input type="text" name="student_id" id="student_id" readonly required
                                        placeholder="Select category & year above…">
                                </div>
                            </div>
                        </div>

                        {{-- Names --}}
                        <div class="form-section-label mt-2"><i class="fas fa-user"></i> Student Name</div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="reg-label">Full Name (English) <span class="req">*</span></label>
                                <input type="text" name="student_name" class="reg-input" placeholder="e.g. BUKENYA HUZAIFA"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="reg-label">Full Name (Arabic)</label>
                                <input type="text" name="student_name_ar" class="reg-input"
                                    placeholder="أدخل اسم الطالب بالعربية" dir="rtl">
                            </div>
                        </div>

                        {{-- Personal --}}
                        <div class="form-section-label mt-2"><i class="fas fa-info-circle"></i> Personal Information</div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="reg-label">Gender <span class="req">*</span></label>
                                <select name="student_sex" class="reg-select select2" required>
                                    <option value="">-- Select Gender --</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="reg-label">Date of Birth</label>
                                <input type="date" name="date_of_birth" class="reg-input">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="reg-label">Nationality</label>
                                <input type="text" name="student_nationality" class="reg-input" placeholder="e.g. UGANDAN">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="reg-label">Birth Place</label>
                                <input type="text" name="birth_place" class="reg-input" placeholder="Enter birth place">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="reg-label">Birth Place (Arabic)</label>
                                <input type="text" name="birth_place_ar" class="reg-input"
                                    placeholder="أدخل مكان الميلاد بالعربية" dir="rtl">
                            </div>
                        </div>

                        {{-- Academic --}}
                        <div class="form-section-label mt-2"><i class="fas fa-graduation-cap"></i> Academic Details</div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="reg-label">Class</label>
                                <input type="text" name="class" id="student_class" class="reg-input" readonly
                                    placeholder="Auto-filled from category">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="reg-label">SubCounty</label>
                                <input type="text" name="SubCounty" class="reg-input" placeholder="Enter SubCounty">
                            </div>
                            <div class="col-md-4 mb-3 d-none">
                                <label class="reg-label">Section</label>
                                <select name="section" class="reg-select select2" disabled>
                                    <option value="">-- Select Section --</option>
                                    <option value="Day">Day</option>
                                    <option value="Boarding" selected>Boarding</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="reg-label">District</label>
                                <input type="text" name="district" class="reg-input" placeholder="Enter district">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="reg-label">District (Arabic)</label>
                                <input type="text" name="district_ar" class="reg-input" placeholder="أدخل المنطقة بالعربية"
                                    dir="rtl">
                            </div>
                        </div>

                        <hr style="border-color:#f1f5f9; margin: 24px 0;">

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn-secondary-reg" onclick="window.history.back()">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="submit" class="btn-primary-reg">
                                <i class="fas fa-paper-plane"></i> Submit Registration
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════
        STEP 2 — ALL REGISTERED STUDENTS
        ══════════════════════════════════════════════════════ --}}
        <div class="step-panel" id="panel-2">
            <div class="reg-card">
                <div class="reg-card-header">
                    <h4><i class="fas fa-list-alt mr-2"></i>All Registered Students</h4>
                    <span class="header-badge"><i class="fas fa-clock mr-1"></i>Step 2 of 3</span>
                </div>
                <div class="reg-card-body">
                    <div class="reg-table-wrap" style="overflow:auto;">
                        <table class="reg-table table table-bordered" id="recentRegistrations">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Photo</th>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Year</th>
                                    <th>Status</th>
                                    <th>Date of Birth</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="registrationTableBody">
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="fas fa-spinner fa-spin mr-2"></i> Loading registrations…
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════
        STEP 3 — SUBMIT FOR APPROVAL
        ══════════════════════════════════════════════════════ --}}
        <div class="step-panel" id="panel-3">
            <div class="reg-card">
                <div class="reg-card-header">
                    <h4><i class="fas fa-paper-plane mr-2"></i>Submit Students for Admin Approval</h4>
                    <span class="header-badge"><i class="fas fa-shield-alt mr-1"></i>Step 3 of 3</span>
                </div>
                <div class="reg-card-body">

                    <div class="alert"
                        style="background:var(--sky-light);border:1px solid #bae6fd;border-radius:var(--radius-sm);color:#075985;font-size:13px;padding:13px 18px;margin-bottom:22px;">
                        <i class="fas fa-info-circle mr-2"></i>
                        Filter students by <strong>Admission Year</strong> and <strong>Category</strong> to find those with
                        attached photos ready for admin submission.
                    </div>

                    {{-- Filter Bar --}}
                    <div class="filter-bar">
                        <div class="filter-group">
                            <label><i class="fas fa-calendar-alt mr-1"></i> Admission Year <span
                                    style="color:var(--coral);">*</span></label>
                            <select id="step3_year">
                                <option value="">-- Select Year --</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year->year_en }}" {{ $year->year_en == $currentYear ? 'selected' : '' }}>
                                        {{ $year->year_en }} - {{ $year->year_ar }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-group">
                            <label><i class="fas fa-tag mr-1"></i> Category <span
                                    style="color:var(--coral);">*</span></label>
                            <select id="step3_category">
                                <option value="">-- Select Category --</option>
                                @include('partials.examination-level-options', ['show_group' => false])
                            </select>
                        </div>
                        <button class="btn-filter-reg" id="step3_filter_btn">
                            <i class="fas fa-search"></i> Filter Students
                        </button>
                    </div>

                    {{-- Results Table --}}
                    <div id="step3_table_wrapper" style="display:none;">
                        <div class="reg-table-wrap" style="overflow:auto; margin-bottom:24px;">
                            <table class="reg-table table table-bordered" id="step3Table">
                                <thead>
                                    <tr>
                                        <th style="width:44px;">
                                            <input type="checkbox" id="step3_check_all" title="Select All"
                                                style="cursor:pointer; width:16px; height:16px;">
                                        </th>
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Date of Birth</th>
                                    </tr>
                                </thead>
                                <tbody id="step3TableBody"></tbody>
                            </table>
                        </div>

                        {{-- Supporting Document Upload --}}
                        <div class="photo-upload-section">
                            <span class="photo-upload-label">
                                <i class="fas fa-file-alt mr-2"></i>Attach Supporting Document / Cover File
                            </span>
                            <div class="d-flex align-items-center" style="gap:20px; flex-wrap:wrap;">
                                <div class="document-preview-container" style="position: relative;">
                                    <div id="step3_doc_preview" class="document-preview">
                                        <i class="fas fa-file-pdf" style="font-size: 48px; color: #dc2626;"></i>
                                        <span style="font-size: 12px; margin-top: 8px;">No file selected</span>
                                    </div>
                                </div>
                                <div class="photo-actions" style="flex:1; min-width:200px;">
                                    <div class="row no-gutters" style="gap:8px; flex-wrap:wrap;">
                                        <div class="col" style="min-width:140px;">
                                            <div class="photo-upload-input">
                                                <input type="file" id="step3_doc_input"
                                                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx,.txt">
                                                <div class="custom-file-upload"><i class="fas fa-upload mr-1"></i> Choose
                                                    File</div>
                                            </div>
                                        </div>
                                        <div class="col" style="min-width:140px;">
                                            <button type="button" id="step3_remove_doc_btn" class="btn-remove-photo">
                                                <i class="fas fa-trash-alt mr-1"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                    <div class="file-info">
                                        <i class="fas fa-info-circle"></i>
                                        <span>Supported: JPG, PNG, PDF, DOC, DOCX, XLS, XLSX, TXT — Max 5MB</span>
                                    </div>
                                    <div id="step3_file_name" class="file-name"
                                        style="font-size: 12px; color: var(--green); margin-top: 5px; display: none;"></div>
                                    <div id="step3_upload_status" class="upload-status"></div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" id="step3_submit_btn" class="btn-primary-reg" style="padding:13px 36px;">
                                <i class="fas fa-paper-plane"></i> Submit Selected Students for Approval
                            </button>
                        </div>
                    </div>

                    {{-- Empty State --}}
                    <div id="step3_empty" style="display:none;">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                            <h5>No Students Found</h5>
                            <p>No students with "Attached Image, Pending Submission" status match your selected filters.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>{{-- /side-app --}}


    {{-- ══════════════════════════════════════════════════════
    EDIT STUDENT MODAL
    ══════════════════════════════════════════════════════ --}}
    <div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border-radius:16px; overflow:hidden; border:none;">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #026837, #287C44); color: white; border:none; padding:20px 28px;">
                    <h5 class="modal-title" id="editStudentModalLabel"
                        style="font-family:'Syne',sans-serif; font-weight:700; margin:0;">
                        <i class="fas fa-edit mr-2"></i> Edit Student Registration
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"
                        style="opacity:1;">
                        <span aria-hidden="true" style="font-size:22px;">&times;</span>
                    </button>
                </div>
                <form id="editStudentForm">
                    {{-- Photo Upload in Modal --}}
                    <div style="background:#f8f9fa; padding:20px 28px; border-bottom:1px solid #f1f5f9;">
                        <span class="photo-upload-label" style="font-size:13px; margin-bottom:14px;">
                            <i class="fas fa-camera mr-2"></i>Student Photo
                        </span>
                        <div class="d-flex align-items-center" style="gap:20px; flex-wrap:wrap;">
                            <div class="photo-preview-container">
                                <img id="edit_photo_preview" src="" class="photo-preview"
                                    onerror="this.src='/assets/images/default-user.jpg';">
                            </div>
                            <div class="photo-actions" style="flex:1; min-width:180px;">
                                <div class="row no-gutters" style="gap:8px;">
                                    <div class="col">
                                        <div class="photo-upload-input">
                                            <input type="file" id="edit_photo_input"
                                                accept="image/jpeg,image/jpg,image/png">
                                            <div class="custom-file-upload"><i class="fas fa-upload mr-1"></i> Choose Photo
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <button type="button" id="remove_photo_btn" class="btn-remove-photo">
                                            <i class="fas fa-trash-alt mr-1"></i> Remove
                                        </button>
                                    </div>
                                </div>
                                <div class="file-info"><i class="fas fa-info-circle"></i><span>JPG, PNG — Max 2MB</span>
                                </div>
                                <div id="upload_status" class="upload-status"></div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-body" style="padding:24px 28px;">
                        <input type="hidden" name="edit_id" id="edit_id">
                        <input type="hidden" name="edit_student_id" id="edit_student_id">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="reg-label">Category <span class="req">*</span></label>
                                <select name="edit_category" id="edit_category" class="reg-select" required disabled>
                                    <option value="">-- Select Category --</option>
                                    @include('partials.examination-level-options', ['show_group' => false])
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="reg-label">Admission Year <span class="req">*</span></label>
                                <select name="edit_admission_year" id="edit_admission_year" class="reg-select" required
                                    disabled>
                                    <option value="">-- Select Year --</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year->year_en }}">{{ $year->year_en }} - {{ $year->year_ar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="reg-label">Student Name <span class="req">*</span></label>
                                <input type="text" name="edit_student_name" id="edit_student_name" class="reg-input"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="reg-label">Student Name (Arabic)</label>
                                <input type="text" name="edit_student_name_ar" id="edit_student_name_ar" class="reg-input"
                                    dir="rtl">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="reg-label">Gender <span class="req">*</span></label>
                                <select name="edit_student_sex" id="edit_student_sex" class="reg-select" required>
                                    <option value="">-- Select --</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="reg-label">Date of Birth</label>
                                <input type="date" name="edit_date_of_birth" id="edit_date_of_birth" class="reg-input">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="reg-label">Nationality</label>
                                <input type="text" name="edit_student_nationality" id="edit_student_nationality"
                                    class="reg-input">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="reg-label">Birth Place</label>
                                <input type="text" name="edit_birth_place" id="edit_birth_place" class="reg-input">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="reg-label">Birth Place (Arabic)</label>
                                <input type="text" name="edit_birth_place_ar" id="edit_birth_place_ar" class="reg-input"
                                    dir="rtl">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="reg-label">Class</label>
                                <input type="text" name="edit_class" id="edit_class" class="reg-input" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="reg-label">Section</label>
                                <select name="edit_section" id="edit_section" class="reg-select">
                                    <option value="">-- Select --</option>
                                    <option value="Day">Day</option>
                                    <option value="Boarding">Boarding</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="reg-label">District</label>
                                <input type="text" name="edit_district" id="edit_district" class="reg-input">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="reg-label">District (Arabic)</label>
                                <input type="text" name="edit_district_ar" id="edit_district_ar" class="reg-input"
                                    dir="rtl">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:16px 28px;">
                        <button type="button" class="btn-secondary-reg" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn-primary-reg">
                            <i class="fas fa-save"></i> Update Registration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    @section('js')
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function () {

                // ── Select2 init ──────────────────────────────
                $('.select2').select2({ theme: 'bootstrap4', width: '100%' });

                let dataTable;
                let currentPhotoFile = null;

                // ── Step Tab Switching ─────────────────────────
                window.switchStep = function (num, el) {
                    document.querySelectorAll('.step-tab').forEach(t => t.classList.remove('active'));
                    document.querySelectorAll('.step-panel').forEach(p => p.classList.remove('active'));
                    el.classList.add('active');
                    document.getElementById('panel-' + num).classList.add('active');
                    // Reload table when switching to step 2
                    if (num === 2 && !$.fn.DataTable.isDataTable('#recentRegistrations')) {
                        loadRecentRegistrations();
                    }
                };

                // ── Load Analytics Stats ──────────────────────
                function loadAnalytics() {
                    $.ajax({
                        url: '{{ route("school.recent.registrations") }}',
                        method: 'GET',
                        success: function (response) {
                            const regs = response.registrations || [];
                            let pendingPhoto = 0, attached = 0, submitted = 0, approved = 0;
                            regs.forEach(r => {
                                if (r.status === 'Pending Photo Submission') pendingPhoto++;
                                else if (r.status === 'Attached Image, Pending Submission') attached++;
                                else if (r.status === 'Pending Admin Approval') submitted++;
                                else if (r.status === 'Approved') approved++;
                            });
                            animateNumber('stat-pending-photo', pendingPhoto);
                            animateNumber('stat-attached', attached);
                            animateNumber('stat-submitted', submitted);
                            animateNumber('stat-approved', approved);

                            // ── Slot + registration period banner ──────────────
                            const slot = response.slot || null;
                            const globalOpen = response.global_open || false;
                            const banner = $('#regStatusBanner');

                            if (slot) {
                                animateNumber('stat-slots-remaining', slot.slots_remaining);

                                const effectiveOpen = globalOpen || slot.registration_open;

                                if (slot.slots_remaining === 0) {
                                    banner.css({ background: '#fef2f2', border: '1.5px solid #fca5a5', color: '#991b1b' });
                                    banner.html('<i class="fas fa-exclamation-triangle mr-2"></i><strong>All ' + slot.slots_allocated + ' allocated slots have been used.</strong> Contact the admin to request more slots.');
                                } else if (effectiveOpen) {
                                    banner.css({ background: '#f0fdf4', border: '1.5px solid #86efac', color: '#166534' });
                                    const src = globalOpen ? 'Global registration is open' : 'Registration opened for your school by admin';
                                    banner.html('<i class="fas fa-unlock-alt mr-2"></i>' + src + ' &mdash; <strong>' + slot.slots_remaining + '</strong> slot(s) remaining of <strong>' + slot.slots_allocated + '</strong> allocated.');
                                } else {
                                    banner.css({ background: '#fff7ed', border: '1.5px solid #fed7aa', color: '#9a3412' });
                                    banner.html('<i class="fas fa-lock mr-2"></i>Registration is currently <strong>closed</strong>. Contact the admin to open registration for your school.');
                                }
                                banner.show();
                            } else {
                                $('#stat-slots-remaining').text('0');
                                banner.css({ background: '#fef2f2', border: '1.5px solid #fca5a5', color: '#991b1b' });
                                banner.html('<i class="fas fa-exclamation-circle mr-2"></i>No registration slots have been allocated to your school yet. Please contact the admin.');
                                banner.show();
                            }
                        }
                    });
                }


                function animateNumber(id, target) {
                    const el = document.getElementById(id);
                    let current = 0;
                    const step = Math.ceil(target / 20);
                    const timer = setInterval(() => {
                        current = Math.min(current + step, target);
                        el.textContent = current;
                        if (current >= target) clearInterval(timer);
                    }, 40);
                }

                loadAnalytics();

                // ── Student ID Generation ─────────────────────
                function updateStudentID() {
                    let category = $('select[name="category"]').val();
                    let year = $('select[name="admission_year"]').val();
                    if (category && year) {
                        $.ajax({
                            url: '{{ route("school.generate.student.id") }}',
                            method: 'GET',
                            data: { category, year },
                            success: r => $('#student_id').val(r.student_id),
                            error: () => $('#student_id').val('')
                        });
                    } else {
                        $('#student_id').val('');
                    }
                }

                $('#category').on('change', function () {
                    const cat = $(this).val();
                    if (cat === 'ID') $('#student_class').val('Senior Four / ضصثقف');
                    else if (cat === 'TH') $('#student_class').val('Senior Six / الثانوية');
                    else $('#student_class').val('');
                });

                $('select[name="category"], select[name="admission_year"]').on('change', updateStudentID);

                // ── Load Recent Registrations ─────────────────
                function loadRecentRegistrations() {
                    $.ajax({
                        url: '{{ route("school.recent.registrations") }}',
                        method: 'GET',
                        success: function (response) {
                            let html = '';
                            if (response.registrations && response.registrations.length > 0) {
                                response.registrations.forEach(function (reg, index) {
                                    let badge = '';
                                    if (reg.status === 'Pending Photo Submission') badge = '<span class="sbadge sbadge-amber"><i class="fas fa-clock"></i> Pending Photo</span>';
                                    else if (reg.status === 'Attached Image, Pending Submission') badge = '<span class="sbadge sbadge-teal"><i class="fas fa-image"></i> Image Attached</span>';
                                    else if (reg.status === 'Pending Admin Approval') badge = '<span class="sbadge sbadge-sky"><i class="fas fa-paper-plane"></i> Submitted</span>';
                                    else if (reg.status === 'Approved') badge = '<span class="sbadge sbadge-green"><i class="fas fa-check-circle"></i> Approved</span>';
                                    else if (reg.status === 'Returned') badge = '<span class="sbadge sbadge-coral"><i class="fas fa-undo"></i> Returned \u2014 Edit & Resubmit</span>';

                                    html += `
                                                    <tr>
                                                        <td>${index + 1}</td>
                                                        <td class="clickable-photo" style="cursor: pointer;" data-id="${reg.id}" data-student-id="${reg.student_id}">
                                                            <img src="/assets/student_photos/${reg.student_id}.jpg"
                                                                 onerror="this.src='/assets/images/default-user.jpg';"
                                                                 style="width:46px;height:58px;object-fit:cover;border-radius:8px;border:2px solid #e9ecef;">
                                                        </td>
                                                        <td><code style="font-size:12px;color:var(--forest);background:var(--mint);padding:3px 7px;border-radius:6px;">${reg.student_id}</code></td>
                                                        <td>
                                                            <span style="font-weight:600;font-size:13px;">${reg.student_name}</span>
                                                            ${reg.student_name_ar ? `<br><small style="color:var(--slate);font-size:11px;">${reg.student_name_ar}</small>` : ''}
                                                        </td>
                                                        <td>${reg.class ?? '-'}</td>
                                                        <td><span style="font-weight:600;">${reg.admission_year}</span></td>
                                                        <td>${badge}</td>
                                                        <td>${reg.date_of_birth ? reg.date_of_birth.split('-').reverse().join('/') : '-'}</td>
                                                        <td>
                                                            <div style="display:flex; gap:6px; flex-wrap:nowrap; align-items:center;">
                                                                ${reg.is_locked
                                            ? `<span style="font-size:12px; color:#16a34a; background:#dcfce7; border:1px solid #86efac; border-radius:20px; padding:4px 10px; font-weight:600; white-space:nowrap;">
                                                                           <i class="fas fa-lock mr-1"></i>Locked
                                                                       </span>`
                                            : `<button class="btn btn-sm btn-primary edit-student"
                                                                               data-id="${reg.id}"
                                                                               data-student-id="${reg.student_id}"
                                                                               style="border-radius:7px; white-space:nowrap;"
                                                                               title="Edit">
                                                                           <i class="fas fa-edit mr-1"></i> Edit
                                                                       </button>
                                                                       <button class="btn btn-sm btn-danger delete-student"
                                                                               data-id="${reg.student_id}"
                                                                               style="border-radius:7px; white-space:nowrap;"
                                                                               title="Delete">
                                                                           <i class="fas fa-trash mr-1"></i> Delete
                                                                       </button>`
                                        }
                                                            </div>
                                                        </td>

                                                    </tr>`;
                                });
                            } else {
                                html = `<tr><td colspan="9" class="text-center text-muted py-5">
                                                                                                <i class="fas fa-inbox fa-2x d-block mb-2" style="color:#d1d5db;"></i>No registrations yet
                                                                                            </td></tr>`;
                            }

                            $('#registrationTableBody').html(html);

                            if ($.fn.DataTable.isDataTable('#recentRegistrations')) {
                                $('#recentRegistrations').DataTable().clear().destroy();
                            }
                            dataTable = $('#recentRegistrations').DataTable({
                                pageLength: 10,
                                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                                searching: true, ordering: true, order: [[0, 'asc']],
                                language: {
                                    search: "Search:", searchPlaceholder: "Type to search…",
                                    emptyTable: "No registrations found",
                                    info: "Showing _START_–_END_ of _TOTAL_ records",
                                    infoEmpty: "0 records",
                                    lengthMenu: "Show _MENU_",
                                    paginate: {
                                        first: '«', last: '»',
                                        previous: '‹', next: '›'
                                    }
                                },
                                dom: '<"row mb-2"<"col-sm-6"l><"col-sm-6"f>><"row"<"col-sm-12"tr>><"row mt-2"<"col-sm-5"i><"col-sm-7"p>>'
                            });

                            // Refresh analytics after load
                            loadAnalytics();
                        },
                        error: function () {
                            $('#registrationTableBody').html('<tr><td colspan="9" class="text-center text-danger">Error loading registrations</td></tr>');
                        }
                    });
                }

                loadRecentRegistrations();

                // ── Delete Student ────────────────────────────
                $(document).on('click', '.delete-student', function () {
                    const studentId = $(this).data('id');
                    Swal.fire({
                        title: 'Delete Student?',
                        html: `Are you sure you want to delete Student ID:<br><b>${studentId}</b>?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#287C44',
                        confirmButtonText: 'Yes, delete!',
                    }).then(result => {
                        if (!result.isConfirmed) return;
                        Swal.fire({ title: 'Deleting…', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                        $.ajax({
                            url: '{{ route("school.delete.registration") }}',
                            method: 'POST',
                            data: { student_id: studentId, _token: '{{ csrf_token() }}' },
                            success: r => Swal.fire({ icon: 'success', title: 'Deleted!', html: `Student <b>${studentId}</b> removed.`, confirmButtonColor: '#287C44' }).then(() => location.reload()),
                            error: xhr => Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message || 'Failed to delete', confirmButtonColor: '#dc2626' })
                        });
                    });
                });

                // ── Registration Form Submit ───────────────────
                $('#schoolRegistrationForm').on('submit', function (e) {
                    e.preventDefault();
                    const $form = $(this);
                    const required = ['category', 'admission_year', 'student_id', 'student_name', 'student_sex'];
                    let valid = true;
                    required.forEach(f => {
                        const inp = $form.find(`[name="${f}"]`);
                        if (!inp.val()) { inp.addClass('is-invalid'); valid = false; }
                        else inp.removeClass('is-invalid');
                    });
                    if (!valid) { Swal.fire({ icon: 'error', title: 'Missing Fields', text: 'Please fill in all required fields', confirmButtonColor: '#287C44' }); return; }

                    Swal.fire({
                        title: 'Submit Registration?',
                        text: 'Are you sure you want to submit this student registration?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#287C44', cancelButtonColor: '#dc2626',
                        confirmButtonText: 'Yes, submit!'
                    }).then(result => {
                        if (!result.isConfirmed) return;
                        Swal.fire({ title: 'Submitting…', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                        $.ajax({
                            url: '{{ route("school.store.registration") }}',
                            method: 'POST',
                            data: {
                                category: $form.find('[name="category"]').val(),
                                admission_year: $form.find('[name="admission_year"]').val(),
                                student_id: $form.find('[name="student_id"]').val(),
                                student_name: $form.find('[name="student_name"]').val(),
                                student_name_ar: $form.find('[name="student_name_ar"]').val(),
                                date_of_birth: $form.find('[name="date_of_birth"]').val(),
                                student_sex: $form.find('[name="student_sex"]').val(),
                                student_nationality: $form.find('[name="student_nationality"]').val(),
                                birth_place: $form.find('[name="birth_place"]').val(),
                                birth_place_ar: $form.find('[name="birth_place_ar"]').val(),
                                class: $form.find('[name="class"]').val(),
                                section: $form.find('[name="section"]').val(),
                                district: $form.find('[name="district"]').val(),
                                district_ar: $form.find('[name="district_ar"]').val(),
                            },
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            success: r => Swal.fire({ icon: 'success', title: 'Success!', text: r.message, confirmButtonColor: '#287C44' }).then(res => { if (res.isConfirmed) location.reload(); }),
                            error: xhr => Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message || 'Something went wrong', confirmButtonColor: '#287C44' })
                        });
                    });
                });

                // ── Edit Student ──────────────────────────────
                $(document).on('click', '.edit-student', function () {
                    const regId = $(this).data('id');
                    const studentId = $(this).data('student-id');
                    $.ajax({
                        url: '{{ route("school.get.registration") }}',
                        method: 'GET',
                        data: { id: regId, student_id: studentId },
                        success: function (r) {
                            $('#edit_photo_preview').attr('src', '/assets/student_photos/' + r.registration.student_id + '.jpg?v=' + Date.now());
                            $('#edit_photo_input').val('');
                            currentPhotoFile = null;
                            $('#edit_id').val(r.registration.id);
                            $('#edit_student_id').val(r.registration.student_id);
                            $('#edit_category').val(r.registration.category);
                            $('#edit_admission_year').val(r.registration.admission_year);
                            $('#edit_student_name').val(r.registration.student_name);
                            $('#edit_student_name_ar').val(r.registration.student_name_ar || '');
                            $('#edit_student_sex').val(r.registration.student_sex);
                            $('#edit_date_of_birth').val(r.registration.date_of_birth || '');
                            $('#edit_student_nationality').val(r.registration.student_nationality || '');
                            $('#edit_birth_place').val(r.registration.birth_place || '');
                            $('#edit_birth_place_ar').val(r.registration.birth_place_ar || '');
                            $('#edit_class').val(r.registration.category === 'ID' ? 'Senior Four / ضصثقف' : 'Senior Six / الثانوية');
                            $('#edit_section').val(r.registration.section || '');
                            $('#edit_district').val(r.registration.district || '');
                            $('#edit_district_ar').val(r.registration.district_ar || '');
                            $('#editStudentModal').modal('show');
                        },
                        error: () => Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load student data', confirmButtonColor: '#dc2626' })
                    });
                });

                $(document).on('change', '#edit_category', function () {
                    const cat = $(this).val();
                    $('#edit_class').val(cat === 'ID' ? 'Senior Four / ضصثقف' : cat === 'TH' ? 'Senior Six / الثانوية' : '');
                });

                // ── Edit Photo Preview ────────────────────────
                $('#edit_photo_input').on('change', function (e) {
                    const file = e.target.files[0];
                    if (!file) return;
                    if (!['image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) {
                        Swal.fire({ icon: 'error', title: 'Invalid File', text: 'Please select JPG or PNG.', confirmButtonColor: '#287C44' });
                        $(this).val(''); return;
                    }
                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire({ icon: 'error', title: 'Too Large', text: 'Max 2MB.', confirmButtonColor: '#287C44' });
                        $(this).val(''); return;
                    }
                    $('#upload_status').removeClass('success error').addClass('loading').html('<i class="fas fa-spinner fa-spin"></i> Loading…').show();
                    const reader = new FileReader();
                    reader.onload = e => {
                        $('#edit_photo_preview').attr('src', e.target.result).addClass('updated');
                        setTimeout(() => $('#edit_photo_preview').removeClass('updated'), 500);
                        $('#upload_status').removeClass('loading error').addClass('success').html('<i class="fas fa-check-circle"></i> Loaded!').show();
                        setTimeout(() => $('#upload_status').fadeOut(), 3000);
                        currentPhotoFile = file;
                    };
                    reader.readAsDataURL(file);
                });

                // Make photo preview clickable to trigger file upload
                $('#edit_photo_preview').addClass('clickable-photo-preview');

                // Click on photo preview to trigger file input
                $(document).on('click', '#edit_photo_preview', function () {
                    $('#edit_photo_input').click();
                });

                // Optional: Add drag and drop functionality directly on the photo preview
                const photoPreviewContainer = document.querySelector('#edit_photo_preview');
                if (photoPreviewContainer) {
                    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(ev =>
                        photoPreviewContainer.addEventListener(ev, (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                        }, false)
                    );

                    ['dragenter', 'dragover'].forEach(ev =>
                        photoPreviewContainer.addEventListener(ev, () => {
                            photoPreviewContainer.style.border = '3px solid var(--green)';
                            photoPreviewContainer.style.opacity = '0.8';
                        }, false)
                    );

                    ['dragleave', 'drop'].forEach(ev =>
                        photoPreviewContainer.addEventListener(ev, () => {
                            photoPreviewContainer.style.border = '3px solid #fff';
                            photoPreviewContainer.style.opacity = '1';
                        }, false)
                    );

                    photoPreviewContainer.addEventListener('drop', (e) => {
                        const files = e.dataTransfer.files;
                        if (files.length > 0) {
                            $('#edit_photo_input')[0].files = files;
                            $('#edit_photo_input').trigger('change');
                        }
                    }, false);
                }

                $('#remove_photo_btn').on('click', function () {
                    const studentId = $('#edit_student_id').val();
                    if (!studentId) { Swal.fire({ icon: 'error', title: 'Error', text: 'Student ID not found', confirmButtonColor: '#dc2626' }); return; }
                    Swal.fire({ title: 'Remove Photo?', text: "Are you sure?", icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc2626', cancelButtonColor: '#287C44', confirmButtonText: 'Yes, remove!' })
                        .then(result => {
                            if (!result.isConfirmed) return;
                            Swal.fire({ title: 'Removing…', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                            $.ajax({
                                url: '{{ route("school.remove.registration.photo") }}',
                                method: 'POST',
                                data: { student_id: studentId, _token: '{{ csrf_token() }}' },
                                success: r => {
                                    $('#edit_photo_input').val('');
                                    $('#edit_photo_preview').attr('src', '/assets/images/default-user.jpg').addClass('updated');
                                    setTimeout(() => $('#edit_photo_preview').removeClass('updated'), 500);
                                    $('#upload_status').removeClass('loading error').addClass('success').html('<i class="fas fa-check-circle"></i> ' + r.message).show();
                                    setTimeout(() => $('#upload_status').fadeOut(), 3000);
                                    currentPhotoFile = null;
                                    Swal.fire({ icon: 'success', title: 'Removed!', text: r.message, confirmButtonColor: '#287C44' });
                                },
                                error: xhr => Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message || 'Failed to remove photo', confirmButtonColor: '#dc2626' })
                            });
                        });
                });

                // Drag & drop — edit modal only
                const editDrop = document.querySelector('#editStudentModal .photo-upload-section');
                if (editDrop) {
                    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(ev => editDrop.addEventListener(ev, e => { e.preventDefault(); e.stopPropagation(); }, false));
                    ['dragenter', 'dragover'].forEach(ev => editDrop.addEventListener(ev, () => { editDrop.style.borderColor = '#287C44'; editDrop.style.background = '#f0f9f0'; }, false));
                    ['dragleave', 'drop'].forEach(ev => editDrop.addEventListener(ev, () => { editDrop.style.borderColor = ''; editDrop.style.background = ''; }, false));
                    editDrop.addEventListener('drop', e => {
                        const files = e.dataTransfer.files;
                        if (files.length > 0) { $('#edit_photo_input')[0].files = files; $('#edit_photo_input').trigger('change'); }
                    }, false);
                }

                function uploadStudentPhoto(studentId, file) {
                    return new Promise((resolve, reject) => {
                        const fd = new FormData();
                        fd.append('student_id', studentId); fd.append('photo', file); fd.append('_token', '{{ csrf_token() }}');
                        $.ajax({ url: '{{ route("school.upload.registration.photo") }}', method: 'POST', data: fd, processData: false, contentType: false, success: resolve, error: reject });
                    });
                }

                $('#editStudentForm').on('submit', async function (e) {
                    e.preventDefault();
                    const fd = {
                        id: $('#edit_id').val(), student_id: $('#edit_student_id').val(),
                        category: $('#edit_category').val(), admission_year: $('#edit_admission_year').val(),
                        student_name: $('#edit_student_name').val(), student_name_ar: $('#edit_student_name_ar').val(),
                        date_of_birth: $('#edit_date_of_birth').val(), student_sex: $('#edit_student_sex').val(),
                        student_nationality: $('#edit_student_nationality').val(),
                        birth_place: $('#edit_birth_place').val(), birth_place_ar: $('#edit_birth_place_ar').val(),
                        class: $('#edit_class').val(), section: $('#edit_section').val(),
                        district: $('#edit_district').val(), district_ar: $('#edit_district_ar').val(),
                    };
                    if (!fd.category || !fd.admission_year || !fd.student_name || !fd.student_sex) {
                        Swal.fire({ icon: 'error', title: 'Missing Fields', text: 'Please fill in all required fields', confirmButtonColor: '#287C44' }); return;
                    }
                    const confirm = await Swal.fire({ title: 'Update Student?', text: 'Confirm update?', icon: 'question', showCancelButton: true, confirmButtonColor: '#287C44', cancelButtonColor: '#dc2626', confirmButtonText: 'Yes, update!' });
                    if (!confirm.isConfirmed) return;
                    Swal.fire({ title: 'Updating…', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                    try {
                        const res = await $.ajax({ url: '{{ route("school.update.registration") }}', method: 'POST', data: fd, headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
                        if (currentPhotoFile) { try { await uploadStudentPhoto(fd.student_id, currentPhotoFile); } catch (pe) { console.warn('Photo upload failed', pe); } }
                        Swal.fire({ icon: 'success', title: 'Updated!', text: res.message, confirmButtonColor: '#287C44' })
                            .then(r => { if (r.isConfirmed) { $('#editStudentModal').modal('hide'); location.reload(); } });
                    } catch (err) {
                        Swal.fire({ icon: 'error', title: 'Error', text: err.responseJSON?.message || 'Failed to update', confirmButtonColor: '#dc2626' });
                    }
                });

                $('#editStudentModal').on('hidden.bs.modal', function () {
                    $('#edit_photo_input').val('');
                    $('#upload_status').hide().removeClass('success error loading').empty();
                    currentPhotoFile = null;
                });

                // ══════════════════════════════════════════════
                // STEP 3 FUNCTIONALITY
                // ══════════════════════════════════════════════
                let step3DocFile = null;

                $('#step3_filter_btn').on('click', function () {
                    const year = $('#step3_year').val();
                    const category = $('#step3_category').val();
                    if (!year || !category) {
                        Swal.fire({ icon: 'warning', title: 'Required', text: 'Please select both Year and Category.', confirmButtonColor: '#287C44' }); return;
                    }
                    loadStep3Students(year, category);
                });

                function loadStep3Students(year, category) {
                    $('#step3_table_wrapper').hide();
                    $('#step3_empty').hide();
                    $('#step3TableBody').html('<tr><td colspan="8" class="text-center text-muted py-4"><i class="fas fa-spinner fa-spin mr-2"></i> Loading…</td></tr>');

                    $.ajax({
                        url: '{{ route("school.step3.students") }}',
                        method: 'GET',
                        data: { year, category },
                        success: function (response) {
                            const students = response.students;
                            if (!students || students.length === 0) { $('#step3_empty').show(); return; }

                            let html = '';
                            students.forEach((s, i) => {
                                html += `<tr>
                                    <td><input type="checkbox" class="step3-checkbox" value="${s.id}" data-student-id="${s.student_id}" style="width:16px;height:16px;cursor:pointer;"></td>
                                    <td>${i + 1}</td>
                                    <td><img src="/assets/student_photos/${s.student_id}.jpg"
                                                onerror="this.src='/assets/images/default-user.jpg';"
                                                style="width:46px;height:58px;object-fit:cover;border-radius:8px;border:2px solid #e9ecef;"></td>
                                    <td><code style="font-size:12px;color:var(--forest);background:var(--mint);padding:3px 7px;border-radius:6px;">${s.student_id}</code></td>
                                    <td><span style="font-weight:600;font-size:13px;">${s.student_name}</span>
                                        ${s.student_name_ar ? `<br><small style="color:var(--slate);font-size:11px;">${s.student_name_ar}</small>` : ''}</td>
                                    <td>${s.class ?? '-'}</td>
                                    <td>${s.section ?? '-'}</td>
                                    <td>${s.date_of_birth ? s.date_of_birth.split('-').reverse().join('/') : '-'}</td>
                                </tr>`;
                            });

                            $('#step3TableBody').html(html);
                            $('#step3_check_all').prop('checked', false);
                            $('#step3_table_wrapper').show();
                        },
                        error: function () {
                            $('#step3TableBody').html('<tr><td colspan="8" class="text-center text-danger py-4"><i class="fas fa-exclamation-circle mr-1"></i> Error loading students.</td></tr>');
                            $('#step3_table_wrapper').show();
                        }
                    });
                }

                $('#step3_check_all').on('change', function () {
                    $('.step3-checkbox').prop('checked', $(this).is(':checked'));
                });
                $(document).on('change', '.step3-checkbox', function () {
                    const total = $('.step3-checkbox').length;
                    const checked = $('.step3-checkbox:checked').length;
                    $('#step3_check_all').prop('checked', total === checked);
                });

                // Function to get file icon and type
                function getFileIcon(fileType, fileName) {
                    const ext = fileName.split('.').pop().toLowerCase();

                    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                        return { icon: 'fas fa-image', type: 'image', class: 'image' };
                    } else if (ext === 'pdf') {
                        return { icon: 'fas fa-file-pdf', type: 'pdf', class: 'pdf' };
                    } else if (['doc', 'docx'].includes(ext)) {
                        return { icon: 'fas fa-file-word', type: 'word', class: 'word' };
                    } else if (['xls', 'xlsx'].includes(ext)) {
                        return { icon: 'fas fa-file-excel', type: 'excel', class: 'excel' };
                    } else if (ext === 'txt') {
                        return { icon: 'fas fa-file-alt', type: 'text', class: 'text' };
                    } else {
                        return { icon: 'fas fa-file', type: 'generic', class: 'generic' };
                    }
                }

                // Function to preview document
                function previewDocument(file) {
                    return new Promise((resolve, reject) => {
                        const fileType = getFileIcon(file.type, file.name);
                        const previewDiv = $('#step3_doc_preview');

                        if (fileType.type === 'image') {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                previewDiv.html(`<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`);
                                previewDiv.removeClass().addClass(`document-preview ${fileType.class}`);
                                resolve();
                            };
                            reader.onerror = reject;
                            reader.readAsDataURL(file);
                        } else {
                            // For non-image files, show icon and filename
                            previewDiv.html(`
                                        <i class="${fileType.icon}" style="font-size: 48px;"></i>
                                        <span>${file.name.length > 20 ? file.name.substring(0, 17) + '...' : file.name}</span>
                                    `);
                            previewDiv.removeClass().addClass(`document-preview ${fileType.class}`);
                            resolve();
                        }
                    });
                }

                // Update file input change handler
                $('#step3_doc_input').on('change', function (e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    // Check file size (5MB max)
                    if (file.size > 5 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Too Large',
                            text: 'File size must be less than 5MB.',
                            confirmButtonColor: '#287C44'
                        });
                        $(this).val('');
                        return;
                    }

                    // Show loading status
                    $('#step3_upload_status').removeClass('success error').addClass('loading')
                        .html('<i class="fas fa-spinner fa-spin"></i> Loading file...').show();

                    // Preview the file
                    previewDocument(file).then(() => {
                        $('#step3_file_name').text(file.name).show();
                        $('#step3_upload_status').removeClass('loading error').addClass('success')
                            .html('<i class="fas fa-check-circle"></i> File loaded successfully!').show();
                        setTimeout(() => $('#step3_upload_status').fadeOut(), 3000);
                        step3DocFile = file;
                    }).catch(error => {
                        console.error('Preview error:', error);
                        $('#step3_upload_status').removeClass('loading success').addClass('error')
                            .html('<i class="fas fa-exclamation-circle"></i> Error loading file').show();
                        setTimeout(() => $('#step3_upload_status').fadeOut(), 3000);
                    });
                });

                // Update remove button handler
                $('#step3_remove_doc_btn').on('click', function () {
                    $('#step3_doc_input').val('');
                    $('#step3_doc_preview').html(`
                                <i class="fas fa-file-pdf" style="font-size: 48px; color: #dc2626;"></i>
                                <span style="font-size: 12px; margin-top: 8px;">No file selected</span>
                            `);
                    $('#step3_doc_preview').removeClass().addClass('document-preview');
                    $('#step3_file_name').hide().empty();
                    step3DocFile = null;
                    $('#step3_upload_status').hide().removeClass('success error loading').empty();
                });

                // Update submit button to validate file type more flexibly
                $('#step3_submit_btn').on('click', function () {
                    const checked = $('.step3-checkbox:checked');
                    if (checked.length === 0) {
                        Swal.fire({ icon: 'warning', title: 'None Selected', text: 'Select at least one student.', confirmButtonColor: '#287C44' });
                        return;
                    }

                    const ids = [];
                    checked.each(function () { ids.push($(this).val()); });

                    // Build confirmation HTML — doc info is optional
                    let docHtml = step3DocFile
                        ? (() => {
                            const fileSize = (step3DocFile.size / 1024).toFixed(2);
                            const fileSizeText = fileSize > 1024 ? (fileSize / 1024).toFixed(2) + ' MB' : fileSize + ' KB';
                            return `<hr>
                            <p><strong>Attached Document:</strong></p>
                            <p style="font-size: 12px; color: var(--slate);">
                                <i class="fas fa-file"></i> ${step3DocFile.name}<br>
                                <i class="fas fa-database"></i> ${fileSizeText}
                            </p>`;
                        })()
                        : `<hr><p style="font-size:12px;color:var(--slate);"><i class="fas fa-info-circle"></i> No supporting document attached (optional).</p>`;

                    Swal.fire({
                        title: 'Submit for Approval?',
                        html: `
                    <div style="text-align: left;">
                        <p>You are about to submit <b>${ids.length}</b> student(s) for admin approval.</p>
                        <p>Their status will change to <b>Pending Admin Approval</b>.</p>
                        ${docHtml}
                    </div>
                `,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#287C44',
                        cancelButtonColor: '#dc2626',
                        confirmButtonText: 'Yes, Submit!'
                    }).then(result => {
                        if (!result.isConfirmed) return;

                        Swal.fire({ title: 'Submitting…', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

                        const fd = new FormData();
                        fd.append('_token', '{{ csrf_token() }}');
                        fd.append('ids', JSON.stringify(ids));
                        if (step3DocFile) fd.append('document', step3DocFile); // only append if present

                        $.ajax({
                            url: '{{ route("school.step3.submit") }}',
                            method: 'POST',
                            data: fd,
                            processData: false,
                            contentType: false,
                            success: r => Swal.fire({
                                icon: 'success',
                                title: 'Submitted!',
                                text: r.message,
                                confirmButtonColor: '#287C44'
                            }).then(() => {
                                $('#step3_doc_input').val('');
                                $('#step3_doc_preview').html(`
                            <i class="fas fa-file-pdf" style="font-size: 48px; color: #dc2626;"></i>
                            <span style="font-size: 12px; margin-top: 8px;">No file selected</span>
                        `);
                                $('#step3_doc_preview').removeClass().addClass('document-preview');
                                $('#step3_file_name').hide().empty();
                                step3DocFile = null;
                                $('#step3_upload_status').hide().removeClass('success error loading').empty();
                                loadStep3Students($('#step3_year').val(), $('#step3_category').val());
                                loadRecentRegistrations();
                                loadAnalytics();
                            }),
                            error: xhr => Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message || 'Failed to submit.',
                                confirmButtonColor: '#dc2626'
                            })
                        });
                    });
                });
                // (duplicate step3_submit_btn handler removed)

                // Open edit modal when clicking on photo column
                $(document).on('click', '.clickable-photo', function () {
                    const regId = $(this).data('id');
                    const studentId = $(this).data('student-id');

                    if (!regId || !studentId) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Could not load student data',
                            confirmButtonColor: '#287C44'
                        });
                        return;
                    }

                    // Fetch and display student data in modal
                    $.ajax({
                        url: '{{ route("school.get.registration") }}',
                        method: 'GET',
                        data: { id: regId, student_id: studentId },
                        success: function (r) {
                            $('#edit_photo_preview').attr('src', '/assets/student_photos/' + r.registration.student_id + '.jpg?v=' + Date.now());
                            $('#edit_photo_input').val('');
                            currentPhotoFile = null;
                            $('#edit_id').val(r.registration.id);
                            $('#edit_student_id').val(r.registration.student_id);
                            $('#edit_category').val(r.registration.category);
                            $('#edit_admission_year').val(r.registration.admission_year);
                            $('#edit_student_name').val(r.registration.student_name);
                            $('#edit_student_name_ar').val(r.registration.student_name_ar || '');
                            $('#edit_student_sex').val(r.registration.student_sex);
                            $('#edit_date_of_birth').val(r.registration.date_of_birth || '');
                            $('#edit_student_nationality').val(r.registration.student_nationality || '');
                            $('#edit_birth_place').val(r.registration.birth_place || '');
                            $('#edit_birth_place_ar').val(r.registration.birth_place_ar || '');
                            $('#edit_class').val(r.registration.category === 'ID' ? 'Senior Four / ضصثقف' : 'Senior Six / الثانوية');
                            $('#edit_section').val(r.registration.section || '');
                            $('#edit_district').val(r.registration.district || '');
                            $('#edit_district_ar').val(r.registration.district_ar || '');
                            $('#editStudentModal').modal('show');
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to load student data',
                                confirmButtonColor: '#dc2626'
                            });
                        }
                    });
                });
            });
        </script>
    @endsection
@endsection