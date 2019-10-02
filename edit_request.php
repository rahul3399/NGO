<?php
    $list = array();
   session_start();

   include_once 'db.php';

    if(empty($_SESSION['user']))
        header('location: login.php');

    require_once 'db.php';
    $ngo = isset($_REQUEST['id']) ? $_REQUEST['id'] : NULL;

    if(isset($_REQUEST['ngo'])) {
        $goods = $_REQUEST['goods'];
        $quantity = $_REQUEST['quantity'];
        $for = $_REQUEST['for_whom'];
        $uid = $_SESSION['user_id'];
        $ngo = $_REQUEST['ngo'];
        $sql = "INSERT INTO `donation_request`(`id`, `user_id`, `ngo_id`, `goods`, `quantity`, `for_whom`, `status`)".
        " VALUES (NULL, '$uid', '$ngo' , '$goods','$quantity','$for', 'PENDING');";
        $result = mysqli_query($conn, $sql);
        if($result) {
            header('location: donar.php');
        } else {
            $error = "Request Failed";
        }
    }

   
    
    
?>
<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Hello,<?php //echo $_SESSION['user']; ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="assets/css/index.css" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<style>
body {
    margin-top: 20px;
    background: #FAFAFA;
}
</style>

<body>

    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">NGO</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php">Dashboard</a></li>
                    <li><a href="request.php">Create Request</a></li>
                    <li><a href="display.php">Notification</a></li>
                    <li><a href="display.php">Feedback</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="glyphicon glyphicon-user"></span>&nbsp;Logged
                            in: <?php echo $_SESSION['user']; ?>
                            &nbsp;<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="login.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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
                        <form action="edit_request.php" method="post">
                        <input type="hidden" name="ngo" value="<?php echo $ngo; ?>">
                            <div class="form-group">
                                <label for="goods">Goods Name</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-gift"></i></span>
                                    <input type="text" name="goods" class="form-control" id="goods" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-shopping-cart"></i></span>
                                    <input type="number" name="quantity" class="form-control" id="quantity" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="for_whom">Usable For</label>
                                <select class="form-control" id="for_whom" name="for_whom">
                                    <option value="ALL">All</option>
                                    <option value="WOMEN">Women</option>
                                    <option value="MEN">Men</option>
                                    <option value="KIDS">Kids</option>
                                </select>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Request" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

</body>

</html>