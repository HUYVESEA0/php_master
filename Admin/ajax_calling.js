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
            loadPage(page);
            history.pushState(null, '', '?page=' + page);
        }, 1000);
    });

    $(document).on('submit', '#addTypeProductForm', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '../Admin/func_ajax.php',
            data: $(this).serialize() + '&action=addCategory',
            dataType: 'json',
            success: function(response) {
                $('#message').text(response.message);
                if (response.success) {
                    $('#addTypeProductForm')[0].reset();
                    setTimeout(function() {
                    location.reload();
                    },500);
                }
            }
        });
    });

    $(document).on('submit', '#addProductForm', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('action', 'addProduct');
        $.ajax({
            type: 'POST',
            url: '../Admin/func_ajax.php',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                $('#message').text(response.message);
                if (response.success) {
                    $('#addProductForm')[0].reset();
                    setTimeout(function() {
                        location.reload();
                    },500);
                }
            }
        });
    });

    // Tải danh mục khi trang được tải
    loadCategories();
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

function loadCategories() {
    $.ajax({
        type: 'POST',
        url: '../Admin/func_ajax.php',
        data: {action: 'getCategories'},
        dataType: 'json',
        success: function(response) {
            var categorySelect = $('#categoryId');
            categorySelect.empty();
            $.each(response, function(index, category) {
                categorySelect.append($('<option>', {
                    value: category.id,
                    text: category.name
                }));
            });
        }
    });
}