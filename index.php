<?php require 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Sistem Retail - Dashboard</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .dashboard {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 600px;
            width: 90%;
        }
        h1 { color: #333; margin-bottom: 10px; }
        .subtitle { color: #666; margin-bottom: 30px; }
        .menu { display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; }
        .menu-card {
            background: #f9f9f9;
            padding: 25px 35px;
            border-radius: 10px;
            text-decoration: none;
            color: #333;
            border: 2px solid #ddd;
            transition: all 0.3s;
            min-width: 200px;
        }
        .menu-card:hover {
            border-color: #4CAF50;
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .menu-card .icon { font-size: 40px; display: block; margin-bottom: 10px; }
        .menu-card .title { font-size: 18px; font-weight: bold; }
        .footer { 
            margin-top: 30px; 
            padding-top: 20px; 
            border-top: 1px solid #eee;
            color: #999;
            font-size: 14px;
        }
        .badge {
            display: inline-block;
            background: #4CAF50;
            color: white;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<div class="dashboard">
    <h1>🛒 Sistem Retail</h1>
    <p class="subtitle">Tugas Rutin 8 — CRUD + JOIN + Keamanan Database</p>
    
    <div class="menu">
        <a href="produk/" class="menu-card">
            <span class="icon">📦</span>
            <span class="title">Kelola Produk</span>
            <span class="badge">CRUD + JOIN Kategori</span>
        </a>
        
        <a href="transaksi/" class="menu-card">
            <span class="icon">🧾</span>
            <span class="title">Kelola Transaksi</span>
            <span class="badge">JOIN 3 Tabel</span>
        </a>
    </div>
    
    <div class="footer">
        <p>✅ Prepared Statements | ✅ Normalisasi 3NF | ✅ Foreign Key | ✅ Sanitasi Output</p>
    </div>
</div>
</body>
</html>