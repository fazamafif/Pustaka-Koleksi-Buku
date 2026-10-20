<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
{{-- <title>@yield('title', 'Pustaka') - Sistem Manajemen Perpustakaan</title> --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  :root{
    --paper:#F1ECDC; --paper-2:#FBF8F0; --ink:#1B2A22; --ink-soft:#5A6A5F;
    --forest:#1F4438; --forest-2:#2E5C4A; --forest-dark:#12271F;
    --brass:#B8862E; --brass-light:#D9AE5F; --burgundy:#7C2D2D; --line:#D9CFB4;
    --danger-bg:#FDF2F2; --danger-border:#E8B4B4; --danger-text:#7C2D2D;
    --success-bg:#F0F7F4; --success-border:#B7D5C8; --success-text:#1F4438;
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  body{font-family:'Inter',sans-serif; background:var(--paper); color:var(--ink); min-height:100vh;}
  a{color:inherit; text-decoration:none;}
  button{font-family:inherit; cursor:pointer;}

  .app-shell{display:flex; min-height:100vh;}

  /* Sidebar */
  .sidebar{
    width:236px; flex-shrink:0;
    background:linear-gradient(180deg, var(--forest-dark), var(--forest));
    color:var(--paper-2);
    display:flex; flex-direction:column;
    position:sticky; top:0; height:100vh;
  }
  .sidebar .brand{
    padding:26px 24px 20px;
    font-family:'Fraunces',serif; font-weight:700; font-size:22px;
    border-bottom:1px solid rgba(251,248,240,0.12);
    display:flex; align-items:baseline; gap:8px;
  }
  .sidebar .brand .code-tag{
    font-family:'IBM Plex Mono',monospace; font-size:10px; color:var(--brass-light);
    border:1px solid rgba(217,174,95,0.5); padding:1px 5px; border-radius:2px;
  }
  .sidebar nav{padding:20px 12px; flex:1;}
  .nav-item{
    display:flex; align-items:center; gap:12px;
    padding:11px 14px; margin-bottom:4px; border-radius:2px;
    font-size:14px; font-weight:500; color:rgba(251,248,240,0.72);
    border-left:3px solid transparent;
    transition:all .15s ease;
  }
  .nav-item .code{
    font-family:'IBM Plex Mono',monospace; font-size:11px;
    color:var(--brass-light); width:20px;
  }
  .nav-item:hover{background:rgba(251,248,240,0.06); color:var(--paper-2);}
  .nav-item.active{
    background:rgba(184,134,46,0.18);
    border-left-color:var(--brass-light);
    color:var(--paper-2);
  }
  .sidebar .logout{
    padding:16px 24px; border-top:1px solid rgba(251,248,240,0.12);
    font-size:13px; color:rgba(251,248,240,0.6); display:flex; align-items:center; gap:8px;
  }
  .sidebar .logout:hover{color:var(--paper-2);}

  /* Main */
  .main{flex:1; min-width:0; display:flex; flex-direction:column;}
  .topbar{
    background:var(--paper-2); border-bottom:1px solid var(--line);
    padding:20px 36px; display:flex; align-items:center; justify-content:space-between;
    position:sticky; top:0; z-index:5;
  }
  .breadcrumb{
    font-family:'IBM Plex Mono',monospace; font-size:11px; letter-spacing:0.1em;
    color:var(--ink-soft); text-transform:uppercase;
  }
  .breadcrumb span{color:var(--brass);}
  .topbar h2{font-family:'Fraunces',serif; font-weight:600; font-size:24px; margin-top:2px;}
  .topbar .user-chip{
    display:flex; align-items:center; gap:10px; font-size:13px; color:var(--ink-soft);
  }
  .avatar{
    width:34px; height:34px; border-radius:50%; background:var(--forest);
    color:var(--paper-2); display:flex; align-items:center; justify-content:center;
    font-family:'Fraunces',serif; font-weight:600; font-size:14px;
  }
  
  .btn-add{
    background:var(--forest); color:var(--paper-2); border:none; padding:11px 18px;
    font-weight:600; font-size:13px; border-radius:2px; transition:background .15s ease;
    display:inline-flex; align-items:center; gap:6px;
  }
  .btn-add:hover{background:var(--forest-2); color:var(--paper-2);}

  .content{padding:32px 36px 60px; flex:1;}

  /* Alert Notifications */
  .alert{
    padding:14px 18px; margin-bottom:24px; border-radius:2px; font-size:13.5px;
    display:flex; align-items:center; justify-content:space-between; gap:12px;
  }
  .alert-success{
    background:var(--success-bg); border:1px solid var(--success-border); color:var(--success-text);
  }
  .alert-danger{
    background:var(--danger-bg); border:1px solid var(--danger-border); color:var(--danger-text);
  }
  .alert .close-btn{
    background:none; border:none; color:inherit; font-size:16px; font-weight:700;
  }

  /* Card */
  .card{
    position:relative; background:var(--paper-2); border:1px solid var(--line);
  }
  .card::after{
    content:""; position:absolute; top:-1px; right:-1px; width:16px; height:16px;
    background:var(--paper); clip-path:polygon(100% 0,0 0,100% 100%);
    border-left:1px solid var(--line); border-bottom:1px solid var(--line);
  }

  /* Specifics for different views */
  .stat-grid{display:grid; grid-template-columns:repeat(4,1fr); gap:18px; margin-bottom:32px;}
  .stat-card{padding:22px 22px 20px;}
  .stat-card .tag{font-family:'IBM Plex Mono',monospace; font-size:10px; color:var(--brass); letter-spacing:0.08em; margin-bottom:14px; display:block;}
  .stat-card .num{font-family:'Fraunces',serif; font-weight:700; font-size:36px; line-height:1; margin-bottom:6px;}
  .stat-card .label{font-size:13px; color:var(--ink-soft);}
  .stat-card.alert .num{color:var(--burgundy);}
  .stat-card .bar{height:3px; background:var(--brass); width:38px; margin-top:14px;}
  .stat-card.alert .bar{background:var(--burgundy);}
  
  .grid-2{display:grid; grid-template-columns:1.4fr 1fr; gap:20px;}
  .panel{padding:26px 26px 22px;}
  .panel-head{display:flex; justify-content:space-between; align-items:baseline; margin-bottom:18px;}
  .panel-head h3{font-family:'Fraunces',serif; font-weight:600; font-size:18px;}
  .panel-head a{font-size:12px; color:var(--brass); font-weight:600;}

  .list-row{display:flex; align-items:center; gap:14px; padding:12px 0; border-bottom:1px solid var(--line);}
  .list-row:last-child{border-bottom:none;}
  .list-row .info{flex:1; min-width:0;}
  .list-row .title{font-size:14px; font-weight:600; margin-bottom:2px;}
  .list-row .meta{font-size:12px; color:var(--ink-soft);}
  .list-row .badge-meta{font-family:'IBM Plex Mono',monospace; font-size:11px; color:var(--brass); text-align:right; flex-shrink:0;}

  /* Filter & Search Bar */
  .table-toolbar{
    display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:18px; flex-wrap:wrap;
  }
  .search-box{
    display:flex; align-items:center; gap:8px; flex:1; max-width:400px;
  }
  .search-input{
    flex:1; padding:9px 12px; border:1px solid var(--line); background:var(--paper-2);
    font-family:'Inter',sans-serif; font-size:13.5px; border-radius:2px; outline:none;
  }
  .search-input:focus{border-color:var(--brass);}
  .btn-search{
    background:var(--forest); color:var(--paper-2); border:none; padding:9px 16px;
    font-size:13px; font-weight:600; border-radius:2px;
  }
  .btn-search:hover{background:var(--forest-2);}
  .btn-reset{
    background:transparent; color:var(--ink-soft); border:1px solid var(--line); padding:9px 14px;
    font-size:13px; border-radius:2px;
  }
  .btn-reset:hover{color:var(--ink); border-color:var(--ink-soft);}

  table{width:100%; border-collapse:collapse;}
  thead th{text-align:left; font-family:'IBM Plex Mono',monospace; font-size:11px; letter-spacing:0.06em; text-transform:uppercase; color:var(--brass); padding:14px 16px; border-bottom:2px solid var(--line); white-space:nowrap;}
  tbody td{padding:14px 16px; border-bottom:1px solid var(--line); font-size:13.5px; vertical-align:middle;}
  tbody tr:hover{background:rgba(184,134,46,0.05);}
  tbody tr.empty-row td{text-align:center; padding:36px; color:var(--ink-soft); font-style:italic;}

  .book-title{font-weight:600; font-family:'Fraunces',serif; font-size:14.5px;}
  .book-author{font-size:12px; color:var(--ink-soft); margin-top:2px;}
  .badge{display:inline-block; padding:4px 10px; border-radius:20px; font-size:11.5px; font-weight:600; color:#fff; white-space:nowrap;}
  
  .row-actions{display:flex; gap:8px; align-items:center;}
  .icon-btn{width:28px; height:28px; border:1px solid var(--line); background:var(--paper); border-radius:2px; display:inline-flex; align-items:center; justify-content:center; font-size:13px; color:var(--ink-soft); transition:all .15s ease; cursor:pointer;}
  .icon-btn:hover{border-color:var(--brass); color:var(--brass);}
  .icon-btn.danger:hover{border-color:var(--burgundy); color:var(--burgundy);}

  /* Forms */
  .form-container {
      max-width: 620px;
      margin: 0 auto;
      padding: 32px 36px;
  }
  .field{margin-bottom:18px;}
  .field label{display:block; font-size:11.5px; font-weight:600; letter-spacing:0.04em; color:var(--ink-soft); margin-bottom:6px; text-transform:uppercase;}
  .field input, .field select, .field textarea{width:100%; padding:10px 12px; border:1px solid var(--line); background:var(--paper); font-family:'Inter',sans-serif; font-size:14px; color:var(--ink); border-radius:2px; outline:none; transition:border-color .15s;}
  .field input:focus, .field select:focus, .field textarea:focus{border-color:var(--brass); background:#fff;}
  .field input.is-invalid, .field select.is-invalid{border-color:var(--burgundy); background:#FFF8F8;}
  .error-text{color:var(--burgundy); font-size:12px; margin-top:4px; display:block; font-weight:500;}
  .form-actions{display:flex; gap:12px; margin-top:26px;}
  .btn-primary{background:var(--forest); color:var(--paper-2); border:none; padding:12px 24px; font-weight:600; font-size:13.5px; border-radius:2px; text-align:center; cursor:pointer;}
  .btn-primary:hover{background:var(--forest-2); color:var(--paper-2);}
  .btn-ghost{background:transparent; color:var(--ink-soft); border:1px solid var(--line); padding:12px 24px; font-weight:600; font-size:13.5px; border-radius:2px; text-align:center;}
  .btn-ghost:hover{border-color:var(--ink-soft); color:var(--ink);}

  /* Custom Pagination */
  .pagination-wrap{
    display:flex; justify-content:space-between; align-items:center; padding:16px 20px; font-size:13px; color:var(--ink-soft);
  }
  .pagination-links{display:flex; gap:6px;}
  .page-item{padding:6px 12px; border:1px solid var(--line); border-radius:2px; background:var(--paper-2); font-family:'IBM Plex Mono',monospace; font-size:12px;}
  .page-item.active{background:var(--forest); color:var(--paper-2); border-color:var(--forest);}
  .page-item:hover:not(.active){border-color:var(--brass); color:var(--brass);}

  @media(max-width:1100px){.stat-grid{grid-template-columns:repeat(2,1fr);} .grid-2{grid-template-columns:1fr;}}
  @media(max-width:720px){
    .sidebar{display:none;}
    .stat-grid{grid-template-columns:1fr;}
    .content{padding:20px 16px;}
    .topbar{padding:16px 20px;}
  }
</style>
</head>
<body>
<div class="app-shell">
  <aside class="sidebar">
    <div class="brand">Pustaka</div>
    <nav>
      <a class="nav-item {{ Request::is('/') ? 'active' : '' }}" href="/"><span class="code">00</span>Dashboard</a>
      <a class="nav-item {{ Request::is('Kategori*') ? 'active' : '' }}" href="/Kategori"><span class="code">01</span>Kategori</a>
      <a class="nav-item {{ Request::is('Penerbit*') ? 'active' : '' }}" href="/Penerbit"><span class="code">02</span>Penerbit</a>
      <a class="nav-item {{ Request::is('Buku*') ? 'active' : '' }}" href="/Buku"><span class="code">03</span>Buku</a>
    </nav>
    <div class="logout">
      <span>Admin Perpustakaan</span>
    </div>
  </aside>

  <main class="main">
    @yield('content')
  </main>
</div>
</body>
</html>
