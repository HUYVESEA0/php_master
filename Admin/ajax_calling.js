$(document).ready(function() {
    var initialPage = new URLSearchParams(window.location.search).get('page') || 'home';
    loadPage(initialPage);

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
            history.pushState(null, '', '?page=' + page);
        }, 1000);
    });

    $('#add-type-product').on('submit', function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '../../func_ajax.php', // Corrected path
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#result').html(response);
            }
        });
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
