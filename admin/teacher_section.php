<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link href='../css/fullcalendar.css' rel='stylesheet' />
	<link href='../css/fullcalendar.print.css' rel='stylesheet' media='print' />
	<script src='../js/moment.min.js'></script>
	<script src='../js/jquery.min.js'></script>
	<script src='../js/fullcalendar.min.js'></script>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<script src="../js/bootstrap.min.js" type="text/javascript"></script>
	<!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>-->
	<style type="text/css">
		/* For this page only */
		body { font-family:Arial, Helvetica, sans-serif; font-size:13px; }
		.wrap { text-align:center; line-height:21px; padding:20px; }

		/* For pagination function. */
		ul.pagination {
			text-align:center;
			color:#829994;
		}
		ul.pagination li {
			display:inline;
			padding:0 3px;
		}
		ul.pagination a {
			color:#0d7963;
			display:inline-block;
			padding:5px 10px;
			border:1px solid #cde0dc;
			text-decoration:none;
		}
		ul.pagination a:hover,
		ul.pagination a.current {
			background:#0d7963;
			color:#fff;
		}

		table {
			border-collapse: collapse;
			width:50%;
		}

		table, td, th {
			border: 1px solid black;
		}
	</style>
</head>
<body>
<?php //cheching session
session_start();

if ($_SESSION['user_id']) {
	//echo $_SESSION['user_id'];
}else{
	header("Location: ../login.php?status=not");
}


 ?>
<!-- navbar -->
 <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><?php echo $_SESSION['user_id']; ?></a>
    </div>
    <div>
    
      <ul class="nav navbar-nav navbar-right">
        <li><a href="admin_home.php"><span class="glyphicon glyphicon-user"></span> Home</a></li>
        <li><a href="../logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<!-- navbar end -->
<div class="container">
 
		<table  class="table table-bordered table-hover">
			<tr>
				<th>Teacher ID</th>
				<th>Teacher Name</th>
				<th>Mobile</th>
				<th colspan="2">Options</th>
			</tr>

<?php
include_once('../connection.php');
include_once('function.php');

$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;

$per_page = 15; // Set how many records do you want to display per page.

$startpoint = ($page * $per_page) - $per_page;

$statement = "`teacher` ORDER BY `teacher_id` ASC"; // Change `records` according to your table name.

$results = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");

if (mysqli_num_rows($results) != 0) {

	// displaying records.
	while ($row = mysqli_fetch_array($results)) {
		echo "<tr><td>".$row['teacher_id'] . '</td><';
		echo "<td>".$row['teacher_name'] . '</td><';
		echo "<td>".$row['mobile'] . '</td><';
		echo '<td><a href="teacher_edit.php?teacher_id=' . $row['teacher_id'] . '&page='.$page.'">Edit</a></td>';
		echo '<td><a href="delete.php?id=' . $row['teacher_id'] . '&page='.$page.'&id_type=teacher_id">Delete</a></td></tr>';
	}

} else {
	echo "No records are found.";
}
?>
</table>
<?php
		if (isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$page=$_GET['page'];
			echo pagination($statement,$per_page,$page,$url='?');

		}else{
			 // displaying paginaiton.
		echo pagination($statement,$per_page,$page,$url='?');
		}


?>

</div>

<p align="center"><a href="teacher_new.php?page=<?php echo "$page"; ?>">Add a new record</a></p>
</body>
</html>
