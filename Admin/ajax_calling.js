$(document).ready(function() {

    $('#content').load('../Admin/Pages/', function() {
        history.pushState(null, '', '?page=home');
    });

    $('.ajax-link').click(function(event) {
        event.preventDefault();
        var page = $(this).data('page');
        $('#loader').show();
        setTimeout(function() {
        loadPage(page);
        history.pushState(null, '', '?page=' + page);
        }, 1000);
    });

    // Handle back/forward navigation
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
//
