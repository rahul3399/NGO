<?php
$list = array();
   session_start();
   require_once 'db.php';

    if(empty($_SESSION['user']))
        header('location: login.php');

    if(isset($_REQUEST['description'])) {
        $des = $_REQUEST['description'];
        $user = $_SESSION['user_id'];
        $ngo = $_REQUEST['id'];
        echo $sql = "INSERT INTO `feedback`(`id`, `description`, `ngo_id`, `user_id`)".
        " VALUES (NULL,'$des',$ngo,$user);" ;
         mysqli_query($conn, $sql);
    } 
    
        $ngo_id = $_REQUEST['id']; 

        $sql = "SELECT * FROM `ngo` WHERE id = $ngo_id;" ;
        $result = mysqli_query($conn, $sql);
        $ngo = mysqli_fetch_assoc($result);
    
    
        $sql = "CALL getFeedbacks($ngo_id);";
        $result = mysqli_query($conn, $sql);
    
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
            <div class="panel panel-default" style="padding: 30px;">
                <div class="row">
                    <div class="col-md-10">
                        <h3><?php echo $ngo['name']; ?></h3>
                    </div>
                    <div class="col-md-2">
                        <a class="btn btn-success" href="edit_request.php?id=<?php echo $ngo['id']; ?>">Donate</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p><?php echo $ngo['description']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form action="ngo_details.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $ngo_id;?>">
                            <div class="form-group">
                                <label for="description">Write FeedBack</label>
                                <textarea name="description" class="form-control" id="description" required> </textarea>

                            </div>
                            <input type="submit" value="Submit" class="btn btn-success">
                        </form>
                    </div>
                </div>
                <?php if(count($list) > 0) {  ?>
                <div class="row">
                    <div class="col-md-12">
                        <h2>Feed back</h2>
                    </div>
                    <div class="col-md-8 col-md-offset-2">
                        <?php foreach($list as $item) { 
                            $sql = "SELECT * FROM `users` WHERE id = ". $item['user_id'];
                             $result = mysqli_query($conn, $sql);
                            $user = mysqli_fetch_assoc($result);     
                            
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h4><?php echo $user['name']; ?></h4>
                                <p><?php echo $item['description']; ?></p>
                            </div>
                        </div>
                        <?php } ?>
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