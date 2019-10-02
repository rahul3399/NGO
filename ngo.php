<?php
$list = array();
   session_start();

    if(empty($_SESSION['user']))
        header('location: login.php');

    require_once 'db.php';
    if(isset($_REQUEST['s']) && isset($_REQUEST['id'])) {
        $id = $_REQUEST['id'];
        if($_REQUEST['s'] == 'a'){
            $msg = 'Accepted';
            $sql = "UPDATE `donation_request` SET `status`= 'ACCEPTED' WHERE id = $id;";
        } else if($_REQUEST['s'] == 'r') {
            $msg = 'Rejected';
            $sql = "UPDATE `donation_request` SET `status`= 'REJECTED' WHERE id = $id;";
        }
            
        $result = mysqli_query($conn, $sql);

        if($result)
            $success = "Donation $msg Successfully";

    }



    $ngo_id = $_SESSION['ngo_id'];
    $sql = "CALL getDonationRequestes($ngo_id);";
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
    <title>Hello,<?php echo $_SESSION['user']; ?></title>
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
           <?php if(isset($success)){ ?>
            <div class="alert alert-sucCess alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $success; ?>
                </div>
            <?php } ?>
        <div class="row">
            <div class="col-lg-12 col-md-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-xl-3">
                            <div class="card bg-c-blue order-card">
                                <div class="card-block">
                                    <h4 class="m-b-20">Total Customer</h4>
                                    <h2 class="text-right"><i class="fa fa-user f-left"></i><span>486</span></h2>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-3">
                            <div class="card bg-c-pink order-card">
                                <div class="card-block">
                                    <h4 class="m-b-20">Total Customer</h4>
                                    <h2 class="text-right"><i class="fa fa-credit-card f-left"></i><span>486</span></h2>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Donar Name</th>
                        <th>Goods</th>
                        <th>Quantity</th>
                        <th>For</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody> <?php foreach ($list as $item) { ?>
                    <tr>
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['goods']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo $item['for_whom']; ?></td>
                        <td>
                        <a class="btn btn-warning" href="ngo.php?s=a&id=<?php echo $item['id']; ?>">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a class="btn btn-danger" href="ngo.php?s=r&id=<?php echo $item['id']; ?>">
                            <span class="glyphicon glyphicon-trash"></span>        
                        </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

</body>

</html>