<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../public/css/nav_control.css">
    <link rel="stylesheet" href="../public/css/loader.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script type="text/javascript" src="../core/jquery-3.7.1.min.js"></script>
    <title>ADMIN TOOLS</title>

</head>
<body>
    
    <nav class="slidebar">
            <header>
                <div class="image-text">
                    <span class="image">
                        <i class='bx bx-cog spin'></i>
                    </span>
                    <div class="text header-text">
                        <span class="name">ADMIN</span>
                        <span class="profession">TOOLS</span>
                        <div class="timer"></div>
                    </div>
                </div>
                <i class='bx bx-chevron-left toggle icon-switch'></i>
            </header>

            <div class="menu-bar">
                <div class="menu">
                    <ul>
                        <li class="search-box">
                            <i class='bx bx-search icon' ></i>
                            <input type="search" placeholder="Search">
                        </li>
                    </ul>
                    <ul class="menu-links">
                        <li class="nav-link">
                            <a href="#" class="ajax-link" data-page="dashboard">
                                <i class='bx bx-home-alt icon'></i>
                                <span class="text nav-text">Dashboard</span>
        
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="#" class="ajax-link" data-page="product">
                                <i class='bx bx-category icon'></i>
                                <span class="text nav-text">Sản phẩm</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="#" class="ajax-link" data-page="customer">
                                <i class='bx bxs-user-detail icon'></i>
                                <span class="text nav-text">Khách hàng</span>
        
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="#" class="ajax-link" data-page="payment">
                                <i class='bx bx-credit-card icon'></i>
                                <span class="text nav-text">Thanh toán</span>
        
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="#" class="ajax-link" data-page="user">
                                <i class='bx bx-user icon'></i>
                                <span class="text nav-text">Người dùng</span>
        
                            </a>
                        </li> 
                    </ul>
                </div>
                <div class="bottom-content">
                    <ul>
                        <li class="">
                            <a href="#" class="ajax-link">
                                <i class='bx bx-log-out icon'></i>
                                <span class="text nav-text">Logout</span>
                            </a>
                        </li>
                        <li class="mode">
                            <div class="light-dark">
                                <i class='bx bx-moon icon dark'></i>
                                <i class='bx bx-sun icon light'></i>
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
    <script type="text/javascript" src="../public/js/nav_control.js"></script>
    <script type="text/javascript" src="./ajax_nav.js"></script>
</body>
</html>