<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        .login-container h3 {
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
            color: #343a40;
        }
        .input-wrapper {
            position: relative;
        }
        .eye-icon {
            position: absolute;
            right: 15px;
            top: 70%;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 10;
        }
        .form-control {
            padding-right: 40px; /* Space for the eye icon */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h3>Member Login</h3>
        <form>
            <div class="mb-3">
                <label for="txtusername" class="form-label">Username</label>
                <input type="text" id="txtusername" class="form-control" placeholder="Enter your username">
            </div>
            <div class="mb-4 input-wrapper">
                <label for="txtpassword" class="form-label">Password</label>
                <input type="password" id="txtpassword" class="form-control" placeholder="Enter your password">
                <span id="togglePassword" class="eye-icon">
                    <i class="bi bi-eye"></i>
                </span>
            </div>
            <div class="d-grid">
                <button type="button" class="btn btn-primary" id="btnlogin">Login</button>
            </div>
        </form>
    </div>

    <script>
        $(function(){
            // Toggle password visibility
            $("#togglePassword").click(function(){
                var passwordField = $("#txtpassword");
                var type = passwordField.attr("type") === "password" ? "text" : "password";
                passwordField.attr("type", type);
                
                // Toggle the icon
                $(this).html(type === "password" ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>');
            });

            $("#btnlogin").click(function(){
                var user = $("#txtusername").val();
                var pass = $("#txtpassword").val();
                if($.trim(user) == "" || $.trim(pass) == ""){
                    alert("Empty user or password. Try again");
                } else if(user.length > 30){
                    alert("Username must be less than 30 characters.");
                } else {
                    $.post("user/checkuser.php", {txtuser: user, txtpassword: pass}, function(data){
                        if(data == 1){
                            window.location.href = "admin/";
                        } else {
                            alert("Invalid username or password. Try again");
                        }
                    });
                }
            });
        });
    </script>

    <!-- Add the Bootstrap Icons CDN for eye icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>

