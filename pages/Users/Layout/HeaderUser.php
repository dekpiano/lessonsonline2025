<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$Title?></title>
    <link rel="icon" href="../../../dist/img/AdminLTELogo.png" type="image/x-icon" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    <style>
        :root {
            --primary: #6366f1;
            --secondary: #a855f7;
            --accent: #f43f5e;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg-main: #f8fafc;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --radius-lg: 20px;
            --radius-md: 12px;
            --shadow-sm: 0 1px 3px 0 rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        * { font-family: 'Kanit', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', 'Kanit', sans-serif; font-weight: 700; color: var(--text-dark); }

        body { background-color: var(--bg-main) !important; color: var(--text-dark); }

        .content-wrapper { background: transparent !important; }
        
        /* Navbar Customization */
        .main-header {
            border-bottom: 1px solid rgba(0,0,0,0.05) !important;
            box-shadow: var(--shadow-sm);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9) !important;
        }

        /* Card Modernization */
        .card {
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            transition: transform 0.2s, box-shadow 0.2s;
            overflow: hidden;
        }
        .card-header { background: transparent; border-bottom: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; }
        .card-body { padding: 1.5rem; }

        /* Button Modernization */
        .btn { border-radius: 10px; font-weight: 600; padding: 0.6rem 1.2rem; transition: all 0.2s; }
        .btn-primary { background: linear-gradient(135deg, var(--primary), var(--secondary)); border: none; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4); opacity: 0.9; }

        /* Modal Modernization */
        .modal-content { border: none; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg); }
        .modal-header { border-bottom: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; }
        
        /* Input Modernization */
        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            background: #fff;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            border-color: var(--primary);
        }

        /* Sidebar Modernization */
        .main-sidebar {
            background: #ffffff !important;
            border-right: 1px solid rgba(0,0,0,0.05);
            box-shadow: none !important;
        }
        
        .brand-link {
            border-bottom: 1px solid rgba(0,0,0,0.05) !important;
            background: transparent !important;
            color: var(--text-dark) !important;
        }

        .nav-sidebar .nav-link {
            border-radius: 10px !important;
            color: var(--text-muted) !important;
            margin-bottom: 5px;
            padding: 10px 15px;
            transition: all 0.2s;
        }

        .nav-sidebar .nav-link:hover {
            background-color: #f1f5f9 !important;
            color: var(--primary) !important;
            transform: translateX(5px);
        }

        .nav-sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--primary), var(--secondary)) !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3) !important;
        }

        .nav-sidebar .nav-header {
            color: var(--text-muted) !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            padding: 1rem 1rem 0.5rem;
        }

        /* Navbar tweaks */
        .navbar-light .navbar-nav .nav-link {
            color: var(--text-dark);
            font-weight: 500;
        }
        .navbar-search-block .form-control {
            background: rgba(255,255,255,0.9);
        }

    </style>
</head>

<!-- Modal -->
<div class="modal fade" id="ModalLogin" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-body p-4 p-md-5">
                <div class="text-center mb-5">
                    <img src="../../../dist/img/AdminLTELogo.png" alt="Logo" class="mb-3" style="width: 80px; filter: drop-shadow(0 10px 15px rgba(99, 102, 241, 0.2));">
                    <h3 class="font-weight-bold mb-1">ยินดีต้อนรับ</h3>
                    <p class="text-muted">เข้าสู่ระบบเพื่อเริ่มเรียนรู้วันนี้</p>
                </div>

                <form id="loginForm" action="#" method="post">
                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-uppercase tracking-wider text-muted">อีเมล</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-right-0" style="border-radius: 12px 0 0 12px;"><i class="fas fa-envelope text-primary"></i></span>
                            </div>
                            <input type="email" class="form-control border-left-0" style="border-radius: 0 12px 12px 0;" placeholder="name@example.com" id="username" name="username" required>
                        </div>
                    </div>
                    
                    <div class="form-group mb-4">
                        <div class="d-flex justify-content-between">
                            <label class="small font-weight-bold text-uppercase tracking-wider text-muted">รหัสผ่าน</label>
                            <a href="../../Users/ForgotPassword" class="small text-primary">ลืมรหัสผ่าน?</a>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-right-0" style="border-radius: 12px 0 0 12px;"><i class="fas fa-lock text-primary"></i></span>
                            </div>
                            <input type="password" class="form-control border-left-0" style="border-radius: 0 12px 12px 0;" placeholder="••••••••" id="password" name="password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-sm mb-4" style="height: 56px; border-radius: 14px;">
                        <i class="fas fa-sign-in-alt mr-2"></i> เข้าสู่ระบบ
                    </button>
                    
                    <div class="text-center">
                        <span class="text-muted small">ยังไม่มีบัญชี?</span>
                        <a href="../../Users/Register" class="small font-weight-bold text-primary ml-1">สมัครสมาชิกที่นี่</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>