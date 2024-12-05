$(document).ready(function() {

    $('#content').load('../Pages/home.php', function() {
        history.pushState(null, '', '?page=home');
    });

    $('.ajax-link').click(function(event) {
        event.preventDefault();
        var page = $(this).data('page');
        loadPage(page);
        history.pushState(null, '', '?page=' + page);
    });

    // Handle back/forward navigation
    window.onpopstate = function() {
        var page = new URLSearchParams(window.location.search).get('page');
        if (page) {
            loadPage(page);
        } else {
            loadPage('home');
            
        }
    };
});

function loadPage(page) {
    $.ajax({
        url: '../Pages/' + page + '.php',
        type: 'POST',
        data: {page: page},
        success: function(data) {
            console.log(data);
            $('#content').html(data);
        }
    });
}