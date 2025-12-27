<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$Title;?> | บทเรียนออนไลน์</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../../../plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../../../plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../../../plugins/summernote/summernote-bs4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">

</head>
<style>
    :root {
        --primary-color: #4F46E5; /* Indigo 600 */
        --primary-light: #818CF8;
        --secondary-color: #64748B;
        --success-color: #10B981;
        --info-color: #3B82F6;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --light-bg: #F3F4F6;
        --card-radius: 16px;
        --btn-radius: 10px;
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    * {
        font-family: "Sarabun", sans-serif;
    }

    body {
        background-color: var(--light-bg);
        color: #1f2937;
    }

    /* Navbar & Header */
    .main-header {
        border-bottom: none;
        box-shadow: var(--shadow-sm);
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }
    
    .content-header h1 {
        font-weight: 700;
        color: #111827;
        font-size: 1.75rem;
    }

    /* Sidebar */
    .main-sidebar {
        background: #1e293b; /* Slate 800 */
        box-shadow: var(--shadow-lg);
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .brand-link {
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .nav-sidebar .nav-item .nav-link {
        border-radius: var(--btn-radius);
        margin-bottom: 5px;
        color: #cbd5e1;
    }

    .nav-sidebar .nav-item .nav-link:hover {
        background-color: rgba(255,255,255,0.05);
        color: #fff;
    }

    .nav-sidebar .nav-item .nav-link.active {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: #fff;
        box-shadow: var(--shadow-md);
    }

    /* Cards */
    .card {
        border: none;
        border-radius: var(--card-radius);
        box-shadow: var(--shadow-md);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background: #fff;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .card-header {
        background-color: transparent;
        border-bottom: 1px solid #f3f4f6;
        padding: 1.25rem;
    }
    
    .card-header .card-title {
        font-weight: 600;
        font-size: 1.1rem;
    }

    /* Small Box (Stat Cards) */
    .small-box {
        border-radius: var(--card-radius);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        border: none;
        position: relative;
    }

    .small-box > .inner {
        padding: 20px;
        z-index: 2;
        position: relative;
    }

    .small-box h3 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .small-box p {
        font-size: 1rem;
        opacity: 0.9;
        font-weight: 500;
    }

    .small-box .icon {
        top: 15px;
        right: 20px;
        opacity: 0.2;
        transition: all 0.3s;
    }
    
    .small-box:hover .icon {
        transform: scale(1.1);
        opacity: 0.3;
    }

    .small-box-footer {
        background: rgba(0,0,0,0.1) !important;
        border-radius: 0 0 var(--card-radius) var(--card-radius);
        padding: 8px 0;
        font-weight: 500;
    }

    /* Custom Gradients for Small Boxes */
    .bg-info {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8) !important;
    }
    .bg-success {
        background: linear-gradient(135deg, #10b981, #34d399) !important;
    }
    .bg-warning {
        background: linear-gradient(135deg, #f59e0b, #fbbf24) !important;
        color: #fff !important;
    }
    .bg-danger {
        background: linear-gradient(135deg, #ef4444, #f87171) !important;
    }

    /* Forms */
    .form-control {
        border-radius: var(--btn-radius);
        border: 1px solid #e5e7eb;
        padding: 0.6rem 1rem;
        height: auto;
    }

    .form-control:focus {
        border-color: var(--primary-light);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    /* Buttons */
    .btn {
        border-radius: var(--btn-radius);
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        letter-spacing: 0.3px;
        transition: all 0.2s;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        border: none;
        box-shadow: var(--shadow-sm);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #4338ca, #6366f1);
        box-shadow: var(--shadow-md);
        transform: translateY(-1px);
    }

    /* Tables */
    .table thead th {
        border-top: none;
        border-bottom: 2px solid #e5e7eb;
        font-weight: 600;
        color: #4b5563;
        background-color: #f9fafb;
    }

    .table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9fafb;
    }
    
    /* Pagination */
    .page-item .page-link {
        border-radius: 8px;
        margin: 0 3px;
        border: none;
        font-weight: 600;
        color: #6b7280;
    }
    
    .page-item.active .page-link {
        background-color: var(--primary-color);
        color: #fff;
        box-shadow: var(--shadow-sm);
    }

    /* Breadcrumb */
    .breadcrumb {
        background: transparent;
        padding: 0;
    }

    /* Modals */
    .modal-content {
        border-radius: var(--card-radius);
        border: none;
        box-shadow: var(--shadow-lg);
    }
    
    .modal-header {
        border-bottom: 1px solid #f3f4f6;
        background-color: #f9fafb;
        border-radius: var(--card-radius) var(--card-radius) 0 0;
    }
</style>