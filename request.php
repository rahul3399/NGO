<?php
ob_start();
session_start();
require_once 'dbconnect.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
  
}
// select logged in users detail
$res = $conn->query("SELECT * FROM donar WHERE id=" . $_SESSION['user']);
$userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);

if(isset($_GET['edit'])){
    $id=$_GET['edit'];
    $res1 = $conn->query("SELECT * FROM article WHERE id=" . $id );
    if(count($res1)==1){
        $row=$res1->fetch_array();

    }
}




if (isset($_POST['submit'])) {

    $title = trim($_POST['title']); // get posted data and remove whitespace
    $content = trim($_POST['content']);
        
        $stmts = $conn->prepare("INSERT INTO article(title,content,author) VALUES(?, ?, ?)");
        $stmts->bind_param("sss", $title, $content, $userRow['email']);
        $res = $stmts->execute();//get result
        $stmts->close();
}

?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hello,<?php echo $userRow['email']; ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="assets/css/index.css" type="text/css"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>

<!-- Navigation Bar-->
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
     
                <li><a href="display.php">Create Request</a></li>
                <li><a href="display.php">Notification</a></li>
                <li><a href="display.php">Feedback</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <span
                            class="glyphicon glyphicon-user"></span>&nbsp;Logged
                        in: <?php echo $userRow['uname']; ?>
                        &nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>




<div class="container">
    <!-- Jumbotron-->
    <div class="jumbotron">
        <h4>Hello, <?php echo $userRow['name']; ?></h4>
    </div>
    <div class="container">
        <div class="col-md-6">
        <form>

                <div class="form-group">
                    <label for="sel1">Select list:</label>
                    <select class="form-control" id="sel1">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                    </select>
                </div> 

                <div class="form-group">

                <label for="EmailDemo">Your Email:</label>

                <input type="email" class="form-control" id="EmailDemo" aria-describedby="emailHelp" placeholder="Enter email">

                <small id="emailHelp" class="form-text text-muted">Please enter your primary email, we will send confirmation email!</small>

                </div>

                <div class="form-group">

                <label for="passDemo">Enter Password:</label>

                <input type="password" class="form-control" id="passDemo" aria-describedby="passHelp" placeholder="Password">

                <small id="passHelp" class="form-text text-muted">Must be 8 characters long</small>

                </div>

                <div class="form-check">

                <input type="checkbox" class="form-check-input" id="CheckDemo">

                <label class="form-check-label" for="CheckDemo">Agree with Terms & Conditions?</label>

                </div>

                <button type="submit" class="btn btn-success">Create Account</button>

                </form>    
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
