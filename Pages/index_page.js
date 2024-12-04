document.addEventListener('DOMContentLoaded', function() {
    //Dashboard
    var textViewDashboard = document.querySelector('.text-view-dashboards');
    if (textViewDashboard) {
        var typedDashboard = new Typed('.text-view-dashboards', {
            strings: ['Bạn hiện đang truy cập Dashboard',
                'Dashboard tổng quan',
                'Thông tin tổng quan',
                'Cập nhật mới nhất'],
            typeSpeed: 50,
            backSpeed: 50,
            backDelay: 1000,
            loop: true
        });
    } else {
        console.error('Element .text-view-dashboard not found');
    }
    //Users
    var textViewUsers = document.querySelector('.text-view-users');
    if (textViewUsers) {
        var typedUsers = new Typed('.text-view-users', {
            strings: ['Quản lý thông tin người dùng',
                'Thêm người dùng',
                'Xóa người dùng',
                'Chỉnh sửa người dùng'],
            typeSpeed: 50,
            backSpeed: 50,
            backDelay: 1000,
            loop: true
        });
    } else {
        console.error('Element .text-view-users not found');
    }
    //Products
    var textViewProducts = document.querySelector('.text-view-products');
    if (textViewProducts) {
        var typedProducts = new Typed('.text-view-products', {
            strings: ['Quản lý thông tin sản phẩm',
                'Thêm sản phẩm',
                'Xóa sản phẩm',
                'Chỉnh sửa sản phẩm'],
            typeSpeed: 50,
            backSpeed: 50,
            backDelay: 1000,
            loop: true
        });
    } else {
        console.error('Element .text-view-products not found');
    }
    //Customers
    var textViewCustomers = document.querySelector('.text-view-customers');
    if (textViewCustomers) {
        var typedCustomers = new Typed('.text-view-customers', {
            strings: ['Quản lý thông tin khách hàng',
                'Thêm khách hàng',
                'Xóa khách hàng',
                'Chỉnh sửa khách hàng'],
            typeSpeed: 50,
            backSpeed: 50,
            backDelay: 1000,
            loop: true
        });
    } else {
        console.error('Element .text-view-customers not found');
    }
    //Payments
    var textViewPayments = document.querySelector('.text-view-payments');
    if (textViewPayments) {
        var typedPayments = new Typed('.text-view-payments', {
            strings: ['Quản lý thông tin thanh toán',
                'Thêm thanh toán',
                'Xóa thanh toán',
                'Chỉnh sửa thanh toán'],
            typeSpeed: 50,
            backSpeed: 50,
            backDelay: 1000,
            loop: true
        });
    } else {
        console.error('Element .text-view-payments not found');
    }
});