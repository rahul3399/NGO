<?php
$list = array();
   session_start();

    if(empty($_SESSION['user']))
        header('location: login.php');

    require_once 'db.php';
    $sql = "CALL getNGOList();";
    $result = mysqli_query($conn, $sql);
    $list = array();
    
    
    if($result->num_rows > 0) {
        $num = $result->num_rows;
        for ($i=0; $i < $num; $i++) { 
            $list[$i] = mysqli_fetch_assoc($result);
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
                            in: <?php //echo $_SESSION['user']; ?>
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
            <div class="col-md-10 col-md-offset-1">
                <?php foreach ($list as $item) { ?>
                <div class="panel panel-default" style="padding: 30px;">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <h3><?php echo $item['name'] ?></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p><?php echo $item['description'] ?></p>
                        </div>
                        <div class="col-md-12">
                            <a href="ngo_details.php?id=<?php echo $item['id'] ?>" class="btn btn-primary pull-right">More Info</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

</body>

</html>