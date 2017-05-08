<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/t/bs/jq-2.2.0,dt-1.10.11/datatables.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all">
    <script type="text/javascript" src="https://cdn.datatables.net/t/bs/jq-2.2.0,dt-1.10.11/datatables.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all">
    <script src="../../../../js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>
    <script src="../../../../js/jquery-1.9.1.min.js"></script>
    <script src="../../../../js/vendor/jquery-1.11.0.min.js"></script>
    <script src="../../../../js/vendor/jquery.gmap3.min.js"></script>
    <script src="../../../../js/plugins.js"></script>
    <script src="../../../../js/main.js"></script>
    <script src="../../../../js/bootstrap.js"></script>
    <script src="../../../../js/scrolltop.js"></script>
    <script src="../../../../js/checkbox.js"></script>
    <script src="../../../../js/modernizr.custom.js"></script>
    <script language="JavaScript" type="text/javascript"></script>
</head>


<?php
include_once "connection.php";
include_once "classes/tweets.php";
session_start();

// Query to get the last scan
$stmt = $DB_con->prepare("SELECT * FROM tweets WHERE tag IS NULL ORDER BY id DESC");
$stmt->execute();
$result = $stmt->fetch();
// end of query

$_SESSION["id"] = $result['id'];

$tweet = new Tweets($DB_con, $result['id']);
?>
<div class="container">
    <div class="jumbotron text-center">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title"><i class="fa fa-twitter fa-lg" aria-hidden="true"></i> <?php echo $tweet->getTweet();?> <i class="fa fa-twitter fa-lg" aria-hidden="true"></i></h2>
            </div>
            <br>
            <p><i class="fa fa-user fa-lg" aria-hidden="true"></i> <?php echo $tweet->getUser();?></p>
            <button type="button" id="pol" class="pol btn btn-success"><i class="fa fa-thumbs-o-up fa-5x" aria-hidden="true"></i></button>
            <button type="button" id="nopol" class="btn btn-danger"><i class="fa fa-thumbs-o-down fa-5x" aria-hidden="true"></i></button>
            <br>
            <br>
            <a href="upload.php">
            <button type="button" id="nopol" class="btn btn-info"><i class="fa fa-cog fa-spin fa-lg fa-fw"></i>Upload new dataset</button>
            </a>
            <br>
            <br>
            <br>
        </div>
    </div>
</div>

<script>
    $( "#pol" ).on( "click", function() {
        window.location.href = 'tagy.php';
    });
</script>
<script>
    $( "#nopol" ).on( "click", function() {
        window.location.href = 'tagn.php';
    });
</script>
