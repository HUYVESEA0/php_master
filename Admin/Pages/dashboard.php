<?php
session_start();
require_once('../fucn.php');
$conn = connect();

// Fetch data for statistics
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'];
$totalProducts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM products"))['count'];
$totalSales = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(amount) as total FROM payments"))['total'];
$totalCategories = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM product_categories"))['count'];

disconnect($conn);
?>
    <style>
        .dashboard {
            padding: 20px;
            font-family: 'Roboto', sans-serif;
        }
        .dashboard h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .stat {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            width: 22%;
        }
        .stat h3 {
            margin-bottom: 10px;
            font-size: 18px;
        }
        .stat p {
            font-size: 24px;
            font-weight: bold;
        }
        .charts {
            display: flex;
            justify-content: space-around;
        }
        .charts canvas {
            width: 45%;
            height: 300px;
        }
    </style>
    <div class="dashboard">
        <h1>Bảng phân tích kinh doanh</h1>
        <div class="stats">
            <div class="stat">
                <h3>Tổng số người dùng</h3>
                <p><?php echo $totalUsers; ?></p>
            </div>
            <div class="stat">
                <h3>Tổng số sản phẩm</h3>
                <p><?php echo $totalProducts; ?></p>
            </div>
            <div class="stat">
                <h3>Tổng doanh thu</h3>
                <p><?php echo number_format($totalSales, 0, ',', '.'); ?> VND</p>
            </div>
            <div class="stat">
                <h3>Tổng số danh mục</h3>
                <p><?php echo $totalCategories; ?></p>
            </div>
        </div>
        <div class="charts">
            <canvas id="salesChart"></canvas>
            <canvas id="categoriesChart"></canvas> <!-- New canvas for categories chart -->
        </div>
    </div>

    <script>
        // Fetch sales data for the chart
        fetch('../Admin/func_ajax.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'action=getSalesData'
        })
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('salesChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Doanh thu',
                        data: data.sales,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

        // Fetch categories data for the chart
        fetch('../Admin/func_ajax.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'action=getCategoriesData'
        })
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('categoriesChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Danh mục sản phẩm',
                        data: data.counts,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw + ' VND';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>


