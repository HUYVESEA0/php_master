<?php
    session_start();
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />>
    <link rel="stylesheet" href="../Admin/lib/style.css">
    <link rel="stylesheet" href="../Admin/lib/loader.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script type="text/javascript" src="../Admin/lib/jquery-3.7.1.min.js"></script>
    <title>ADMIN TOOLS</title>

</head>

<body>

    <nav class="slidebar">
        <header>
            <div class="image-text">
                <span class="image">
                </span>
                <div class="text header-text">
                    <span class="name">ADMIN</span>
                    <span class="profession">TOOLS</span>
                    <div class="timer"></div>
                </div>
            </div>
            <i class='ri-arrow-left-s-line toggle icon-switch'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul>
                    <li class="search-box">
                        <i class='ri-search-line icon'></i>
                        <input type="search" placeholder="Search">
                    </li>
                </ul>
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="#" class="ajax-link" data-page="dashboard">
                            <i class='ri-dashboard-line icon'></i>
                            <span class="text nav-text">Dashboard</span>

                        </a>
                    </li>
                    <li class="nav-link dropdown">
                        <a href="#" class="ajax-link" data-page="product">
                            <i class='ri-function-line icon'></i>
                            <span class="text nav-text">Sản phẩm</span>
                        </a>
                        <div class="dropdown-content">
                            <a href="#" class="ajax-link" data-page="type-product">Nhóm</a>
                            <a href="#" class="ajax-link" data-page="product-list">Danh sách sản phẩm</a>
                        </div>
                    </li>
                    <li class="nav-link dropdown">
                        <a href="#" class="ajax-link" data-page="customer">
                            <i class='ri-user-2-line icon'></i>
                            <span class="text nav-text">Khách hàng</span>
                        </a>
                        <div class="dropdown-content">
                            <a href="#" class="ajax-link" data-page="type-customer">Loại khách hàng</a>
                            <a href="#" class="ajax-link" data-page="customer-list">Danh sách khách hàng</a>
                        </div>
                    </li>
                    <li class="nav-link dropdown">
                        <a href="#" class="ajax-link" data-page="payment">
                            <i class='ri-bank-card-line icon'></i>
                            <span class="text nav-text">Thanh toán</span>
                        </a>
                        <div class="dropdown-content">
                            <a href="#" class="ajax-link" data-page="payment-history">Lịch sử giao dịch</a>
                            <a href="#" class="ajax-link" data-page="payment-methods">Phương thức thanh toán</a>
                        </div>
                    </li>
                    <li class="nav-link dropdown">
                        <a href="#" class="ajax-link" data-page="user">
                            <i class='ri-user-3-line icon'></i>
                            <span class="text nav-text">Người dùng</span>
                        </a>
                        <div class="dropdown-content">
                            <a href="#" class="ajax-link" data-page="user-role">Phân quyền</a>
                            <a href="#" class="ajax-link" data-page="user-list">Danh sách truy cập</a>
                        </div>
                    </li>
                    <li class="nav-link dropdown">
                        <a href="#">
                            <i class='ri-more-2-line icon'></i>
                            <span class="text nav-text">More</span>
                        </a>
                        <div class="dropdown-content">
                            <a href="#" class="ajax-link" data-page="settings">Settings</a>
                            <a href="#" class="ajax-link" data-page="profile">Profile</a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="bottom-content">
                <ul>
                    <li class="">
                        <a href="#" class="ajax-link">
                            <i class='ri-logout-box-line icon'></i>
                            <span class="text nav-text">Logout</span>
                        </a>
                    </li>
                    <li class="mode">
                        <div class="light-dark">
                            <i class='ri-moon-line icon dark'></i>
                            <i class='ri-sun-line icon light'></i>
                        </div>
                        <span class="mode-text text">Dark Mode</span>
                        <div class="toggle-switch">
                            <span class="switch"></span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="content" class="main-content">
        <div id="loader"></div>
    </div>
    <script type="text/javascript" src="../Admin/lib/control.js"></script>
    <script type="text/javascript" src="../Admin/ajax_calling.js"></script>
</body>

</html>