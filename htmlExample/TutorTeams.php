<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  </head>
  <body>
  <script>
	function myfu(team)
	{
		document.getElementById("team_id").value=team;
	}
   </script>
<div>
<nav class="navbar navbar-toggleable-md navbar-inverse bg-primary">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">BestTeam</a>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-md-0">
      <li class="nav-item">
        <a class="nav-link" href="file:///C:/Users/CJX/Desktop/WebsiteHTML/TutorHome">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Teams</a>
      </li>
	  <li class="nav-item">
	    <a class="nav-link" href="file:///C:/Users/CJX/Desktop/WebsiteHTML/TutorStudents">Students</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href="file:///C:/Users/CJX/Desktop/WebsiteHTML/TutorMessage">Message area</a>
	  </li>
    </ul>
	<ul class="navbar-nav mr-right mt-2 mt-md-0">
	  <li class="nav-item">
        <a class="nav-link" href="file:///C:/Users/CJX/Desktop/WebsiteHTML/StudentHelp">Help</a>
      </li>
	  <li class="nav-item">
	    <a class="nav-link" href="file:///C:/Users/CJX/Desktop/WebsiteHTML/HomePage#">Logout</a>
	  </li>
    </ul>
  </div>
</nav>
</div>
<br />
<div>
<form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
</div>

<div>
    <h2>Present teams:</h2>
    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#AddTeam">Add a new team</button>
</div>


<?php
$servername = "localhost";
$username = "root";
$password = "no password";

try {
    $connection = new PDO("mysql:host=$servername;dbname=csc8099", $username, $password);
    
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	if(isset($_POST["recipient_name"]))
	{
		
		$add_team = $connection->prepare("INSERT INTO `csc8099`.`team` (`team_id`) VALUES (:team_id);");
		$add_team -> bindParam(':team_id', $_POST["recipient_name"]);
		$add_team -> execute();
		header('Location: http://localhost/htmlExample/TutorTeams.php');
		exit;
	}
	
	if(isset($_POST["team_id"])){
		if(isset($_POST["student_id"]) && $_POST["student_id"] !== ""){
			$select_student_id = $connection->prepare("SELECT * FROM csc8099.student where student_id = :student;");
			$select_student_id -> bindParam(':student', $_POST["student_id"]);
			$select_student_id -> execute();
			$num_rows=$select_student_id -> rowCount();
			if ($num_rows==0){
				$add_student = $connection -> prepare(
						"INSERT INTO `csc8099`.`student` (`student_id`,`student_name`,`e_mail`,`team_id`) VALUES (:student_id, :student_name ,:e_mail, :team_id);");
				$add_student -> execute(
						array(':student_id' => $_POST['student_id'],
						':student_name' => $_POST['student_name'],
						':e_mail' => $_POST['e_mail'],
						':team_id' => $_POST['team_id'])
						);
			}
			else {
				$change_team = $connection -> prepare("UPDATE `csc8099`.`student` SET `team_id`=:team_id WHERE `student_id`=:student_id;");
				$change_team -> execute(array(':student_id'=>$_POST['student_id'], ':team_id'=>$_POST['team_id']));
			}
		}
		header('Location: http://localhost/htmlExample/TutorTeams.php');
	}
	
    $select_team_id = "SELECT team_id FROM csc8099.team";
	$result_team_id = $connection->query($select_team_id);
	$select_student_id = $connection->prepare("SELECT * FROM csc8099.student where team_id = :teamx;");
	$select_student_id->bindParam(':teamx', $teamx);
	
	echo "<div id=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">";
	while($row = $result_team_id->fetch())
	{
	$teamx = $row["team_id"];
	$select_student_id -> execute();
	$result = $select_student_id;
	$i = 0;
	$i++;
    // output data of each row
	echo "
	
    <div class=\"card\">
    <div class=\"card-header\" role=\"tab\" id=\"headingOne\">
      <h5 class=\"mb-0\">
        <a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#$teamx\" aria-expanded=\"true\" aria-controls=\"$teamx\" >
          $teamx
        </a>
      </h5>
    </div>

    <div id=\"$teamx\" class=\"collapse\" role=\"tabpane$i\" aria-labelledby=\"headingOne\">
      <div class=\"card-block\">
	  
	<table class=\"table table-hover table-sm\">
       <thead class=\"thead-default\">
       <tr>
       <th>#</th>
       <th>Student ID</th>
       <th>Student Name</th>
       <th>E-mail Address</th>
	   <th><button type=\"button\" class=\"btn btn-primary btn-sm\" data-toggle=\"modal\" data-target=\"#EditTeam\">Edit the team</button></th>
	   <th><button type=\"submit\" class=\"btn btn-success btn-sm\" data-toggle=\"modal\" data-target=\"#AddStudent\" onclick=\"myfu('$teamx')\">Add a student</button></th>
	   <th><button type=\"button\" class=\"btn btn-danger btn-sm\">Delete the team</button></th>
       </tr>
       </thead>
	   </tbody>
	";
    $num = 1;
    while($row = $result->fetch()) {
		$value = $row["student_id"];
		$student_name = $row["student_name"];
		
		$value = $row["student_id"];
		$e_mail = $row["e_mail"];
		$num2 =$num++;
		
          echo "<tr>
          <th scope=\"row\">$num2 </th>
          <td>$value </td>
          <td>$student_name </td>
          <td>$e_mail </td>
	      <td><button type=\"button\" class=\"btn btn-primary btn-sm\" data-toggle=\"modal\" data-target=\"#EditStudent\">Edit the student</button></td>
	      <td><button type=\"button\" class=\"btn btn-danger btn-sm\">Delete the student</button></td>
          </tr>";
	}
	echo "
	</tbody></table><br>
	</div>
	</div>
    </div>";
    }
	echo"</div>";
}

catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>


<!--<div id="accordion" role="tablist" aria-multiselectable="true">
  <div class="card">
    <div class="card-header" role="tab" id="headingOne">
      <h5 class="mb-0">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Team 1
        </a>
		<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#EditTeam">Edit the team</button>
		<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#AddStudent">Add a student</button>
		<button type="button" class="btn btn-danger btn-sm">Delete the team</button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
      <div class="card-block">
	    
		<table class="table table-hover table-sm">
  <thead class="thead-default">
    <tr>
      <th>#</th>
      <th>Student ID</th>
      <th>Student Name</th>
      <th>E-mail Address</th>
	  <th></th>
	  <th></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>10001</td>
      <td>Tom</td>
      <td>Tom@gmail.com</td>
	  <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#EditStudent">Edit the student</button></td>
	  <td><button type="button" class="btn btn-danger btn-sm">Delete the student</button></td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>10002</td>
      <td>Ben</td>
      <td>Benasd@126.com</td>
	  <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#EditStudent">Edit the student</button></td>
	  <td><button type="button" class="btn btn-danger btn-sm">Delete the student</button></td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>10003</td>
      <td>Owen</td>
      <td>abba@twitter.com</td>
	  <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#EditStudent">Edit the student</button></td>
	  <td><button type="button" class="btn btn-danger btn-sm">Delete the student</button></td>
    </tr>
  </tbody>
</table>
		
		
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" role="tab" id="headingTwo">
      <h5 class="mb-0">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Team 2
        </a>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="card-block">
        Answer 2
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" role="tab" id="headingThree">
      <h5 class="mb-0">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Team 3
        </a>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="card-block">
        Answer 3
      </div>
    </div>
  </div>
</div>
-->
<div class="modal fade" id="AddTeam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add a team</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form action="http://localhost/htmlExample/TutorTeams.php" method="POST"><!-- changed URL -->
      <div class="modal-body">
        
          <div class="form-group">
            <label for="recipient-name" class="form-control-label">Please input the team's ID:</label>
            <input type="text" class="form-control" id="recipient-name" name="recipient_name">
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Confirm</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<div class="modal fade" id="EditTeam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit the team</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="form-control-label">Please input the team's name:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="AddStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add a student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="http://localhost/htmlExample/TutorTeams.php" method="post">
		  <input type="text" name="team_id" id="team_id" readonly style="display:none" />
          <div class="form-group">
            <label for="recipient-name" class="form-control-label">Please input the student's ID:</label>
            <input type="text" class="form-control" id="recipient-name" name="student_id">
          </div>
		  <div class="form-group">
            <label for="recipient-name" class="form-control-label">Please input the student's name:</label>
            <input type="text" class="form-control" id="recipient-name" name="student_name">
          </div>
		  <div class="form-group">
            <label for="recipient-name" class="form-control-label">Please input the student's E-mail:</label>
            <input type="text" class="form-control" id="recipient-name" name="e_mail">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Confirm</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="EditStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit the student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="form-control-label">Please input the student's ID:</label>
            <input type="text" class="form-control" id="recipient-name"  >
          </div>
		  <div class="form-group">
            <label for="recipient-name" class="form-control-label">Please input the student's name:</label>
            <input type="text" class="form-control" id="recipient-name"  >
          </div>
		  <div class="form-group">
            <label for="recipient-name" class="form-control-label">Please input the student's E-mail:</label>
            <input type="text" class="form-control" id="recipient-name"  >
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </body>
</html>