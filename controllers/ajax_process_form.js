$(document).ready(function() {
    $('#register_Form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: './auth/register_Process.php',
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
            url: './auth/login_Process.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    console.log(response);
                    alert('Login successful!');
                    window.location.href = 'controllers/Nav_control.php'; // Redirect to dashboard or another page
                } else {
                    alert('Login failed: ' + response.message);
                }
            }
        });
    });
});