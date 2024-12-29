$(document).ready(function() {
    $('#register_Form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: './register_Process.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Registration successful!');
                    console.log(response);
                    $('#container').removeClass('right-panel-active');
                } else {
                    alert('Registration failed: ' + response.message);
                }
            }
        });
    });

    $('#login_Form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: './login_Process.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Login successful!');
                    window.location.href = response.redirect;
                } else {
                    alert('Login failed: ' + response.message);
                }
            }
        });
    });
});