<style>
    :root {
    /* --- High-End Corporate Blue Palette --- */
    --primary-color: #2a5298; /* Sophisticated Blue */
    --secondary-color: #4a5568; /* Cool Gray */
    --accent-color: #c89b3c; /* Muted Gold/Amber */
    --success-color: #2f855a; /* Darker Green */
    --danger-color: #c53030; /* Darker Red */
    --warning-color: #dd6b20; /* Darker Orange/Brown */
    --info-color: #3182ce; /* Standard Info Blue */
    --review-color: #805ad5; /* Purple for Review Status */

    --background-body: #f8f9fa; /* Even Lighter Gray */
    --background-card: #ffffff;
    --background-alt: #edf2f7; /* Alternate light gray */
    --background-header: #ffffff;

    --text-primary: #1a202c; /* Near Black */
    --text-secondary: #4a5568;
    --text-muted: #718096;
    --text-on-primary: #ffffff;
    --text-on-accent: #ffffff;

    --border-color-light: #e2e8f0;
    --border-color-medium: #cbd5e0;
    --border-color-input: #a0aec0;

    --font-family: 'Vazirmatn', 'Tahoma', sans-serif;
    --font-size-base: 16px;
    --line-height-base: 1.75;

    --border-radius-sm: 4px;
    --border-radius-md: 6px;
    --border-radius-lg: 8px;

    --shadow-subtle: 0 2px 4px rgba(0, 0, 0, 0.04);
    --shadow-medium: 0 5px 10px rgba(0, 0, 0, 0.06);
    --shadow-raised: 0 12px 20px -3px rgba(0, 0, 0, 0.07);
    --shadow-focus-ring: 0 0 0 3px rgba(42, 82, 152, 0.25);

    --transition-smooth: 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* --- Base, Typography, Utilities --- */
    *, *::before, *::after { box-sizing: border-box; }
    body { font-family: var(--font-family); line-height: var(--line-height-base); margin: 0; padding: 0; background-color: var(--background-body); color: var(--text-primary); direction: rtl; font-size: var(--font-size-base); -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; overflow-x: hidden; }
    .container { max-width: 1350px; margin: 40px auto; padding: 0 30px; }
    h1, h2, h3, h4 { margin-top: 0; line-height: 1.4; font-weight: 600; color: var(--text-primary); }
    h1 { font-size: 2rem; text-align: center; margin-bottom: 50px; font-weight: 700; }
    h2 { font-size: 1.5rem; margin: 10px 0 30px 0; padding-bottom: 15px; border-bottom: 1px solid var(--border-color-light); color: var(--primary-color); font-weight: 600; display: flex; align-items: center; gap: 10px; }
    h2 i { font-size: 0.9em; }
    h3 { font-size: 1.2rem; margin-bottom: 20px; font-weight: 600; }
    h4 { font-size: 1rem; margin: 25px 0 15px 0; color: var(--text-primary); font-weight: 600; }
    p { margin-bottom: 1.3em; color: var(--text-secondary); font-size: 0.95rem; }
    a { color: var(--primary-color); text-decoration: none; transition: color var(--transition-smooth); }
    a:hover { color: #1e3a8a; }
    strong { font-weight: 600; color: var(--text-primary); }
    small { font-size: 0.85em; color: var(--text-muted); }
    .text-center { text-align: center; } .mb-3 { margin-bottom: 1rem !important; } .mb-4 { margin-bottom: 1.5rem !important; } .mt-4 { margin-top: 1.5rem !important; } .mt-5 { margin-top: 2.5rem !important; } .ms-auto { margin-right: auto !important; } .me-auto { margin-left: auto !important; } .d-flex { display: flex !important; } .justify-content-between { justify-content: space-between !important; } .justify-content-center { justify-content: center !important; } .align-items-center { align-items: center !important; } .w-100 { width: 100% !important; } .gap-1 { gap: 0.25rem; } .gap-2 { gap: 0.5rem; } .gap-3 { gap: 1rem; } .gap-4 { gap: 1.5rem; } .flex-wrap { flex-wrap: wrap; } .flex-grow-1 { flex-grow: 1; }

    /* --- Card Styling --- */
    .card { background-color: var(--background-card); border: 1px solid var(--border-color-light); border-radius: var(--border-radius-lg); padding: 30px 35px; box-shadow: var(--shadow-subtle); margin-bottom: 40px; transition: box-shadow var(--transition-smooth); }
    .card:hover { box-shadow: var(--shadow-medium); }
    .card-header { padding-bottom: 20px; margin: -30px -35px 30px -35px; padding: 25px 35px; border-bottom: 1px solid var(--border-color-light); background-color: var(--background-card); border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0; }
    .card-title { font-size: 1.25rem; margin-bottom: 0; display: flex; align-items: center; gap: 12px; font-weight: 600; }
    .card-title i { color: var(--primary-color); font-size: 1.1em; }

    /* --- Form Styling --- */
    .form-group { margin-bottom: 1.75rem; }
    .form-label { display: block; margin-bottom: .7rem; font-weight: 500; color: var(--text-secondary); font-size: 0.9rem; }
    .form-control { display: block; width: 100%; padding: .8rem 1.1rem; font-size: 0.95rem; font-weight: 400; line-height: 1.6; color: var(--text-primary); background-color: var(--background-card); background-clip: padding-box; border: 1px solid var(--border-color-medium); border-radius: var(--border-radius-md); transition: border-color var(--transition-smooth), box-shadow var(--transition-smooth); }
    .form-control:focus { border-color: var(--primary-color); outline: 0; box-shadow: var(--shadow-focus-ring); background-color: #fcfdff; }
    .form-control::placeholder { color: var(--text-muted); opacity: 0.8; }
    select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%234a5568' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: left 1rem center; background-size: 16px 12px; padding-left: 3rem; }
    textarea.form-control { min-height: 110px; }
    .form-control-sm { padding: .4rem .8rem; font-size: 0.85rem; border-radius: var(--border-radius-sm); }
    select.form-control-sm { padding-left: 2.5rem; background-position: left .75rem center; background-size: 14px 10px; }
    .input-group { position: relative; display: flex; flex-wrap: wrap; align-items: stretch; width: 100%; }
    .input-group .form-control { position: relative; flex: 1 1 auto; width: 1%; min-width: 0; }
    .input-group-text { display: flex; align-items: center; padding: .4rem .8rem; font-size: 0.85rem; font-weight: 400; line-height: 1.6; color: var(--text-secondary); text-align: center; white-space: nowrap; background-color: var(--background-alt); border: 1px solid var(--border-color-medium); border-radius: var(--border-radius-sm); }
    .input-group > .form-control:not(:last-child) { border-top-left-radius: 0; border-bottom-left-radius: 0; }
    .input-group > .input-group-text:not(:first-child) { border-top-right-radius: 0; border-bottom-right-radius: 0; }
    .input-group > .input-group-text:not(:last-child) { border-left: 0; }

    /* --- Button Styling --- */
    .btn { font-family: var(--font-family); display: inline-flex; align-items: center; justify-content: center; gap: .6rem; font-weight: 500; line-height: 1.5; text-align: center; vertical-align: middle; cursor: pointer; user-select: none; border: 1px solid transparent; padding: .7rem 1.4rem; font-size: 0.9rem; border-radius: var(--border-radius-md); transition: all var(--transition-smooth); }
    .btn i { line-height: 1; font-size: 1.1em; margin-left: 2px; margin-right: -2px; }
    .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); color: var(--text-on-primary); }
    .btn-primary:hover { background-color: #ffffff; border-color: #1e3a8a; color: #1e3a8a; box-shadow: var(--shadow-medium); transform: translateY(-1px); }
    .btn-secondary { color: var(--text-secondary); background-color: var(--background-card); border-color: var(--border-color-medium); }
    .btn-secondary:hover { background-color: var(--background-alt); border-color: var(--secondary-color); color: var(--secondary-color); }
    .btn-outline-secondary { color: var(--text-secondary); border-color: var(--border-color-medium); }
    .btn-outline-secondary:hover { background-color: var(--background-alt); color: var(--secondary-color); border-color: var(--border-color-medium); }
    .btn-success { background-color: var(--success-color); border-color: var(--success-color); color: #fff; }
    .btn-success:hover { background-color: #276749; border-color: #276749; }
    .btn-danger { background-color: var(--danger-color); border-color: var(--danger-color); color: #fff; }
    .btn-danger:hover { background-color: #a02c2c; border-color: #a02c2c; }
    .btn-warning { background-color: var(--warning-color); border-color: var(--warning-color); color: #fff; }
    .btn-warning:hover { background-color: #b75a1d; border-color: #b75a1d; }
    .btn-info { background-color: var(--info-color); border-color: var(--info-color); color: #fff; }
    .btn-info:hover { background-color: #2980b9; border-color: #2980b9; }
    .btn-accent { background-color: var(--accent-color); border-color: var(--accent-color); color: var(--text-on-accent); }
    .btn-accent:hover { background-color: #b38a30; border-color: #b38a30; }
    .btn-sm { padding: .4rem .9rem; font-size: .8rem; gap: .4rem; }
    .btn:disabled { opacity: 0.55; cursor: not-allowed; box-shadow: none; transform: none; }
    .button-group { display: flex; gap: 0.6rem; }

    /* --- Table Styling --- */
    .table-container { overflow-x: auto; border: 1px solid var(--border-color-light); border-radius: var(--border-radius-lg); background: var(--background-card); box-shadow: var(--shadow-subtle); }
    .table { width: 100%; margin-bottom: 0; color: var(--text-secondary); border-collapse: collapse; }
    .table th, .table td { padding: .9rem 1.2rem; vertical-align: middle; border-bottom: 1px solid var(--border-color-light); text-align: right; white-space: nowrap; font-size: 0.9rem; }
    .table thead th { vertical-align: bottom; border-bottom: 2px solid var(--border-color-medium); background-color: var(--background-alt); font-weight: 600; font-size: 0.8rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.6px; }
    .table tbody tr { transition: background-color var(--transition-smooth); }
    .table tbody tr:last-child td { border-bottom: none; }
    .table tbody tr:hover { background-color: rgba(42, 82, 152, 0.05); }
    .table td a { font-weight: 500; color: var(--text-primary); }
    .table td a:hover { color: var(--primary-color); }
    .table .user-nickname-cell { color: var(--text-secondary); font-weight: 500; } /* Style for nickname in table */

    /* --- Badge Styling --- */
    .badge { display: inline-block; padding: .3em .6em; font-size: .75rem; font-weight: 500; line-height: 1; text-align: center; white-space: nowrap; vertical-align: middle; border-radius: var(--border-radius-sm); }
    .badge-priority-high { background-color: rgba(200, 155, 60, 0.15); color: #8c681a; border: 1px solid rgba(200, 155, 60, 0.3); font-weight: 600;}
    .badge-priority-medium { background-color: rgba(221, 107, 32, 0.1); color: #a34a17; border: 1px solid rgba(221, 107, 32, 0.3); }
    .badge-priority-low { background-color: rgba(47, 133, 90, 0.1); color: #276749; border: 1px solid rgba(47, 133, 90, 0.3); }
    .badge-status-todo { background-color: rgba(49, 130, 206, 0.1); color: #2b6cb0; border: 1px solid rgba(49, 130, 206, 0.3); }
    .badge-status-inprogress { background-color: rgba(42, 82, 152, 0.1); color: var(--primary-color); border: 1px solid rgba(42, 82, 152, 0.3); }
    .badge-status-review { background-color: rgba(128, 90, 213, 0.1); color: var(--review-color); border: 1px solid rgba(128, 90, 213, 0.3); }
    .badge-status-done { background-color: #e2e8f0; color: var(--text-muted); border: 1px solid #cbd5e0; }
    .badge-status-active { background-color: rgba(47, 133, 90, 0.1); color: var(--success-color); border: 1px solid rgba(47, 133, 90, 0.3); }
    .badge-status-inactive { background-color: #e2e8f0; color: var(--text-muted); border: 1px solid #cbd5e0; }

    /* --- Header / Navigation --- */        
    .main-header { background-color: var(--background-header); padding: 0 40px; margin-bottom: 45px; border-bottom: 1px solid var(--border-color-light); box-shadow: var(--shadow-subtle); display: flex; align-items: center; height: 70px; position: sticky; top: 0; z-index: 100; }
    .logo { font-size: 1.5rem; font-weight: 700; color: var(--primary-color); margin-left: 45px; white-space: nowrap; }
    .main-nav { display: flex; gap: 5px; flex-grow: 1; }
    .main-nav a { color: var(--text-secondary); font-weight: 500; padding: 10px 16px; border-radius: var(--border-radius-md); transition: background-color var(--transition-smooth), color var(--transition-smooth), box-shadow var(--transition-smooth); display: flex; align-items: center; gap: 8px; font-size: 0.9rem; position: relative; top: 1px; }
    .main-nav a:hover { background-color: var(--background-alt); color: var(--primary-color); text-decoration: none; }
    .main-nav a.active { background-color: rgba(42, 82, 152, 0.08); color: var(--primary-color); font-weight: 600; }
    .header-actions { display: flex; align-items: center; gap: 20px; }
    .header-actions .btn-sm { padding: .5rem 1rem; }
    .header-actions .icon-link { color: var(--text-secondary); font-size: 1.2rem; transition: color var(--transition-smooth); position: relative; line-height: 1; padding: 5px; }
    .header-actions .icon-link:hover { color: var(--primary-color); }
    .header-actions .notification-badge { position: absolute; top: 0px; right: -5px; background-color: var(--danger-color); color: white; font-size: 0.65rem; width: 17px; height: 17px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 500; border: 1.5px solid white; }
    .user-menu { display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 8px 5px; border-radius: var(--border-radius-md); transition: background-color var(--transition-smooth); }
    .user-menu:hover { background-color: var(--background-alt); }
    .user-avatar { width: 38px; height: 38px; border-radius: 50%; background-color: var(--primary-color); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1rem; flex-shrink: 0; line-height: 1; }
    .user-info { display: flex; flex-direction: column; line-height: 1.3; }
    .user-nickname { font-weight: 600; color: var(--text-primary); font-size: 0.9rem; }
    .user-role { font-size: 0.75rem; color: var(--text-muted); }
    .mobile-menu-toggle { display: none; background: none; border: none; font-size: 1.5rem; color: var(--text-secondary); cursor: pointer; padding: 0 10px; }

    /* --- Section Header --- */
    .section-header { margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid var(--border-color-light); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
    .section-header h2, .section-header h3 { margin: 0; padding: 0; border: none; }
    .section-header .btn-sm { margin-top: 5px; }

    /* --- Dashboard Filters --- */
    .dashboard-filters { display: flex; align-items: center; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.5rem; padding: 0.75rem 1rem; background-color: var(--background-alt); border-radius: var(--border-radius-lg); }
    .dashboard-filters .filter-item { /* No styles needed now */ position: relative; }
    .dashboard-filters .search-filter { flex-grow: 1; max-width: 300px; }
    .dashboard-filters .btn-filter { font-size: 0.8rem; padding: .3rem .7rem; }
    .dashboard-filters .btn-filter .fa-chevron-down { font-size: 0.7em; margin-right: 4px; }

    /* --- Filter Dropdowns --- */
    .filter-dropdown {
        position: absolute;
        top: calc(100% + 5px);
        right: 0;
        width: 220px;
        background-color: var(--background-card);
        border: 1px solid var(--border-color-medium);
        border-radius: var(--border-radius-md);
        box-shadow: var(--shadow-medium);
        z-index: 10;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.25s ease-in-out;
    }

    .filter-dropdown.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .filter-dropdown-header {
        padding: 10px 15px;
        border-bottom: 1px solid var(--border-color-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .filter-dropdown-title {
        font-weight: 600;
        font-size: 0.85rem;
    }

    .filter-dropdown-close {
        background: none;
        border: none;
        cursor: pointer;
        color: var(--text-muted);
        font-size: 0.85rem;
        padding: 0;
    }

    .filter-dropdown-body {
        max-height: 250px;
        overflow-y: auto;
    }

    .filter-dropdown-item {
        padding: 8px 15px;
        cursor: pointer;
        display: flex;
        align-items: center;
        border-bottom: 1px solid var(--border-color-light);
        transition: background-color 0.2s;
    }

    .filter-dropdown-item:last-child {
        border-bottom: none;
    }

    .filter-dropdown-item:hover {
        background-color: var(--background-alt);
    }

    .filter-dropdown-item.active {
        background-color: rgba(42, 82, 152, 0.08);
        font-weight: 500;
    }

    .filter-dropdown-footer {
        padding: 10px 15px;
        border-top: 1px solid var(--border-color-light);
        display: flex;
        justify-content: space-between;
    }

    .filtered-indicator {
        position: absolute;
        top: 0;
        right: 0;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--primary-color);
        transform: translate(30%, -30%);
        display: none;
    }

    .is-filtered .filtered-indicator {
        display: block;
    }

    /* Comments Section */
    .comments-section { margin-top: 40px; border-top: 1px solid var(--border-color-light); padding-top: 35px; }
    .comment { display: flex; gap: 15px; margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid var(--border-color-light); }
    .comment:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    .comment-avatar { flex-shrink: 0; width: 42px; height: 42px; border-radius: 50%; background-color: var(--secondary-color); color: white; display: flex; align-items: center; justify-content: center; font-weight: 500; font-size: 0.9rem;}
    .comment-body { flex-grow: 1; }
    .comment-meta { display: flex; align-items: center; gap: 10px; margin-bottom: 6px; }
    .comment-author { font-weight: 600; color: var(--text-primary); font-size: 0.95rem; }
    .comment-author .nickname { color: var(--text-muted); font-weight: 400; font-size: 0.9em; }
    .comment-date { font-size: 0.8rem; color: var(--text-muted); }
    .comment-text { line-height: 1.7; color: var(--text-secondary); font-size: 0.9rem; }
    .comment-form { margin-top: 25px; }

    /* --- Workflow Board --- */
    /* .workflow-board-container { } */
    .workflow-stage { margin-bottom: 30px; }
    .stage-title { display: flex; align-items: center; gap: 10px; font-size: 1rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid var(--border-color-medium); }
    .stage-title i { font-size: 1.1em; color: var(--secondary-color); width: 20px; text-align: center; }
    .stage-title .task-count { font-size: 0.9em; font-weight: 400; color: var(--text-muted); margin-right: 5px; }
    .stage-tasks { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 15px; }
    .task-card-horizontal { background-color: var(--background-card); border-radius: var(--border-radius-md); padding: 15px; border: 1px solid var(--border-color-light); box-shadow: var(--shadow-subtle); transition: all var(--transition-smooth); cursor: grab; display: flex; flex-direction: column; gap: 10px; }
    .task-card-horizontal:hover { transform: translateY(-2px); box-shadow: var(--shadow-medium); border-color: var(--border-color-medium); }
    .task-card-title { font-weight: 500; font-size: 0.9rem; color: var(--text-primary); display: block; line-height: 1.5; margin-bottom: 0; flex-grow: 1; }
    .task-card-meta { display: flex; justify-content: space-between; align-items: center; gap: 10px; font-size: 0.8rem; color: var(--text-muted); border-top: 1px dashed var(--border-color-light); padding-top: 10px; margin-top: 10px; }
    .task-card-assignee { display: flex; align-items: center; gap: 6px; }
    .task-card-avatar { width: 24px; height: 24px; font-size: 0.8em; border-radius: 50%; background-color: var(--secondary-color); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; flex-shrink: 0; }
    .task-card-assignee span { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px; font-weight: 500; color: var(--text-secondary); }
    .task-card-due-date { display: flex; align-items: center; gap: 4px; flex-shrink: 0; }
    .task-card-due-date i { font-size: 0.9em; }
    .task-card-horizontal .badge { font-size: 0.7rem; padding: .25em .5em; flex-shrink: 0; }

    /* --- Notifications List --- */
    .notifications-list { list-style: none; padding: 0; margin: 0; }
    .notification-item { display: flex; align-items: flex-start; gap: 18px; padding: 18px 10px; border-bottom: 1px solid var(--border-color-light); transition: background-color var(--transition-smooth); cursor: pointer; }
    .notification-item:last-child { border-bottom: none; }
    .notification-item:hover { background-color: var(--background-alt); }
    .notification-icon { font-size: 1.1rem; color: var(--primary-color); flex-shrink: 0; width: 35px; height: 35px; border-radius: 50%; background-color: rgba(42, 82, 152, 0.08); display: flex; align-items: center; justify-content: center; margin-top: 3px; }
    .notification-text { flex-grow: 1; font-size: 0.9rem; color: var(--text-secondary); }
    .notification-text strong { color: var(--text-primary); }
    .notification-text strong.nickname { color: var(--primary-color); font-weight: 600; }
    .notification-text > span { font-style: italic; color: var(--text-muted); display: inline-block; max-width: 90%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; vertical-align: bottom; }
    .notification-time { font-size: 0.75rem; color: var(--text-muted); margin-top: 5px; display: block; }
    .notification-unread .notification-text strong, .notification-unread .notification-text { color: var(--text-primary); font-weight: 500; }
        .notification-unread strong.nickname { color: var(--primary-color); font-weight: 700; }
    .notification-unread { background-color: rgba(42, 82, 152, 0.06); }

    /* --- Pagination --- */
    .pagination { display: flex; list-style: none; padding: 0; gap: 6px; justify-content: center; margin-top: 2rem; }
    .page-item .page-link { display: inline-flex; align-items: center; justify-content: center; padding: .4rem .8rem; font-size: 0.9rem; min-width: 34px; height: 34px; border: 1px solid var(--border-color-medium); border-radius: var(--border-radius-md); color: var(--text-secondary); background-color: var(--background-card); transition: all var(--transition-smooth); }
    .page-item .page-link:hover { background-color: var(--background-alt); border-color: var(--border-color-medium); }        
    .page-item.active .page-link { background-color: var(--primary-color); border-color: var(--primary-color); color: white; z-index: 3; }
    .page-item.disabled .page-link { opacity: 0.6; cursor: not-allowed; background-color: var(--background-alt); border-color: var(--border-color-light); color: var(--text-muted); }

    /* --- Form Switch --- */
    .form-check.form-switch { display: flex; align-items: center; justify-content: space-between; padding: 0; margin-bottom: 1.25rem; }
    .form-check-label { margin-right: 0; color: var(--text-secondary); font-size: 0.9rem; cursor: pointer; flex-grow: 1; padding-left: 1rem; }
    .form-check-input { float: none; margin-left: 0; margin-right: 0; width: 2.5em; height: 1.25em; margin-top: 0; vertical-align: middle; background-color: #cbd5e0; border: 1px solid #a0aec0; border-radius: 2em; transition: background-position .15s ease-in-out, background-color .15s ease-in-out; appearance: none; background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%28255, 255, 255, 0.5%29'/%3e%3c/svg%3e"); background-position: right center; background-repeat: no-repeat; cursor: pointer; flex-shrink: 0; }
    .form-check-input:checked { background-color: var(--primary-color); border-color: var(--primary-color); background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e"); background-position: left center; }
    .form-check-input:focus { border-color: var(--primary-color); outline: 0; box-shadow: var(--shadow-focus-ring); }

    /* Specific Login/Register card width */
    .login-card, .register-card { max-width: 400px; margin: 50px auto; }
    .profile-card .user-avatar { width: 100px; height: 100px; font-size: 2.5rem; margin: 0 auto 20px auto; border: 3px solid var(--border-color-light); display: flex; align-items: center; justify-content: center; line-height: 1; }

    /* --- Tab Animation & Display --- */
    section[id$="-screen"] {
        display: none; /* Hide all sections by default */
        animation: fadeIn 0.4s ease-in-out;
        min-height: 60vh; /* Ensure minimum height for visual appeal */
    }
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* Mobile Menu Drawer - Only visible on small screens */
    .mobile-menu-drawer {
        position: fixed;
        top: 70px;
        right: -280px;  /* Start offscreen - RTL */
        width: 280px;
        height: calc(100vh - 70px);
        background-color: var(--background-card);
        box-shadow: var(--shadow-raised);
        z-index: 99;
        transition: right 0.3s ease-in-out;
        padding: 20px 0;
        overflow-y: auto;
        display: none;
    }
    .mobile-menu-drawer.open {
        right: 0;
    }
    .mobile-menu-drawer a {
        display: block;
        padding: 15px 20px;
        color: var(--text-secondary);
        font-weight: 500;
        border-bottom: 1px solid var(--border-color-light);
    }
    .mobile-menu-drawer a.active {
        background-color: rgba(42, 82, 152, 0.08);
        color: var(--primary-color);
        font-weight: 600;
    }
    .mobile-menu-drawer a i {
        width: 24px;
        margin-left: 10px;
        text-align: center;
    }

    /* --- Task filter highlight --- */
    tr.filtered-out,
    .task-card-horizontal.filtered-out {
        display: none;
    }

    /* --- Search highlight --- */
    .search-highlight {
        background-color: rgba(200, 155, 60, 0.2);
        border-radius: 2px;
        padding: 1px 2px;
    }

    /* --- RESPONSIVE STYLES --- */
    @media (max-width: 991.98px) {
        .container { padding: 0 20px; margin-top: 25px; }
        .main-header { padding: 0 20px; height: 65px; }
        .main-nav { display: none; }
        .header-actions .btn-sm { display: none; }
        .mobile-menu-toggle { display: block; margin-left: auto; }
        .mobile-menu-drawer { display: block; }
        h1 { font-size: 1.8rem; margin-bottom: 40px; }
        h2 { font-size: 1.4rem; margin-top: 40px; }
        .card { padding: 25px; }
        .card-header { padding: 20px 25px; margin: -25px -25px 25px -25px; }
        #task-form-screen form > div[style*="grid-template-columns"],
        #profile-screen form > div[style*="grid-template-columns"] { grid-template-columns: 1fr !important; gap: 0 20px !important; }
        #profile-screen form > div[style*="grid-template-columns"] .form-group { margin-bottom: 1.75rem; }
        .dashboard-filters { padding: 0.5rem; gap: 0.5rem; }
        .dashboard-filters .search-filter { max-width: none; }
        .section-header { flex-direction: column; align-items: flex-start; }
        .section-header .btn-sm { margin-top: 10px; align-self: flex-end; }
    }
    @media (max-width: 767.98px) {
        body { font-size: 15px; }
        h1 { font-size: 1.6rem; margin-bottom: 30px; }
        h2 { font-size: 1.3rem; }
        .container { padding: 0 15px; margin-top: 20px; }
        .main-header { padding: 0 15px; height: 60px; }
        .logo { font-size: 1.3rem; margin-left: 15px; }
        .user-info { display: none; }
        .header-actions { gap: 15px; }
        .card { padding: 20px; }
        .card-header { padding: 18px 20px; margin: -20px -20px 20px -20px; }
        .dashboard-filters { flex-direction: column; align-items: stretch; }
        .dashboard-filters .filter-item { width: 100%; }
        .dashboard-filters .filter-item .btn-filter { width: 100%; text-align: right; justify-content: space-between; }
        .dashboard-filters .ms-auto { width: 100%; margin-top: 10px; margin-right: 0 !important; }
        .stage-tasks { grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); }
        .task-card-horizontal { padding: 12px; }
        .table th, .table td { padding: .7rem 1rem; font-size: 0.85rem; }
        .btn { padding: .6rem 1.2rem; font-size: 0.85rem; }
        .btn-sm { padding: .3rem .7rem; font-size: .75rem; }
        .login-card, .register-card, .profile-card { margin: 30px auto; max-width: 90%; }
        .pagination .page-link { min-width: 30px; height: 30px; font-size: 0.8rem; padding: 0.3rem 0.6rem; }
        
        .filter-dropdown {
            width: 100%;
            left: 0;
        }
    }
    @media (max-width: 575.98px) {
        h1 { font-size: 1.5rem; }
        h2 { font-size: 1.2rem; }
        h3 { font-size: 1.1rem; }
        .container { margin-top: 15px; padding: 0 10px; }
        .main-header { padding: 0 10px; }
        .header-actions { gap: 10px; }
        .header-actions .icon-link { font-size: 1.1rem; }
        .user-avatar { width: 34px; height: 34px; font-size: 0.9rem; }
        .mobile-menu-toggle { font-size: 1.3rem; }
        .card { padding: 15px; border-radius: var(--border-radius-md); margin-bottom: 25px;}
        .card-header { padding: 15px; margin: -15px -15px 15px -15px; border-radius: var(--border-radius-md) var(--border-radius-md) 0 0; }
        .table th, .table td { padding: .6rem .8rem; font-size: 0.8rem; white-space: normal; }
            .button-group { flex-wrap: wrap; }
        .comment-avatar { width: 36px; height: 36px; }
        .comment-author { font-size: 0.9rem; }
        .comment-text { font-size: 0.85rem; }
        .stage-tasks { gap: 10px; grid-template-columns: 1fr; }
        .task-card-horizontal { padding: 10px; }
        .task-card-title { font-size: 0.85rem; }
        .task-card-meta { font-size: 0.75rem; flex-wrap: wrap; gap: 5px; }
        .task-card-avatar { width: 22px; height: 22px; font-size: 0.7em; }
        .form-check-label { font-size: 0.85rem; }
        .form-check-input { width: 2.2em; height: 1.1em;}
        #task-form-screen form > div[style*="grid-template-columns"],
        #profile-screen form > div[style*="grid-template-columns"] { gap: 0 15px !important; }
    }

    th, td{
        text-align: center !important;
    }

    td > div{
        display: inline-block !important;
    }

    .google-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        background-color: #ffffff;
        border: 1px solid #dfdfdf;
        border-radius: 4px;
        color: #333333;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-google {
        color: #545454;
        background-color: #ffffff;
        box-shadow: 0 1px 2px 1px #ddd;
    }
    
    .btn-google:hover {
        background-color: #f1f1f1;
    }
    
    div.cf-turnstile{
        display: flex;
        justify-content: space-around;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px 35px;
    }

    @media (max-width: 992px) {
        .grid-container {
            grid-template-columns: repeat(2, 1fr); 
        }
    }

    @media (max-width: 576px) {
        .grid-container {
            grid-template-columns: 1fr;
        }   
    }
    
    .logo img {
        height: 60px;
        vertical-align: middle;
    }

</style>