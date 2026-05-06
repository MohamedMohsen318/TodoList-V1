
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Todo List')</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background:
            radial-gradient(circle at top left, #dbeafe 0, transparent 28%),
            linear-gradient(180deg, #f8fbff 0%, #eef4ff 100%);
        color: #1f2937;
    }

    .page-shell {
        min-height: 100vh;
    }

    .layout {
        min-height: 100vh;
        display: grid;
        grid-template-columns: 260px 1fr;
    }

    .sidebar {
        background: rgba(255, 255, 255, 0.92);
        border-right: 1px solid #dbe3f0;
        padding: 28px 20px;
        backdrop-filter: blur(8px);
    }

    .content {
        padding: 32px 28px;
    }

    .panel {
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid #dbe3f0;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
    }

    .nav-link {
        display: block;
        padding: 11px 14px;
        border-radius: 10px;
        color: #475569;
        text-decoration: none;
        margin-bottom: 8px;
        transition: 0.18s ease;
    }

    .nav-link:hover,
    .nav-link.active {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-radius: 10px;
        padding: 11px 16px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        border: 1px solid transparent;
        cursor: pointer;
        transition: 0.18s ease;
    }

    .btn-primary {
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.22);
    }

    .btn-primary:hover {
        background: #1d4ed8;
    }

    .btn-secondary {
        background: #ffffff;
        color: #1f2937;
        border-color: #d1d5db;
    }

    .btn-danger {
        background: #fff1f2;
        color: #be123c;
        border-color: #fecdd3;
    }

    .input,
    .select,
    .textarea {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 11px 13px;
        background: #ffffff;
        font-size: 14px;
    }

    .input:focus,
    .select:focus,
    .textarea:focus {
        outline: none;
        border-color: #60a5fa;
        box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.16);
    }

    .label {
        display: block;
        margin-bottom: 6px;
        font-size: 14px;
        font-weight: 600;
    }

    .badge {
        display: inline-block;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-low { background: #dcfce7; color: #166534; }
    .badge-medium { background: #fef3c7; color: #92400e; }
    .badge-high { background: #fde68a; color: #92400e; }
    .badge-urgent { background: #fee2e2; color: #991b1b; }
    .status-pending { background: #e5e7eb; color: #374151; }
    .status-in-progress { background: #dbeafe; color: #1d4ed8; }
    .status-completed { background: #dcfce7; color: #166534; }
    .status-cancelled { background: #f3f4f6; color: #6b7280; }

    .flash {
        margin-bottom: 16px;
        border-radius: 12px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        padding: 13px 15px;
    }

    .task-list {
        display: grid;
        gap: 14px;
    }

    .task-item {
        border: 1px solid #dbe3f0;
        border-radius: 16px;
        padding: 18px;
        background: rgba(255, 255, 255, 0.96);
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.05);
    }

    .stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }

    .stat-box {
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid #dbe3f0;
        border-radius: 16px;
        padding: 16px;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.05);
    }

    .helper {
        color: #64748b;
        font-size: 14px;
    }

    .error {
        color: #b91c1c;
        font-size: 13px;
        margin-top: 4px;
    }

    .page-center {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }

    .card {
        width: 100%;
        max-width: 520px;
    }

    .card-wide {
        width: 100%;
        max-width: 680px;
    }

    .auth-page {
        min-height: 100vh;
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
    }

    .auth-aside {
        padding: 56px 48px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 20px;
    }

    .auth-card-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 36px;
    }

    .auth-card {
        width: 100%;
        max-width: 470px;
    }

    .brand-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.75);
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        font-size: 13px;
        font-weight: 700;
    }

    .auth-switch {
        display: flex;
        gap: 10px;
        margin-top: 18px;
    }

    .auth-link {
        flex: 1;
        text-align: center;
        text-decoration: none;
        padding: 11px 14px;
        border-radius: 10px;
        border: 1px solid #dbe3f0;
        color: #475569;
        background: rgba(255, 255, 255, 0.7);
        font-weight: 600;
    }

    .auth-link.active {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
    }

    @media (max-width: 900px) {
        .layout {
            grid-template-columns: 1fr;
        }

        .sidebar {
            border-right: 0;
            border-bottom: 1px solid #dbe3f0;
        }

        .stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .auth-page {
            grid-template-columns: 1fr;
        }

        .auth-aside {
            padding: 28px 22px 8px;
        }

        .auth-card-wrap {
            padding: 20px 22px 32px;
        }
    }
</style>
</head>
<body>
<div class="page-shell">
    @yield('page')
</div>
</body>
</html>
