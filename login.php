<?php
session_start();
session_destroy();
require_once 'db.php';

if (isset($_REQUEST['user']) && isset($_REQUEST['password'])) {
    $user_name = $_REQUEST['user'];
    $password = $_REQUEST['password'];
    $sql = "CALL checkLogin('$user_name', '$password');";
    $result = mysqli_query($conn, $sql);
    
    if($result->num_rows > 0) {
        $user = mysqli_fetch_array($result);
        header("location: index.html");
    } else {
        $error = "Invalid Username or Password";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <?php if(isset($error)){ ?>
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $error; ?>
                </div>
                <?php } ?>
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>
                    <div class="panel-body">
                        <form action="login.php" method="post">
                            <div class="form-group">
                                <label for="user">User Name</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input type="email" name="user" class="form-control" id="user" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input type="password" name="password" class="form-control" id="password" required>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-success btn-block" value="Login" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>

</html>