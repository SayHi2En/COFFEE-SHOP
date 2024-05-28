<?php

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: index.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - Coffee Time</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            font-family: 'Raleway', sans-serif;
        }

        .login-container {
            display: flex;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-color: #fff;
        }

        .login-image {
            background-image: url('assets/img/coffee.jpg');
            background-size: cover;
            background-position: center;
            width: 300px;
            height: 400px;
        }

        .login-form {
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 300px;
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn-primary {
            width: 100%;
        }

        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-image"></div>
        <div class="login-form">
            <h2>Welcome!</h2>
            <p>Please enter the details to log in to your account.</p>
            <form action="login.php" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $username; ?>" required>
                    <span class="error-message"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                    <span class="error-message"><?php echo $password_err; ?></span>
                </div>
                <?php 
            if(!empty($login_err)){
                echo '<div class="error-message">' . $login_err . '</div>';
            }        
            ?>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Log In</button>
                </div>
                <div class="form-group text-center">
                    <a href="register.php" class="btn btn-secondary">Register Account</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
