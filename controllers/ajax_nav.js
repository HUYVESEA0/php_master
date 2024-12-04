$(document).ready(function() {
    $('.ajax-link').click(function(event) {
        event.preventDefault();
        var page = $this.data('page');
        loadPage(page);
    });
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