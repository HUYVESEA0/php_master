<?php
require_once 'Admin/fucn.php';
$conn = connect();

// Get categories for the navigation menu
$sql = "SELECT * FROM product_categories";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="./index.css">
    <title>Responsive dropdown menu - Bedimcode</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header class="header">
        <nav class="nav container">
            <div class="nav__data">
                <a href="/" class="nav__logo">
                    <i class="ri-planet-line"></i> SINH DƯỢC SHOP
                </a>
                
                <div class="nav__search">
                    <form id="searchForm" class="search-form">
                        <input type="text" name="q" id="searchInput" placeholder="Tìm kiếm sản phẩm..." class="search-input">
                        <button type="submit" class="search-button">
                            <i class="ri-search-line"></i>
                        </button>
                    </form>
                    <div id="searchResults" class="search-results"></div>
                </div>

                <div class="nav__cart">
                    <a href="cart.php" class="cart-icon">
                        <i class="ri-shopping-cart-2-line"></i>
                        <span class="cart-count">0</span>
                    </a>
                </div>

                <div class="nav__toggle" id="nav-toggle">
                    <i class="ri-menu-line nav__burger"></i>
                    <i class="ri-close-line nav__close"></i>
                </div>
            </div>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="dropdown__item">
                        <div class="nav__link">
                            Danh mục <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                        </div>

                        <ul class="dropdown__menu">
                            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                            <li>
                                <a href="index.php?category_id=<?php echo $row['id']; ?>" class="dropdown__link">
                                    <i class="ri-pie-chart-line"></i> <?php echo $row['name']; ?>
                                </a>                          
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="dropdown__item">
                        <div class="nav__link">
                        <i class="ri-user-line"></i> <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                        </div>

                        <ul class="dropdown__menu">
                            <li>
                                <a href="./auth/sign_log.php" class="dropdown__link">
                                    <i class="ri-user-line"></i> Profiles
                                </a>                          
                            </li>

                            <li>
                                <a href="#" class="dropdown__link">
                                    <i class="ri-lock-line"></i> Accounts
                                </a>
                            </li>

                            <li>
                                <a href="#" class="dropdown__link">
                                    <i class="ri-message-3-line"></i> Messages
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</body>
</html>
