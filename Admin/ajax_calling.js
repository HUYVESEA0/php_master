$(document).ready(function() {

    $('#content').load('../Admin/Pages/home.php', function() {
        history.pushState(null, '', '?page=home');
    });

    window.onpopstate = function() {
        var page = new URLSearchParams(window.location.search).get('page');
        if (page) {
            $('#loader').show();
            setTimeout(function() {
                loadPage(page);
            }, 1000);
        } else {
            $('#loader').show();
            setTimeout(function() {
                loadPage('home');
            }, 1000);
        }
    };

    $('.ajax-link').click(function(event) {
        event.preventDefault();
        var page = $(this).data('page');
        $('#loader').show();
        setTimeout(function() {
            if (page.includes('add-')) {
                loadPageAdd(page);
            } else if (page.includes('-list')) {
                loadPageList(page);
            } else if (page.includes('type-')) {
                loadPageType(page);
            } else if (page.includes('payment-')) {
                loadPagePayment(page);
            } else {
                loadPage(page);
            }
            history.pushState(null, '', '?page=' + page);
        }, 1000);
    });

});

function loadPage(page) {
    $.ajax({
        url: '../Admin/Pages/' + page + '.php',
        type: 'POST',
        data: {page: page},
        success: function(data) {
            console.log(data);
            $('#content').html(data);
        },
        complete: function() {
            $('#loader').hide();
        }
    });
}

function loadPageAdd(page) {
    $.ajax({
        url: '../Admin/Pages/c/' + page + '.php',
        type: 'POST',
        data: {page: page},
        success: function(data) {
            console.log(data);
            $('#content').html(data);
        },
        complete: function() {
            $('#loader').hide();
        }
    });
}

function loadPageList(page) {
    $.ajax({
        url: '../Admin/Pages/l/' + page + '.php',
        type: 'POST',
        data: {page: page},
        success: function(data) {
            console.log(data);
            $('#content').html(data);
        },
        complete: function() {
            $('#loader').hide();
        }
    });
}

function loadPageType(page) {
    $.ajax({
        url: '../Admin/Pages/t/' + page + '.php',
        type: 'POST',
        data: {page: page},
        success: function(data) {
            console.log(data);
            $('#content').html(data);
        },
        complete: function() {
            $('#loader').hide();
        }
    });
}

function loadPagePayment(page) {
    $.ajax({
        url: '../Admin/Pages/api/' + page + '.php', // Corrected path
        type: 'POST',
        data: {page: page},
        success: function(data) {
            console.log(data);
            $('#content').html(data);
        },
        complete: function() {
            $('#loader').hide();
        }
    });
}
