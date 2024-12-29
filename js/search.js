$(document).ready(function() {
    let searchTimeout;
    
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimeout);
        const query = $(this).val();
        
        if (query.length >= 2) {
            searchTimeout = setTimeout(function() {
                $.ajax({
                    url: 'ajax_search.php',
                    method: 'POST',
                    data: { q: query },
                    success: function(response) {
                        $('#searchResults').html(response).show();
                    }
                });
            }, 300);
        } else {
            $('#searchResults').hide().empty();
        }
    });

    // Hide results when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.nav__search').length) {
            $('#searchResults').hide();
        }
    });

    // Handle form submission
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        const query = $('#searchInput').val();
        window.location.href = 'search.php?q=' + encodeURIComponent(query);
    });
});
