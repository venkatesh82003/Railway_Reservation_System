<?php
$isadded=false;
$isnotadded=false;
$isdeleted=false;
$isnotdeleted=false;
$alltrains;
$search;
$validation="false";
function connect(){
  $servername='localhost';
  $username='root';
  $password='';
  $database='project';
  $conn=new mysqli($servername,$username,$password,$database);
  if($conn->connect_error){
      die("Could not connect ".$conn->connect_error);
  }
  return $conn;
}
if(isset($_POST['addtrain'])&&$_SERVER['REQUEST_METHOD']==='POST'){
  $conn=connect();
  if($conn->connect_error){
    die("Could not connect ".$conn->connect_error);
  }
  $Train_No=(int)$_POST['trainno'];
  $Train_Name=$_POST['trainname'];
  $Source=$_POST['source'];
  $Destination=$_POST['destination'];
  $DOJ=$_POST['doj'];
  $sql="INSERT INTO `train` (`Train_No`, `Train_Name`, `Source`, `Destination`, `Date_Of_Journey`) VALUES ('$Train_No','$Train_Name','$Source','$Destination','$DOJ');";
  try{
    if($conn->query($sql)===TRUE){
        $isadded=true;
    }
    else{
    # document.getElementById('result').innerHTML='connection established successfully<br>Not Inserted';
        $isnotadded=true;
    }
  }
  catch(Exception $e){
    "<script>alert('error');</script>;";
  }
}
if(isset($_POST['deletetrain'])&&$_SERVER['REQUEST_METHOD']==='POST'){
  $conn=connect();
  if($conn->connect_error){
    die("Could not connect ".$conn->connect_error);
  }
  $Train_No=(int)($_POST['trainno']);
  $sql="DELETE FROM `train` WHERE `train`.`Train_No` = $Train_No";
  if($conn->query($sql)===TRUE){
      $isdeleted=true;
  }
  else{
      //echo "<script>alert('Could not Delete .$conn->error')</script>";
      $isnotdeleted=true;
  }
  $conn->close();
}
if(isset($_POST['bookticket'])&&$_SERVER['REQUEST_METHOD']==='POST'){
  $conn=connect();
  if($conn->connect_error){
    die("Could not connect ".$conn->connect_error);
  }
  $Train_No=(int)($_POST['trainno']);
  $sql="Select Train_Name from train where Train_No='$Train_No'";
  $Train_Name="";
  try{
    $result=$conn->query($sql);
    $row=$result->fetch_assoc();
    $Train_Name=$row['Train_Name'];
  }
  catch(Exception $e){
    echo "could not found".$e;
  }
  $from=$_POST['from'];
  $to=$_POST['to'];
  $date=$_POST["date"];
  $name=$_POST['name'];
  $age=(int)$_POST['age'];
  $gender=$_POST['gender'];
  $mobileno=$_POST['mobileno'];
  $sql1="INSERT INTO `passenger` (`Train_No`, `Train_Name`, `Source`, `Destination`, `Date_Of_Journey`, `Name`, `Age`, `Gender`, `Mobile_No`) VALUES ('$Train_No','$Train_Name','$from','$to','$date','$name',$age,'$gender','$mobileno');";
  try{
    if($conn->query($sql1)===TRUE){
      echo "<script>alert('Passenger Added Successfully');</script>";
    }
    else{
      echo "<script>alert('Passenger Not Added Due to Some Error');</script>";
    }
  }
  catch(Exception $e){
    echo "<script>alert('Passenger Already Added');</script>";
  }
  $conn->close();
}
if(isset($_POST['cancelticket'])&&$_SERVER['REQUEST_METHOD']==='POST'){
  $conn=connect();
  if($conn->connect_error){
    die("Could not connect ".$conn->connect_error);
  }
  $Train_No=(int)($_POST['trainno']);
  $sql="Select Train_Name from train where Train_No='$Train_No'";
  $Train_Name="";
  try{
    $result=$conn->query($sql);
    $row=$result->fetch_assoc();
    $Train_Name=$row['Train_Name'];
  }
  catch(Exception $e){
    echo "could not found".$e;
  }
  $from=$_POST['from'];
  $to=$_POST['to'];
  $date=$_POST["date"];
  $name=$_POST['name'];
  $age=(int)$_POST['age'];
  $gender=$_POST['gender'];
  $mobileno=$_POST['mobileno'];
  $sql="DELETE from passenger where Train_No='$Train_No' AND Name='$name' AND Age='$age';";
  try{
    if($conn->query($sql)===TRUE){
      echo "<script>alert('Passenger Deleted Successfully');</script>";
    }
    else{
      echo "<script>alert('Passenger Not Deleted Due to Some Error');</script>";
    }
  }
  catch(Exception $e){
    echo "<script>alert('Passenger Already Deleted');</script>";
  }
  $conn->close();
}
if(isset($_POST['signup'])&&$_SERVER['REQUEST_METHOD']==='POST'&&$validation==='true'){
  $conn=connect();
  if($conn->connect_error){
    die("Could not connect ".$conn->connect_error);
  }
  $fname=$_POST['fn'];
  $lname=$_POST['ln'];
  $dob=$_POST['dob'];
  $uname=$_POST['un'];
  $pwd=$_POST['pwd'];
  $mobileno=$_POST['mn'];
  $email=$_POST['em'];
  $sql="INSERT INTO USER (`First_Name`,`Last_Name`,`Date_Of_Birth`,`Username`,`Password`,`Mobile_No`,`Email_Id`) VALUES ('$fname','$lname','$dob','$uname','$pwd','$mobileno','$email');";
  try{
    if($conn->query($sql)===TRUE){
      echo"<script>alert('Signed Up Successfully')</script>";
    }
    else{
      echo"<script>alert('Something went wrong')</script>";
    }
  }
  catch(Exception $e){
    echo"<script>alert('Already Exist')</script>";
  }
  $conn->close();
}
if(isset($_POST['signin'])&&$_SERVER['REQUEST_METHOD']==='POST'){
  $conn=connect();
  if($conn->connect_error){
    die("Could not connect ".$conn->connect_error);
  }
  $uname=$_POST['uname'];
  $pwd=$_POST['pwd'];
  $sql="SELECT * FROM USER WHERE `Username`='$uname' AND `Password`='$pwd';";
  $result=$conn->query($sql);
  try{
    if($result->num_rows>0){
      echo "<script>alert('Logged In Successfully');</script>";
    }
    else{
      echo "<script>alert('Invalid Username Or Password');</script>";
    }
  }
  catch(Exception $e){
    echo "<script>alert('Already Logged In');</script>";
  }
  $conn->close();
}
?>
<DOCTYPE html>
<html>
  <head>
      <meta name="viewport" content="width=device-width" initial-scale="1.0">
      <title>Railways</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
      <style>
        body{
          background-image:url("https://static.tnn.in/photo/msid-98593874,width-100,height-200,resizemode-75/98593874.jpg");
          background-repeat:no-repeat;
          background-size: cover;
        }
        table{
          background-color:rgba(0,0,0,1);
        }
      </style>
      <script >
            function validate(){
    var FN=document.getElementById("fn").value;
    var LN=document.getElementById("ln").value;
    var UN=document.getElementById("un").value;
    var PWD=document.getElementById("pwd").value;
    var DOB=document.getElementById("dob").value;
    //var PC=document.getElementById("pc").value;
    var MN=document.getElementById("mn").value;
    var EM=document.getElementById("em").value;
    var fnv=/^[a-zA-Z]{8,}$/
    var unv=/^[a-zA-Z0-9_]{8,}$/
    var pwdv=/[A-Z]+[@$#&*]+/
    var pcv=/^[0-9]{6}$/
    var mnv=/^[0-9]{10}$/
    var emv=/[a-zA-Z0-9]+@[a-zA-Z]+.com/
    if(!FN.match(fnv)){
        alert("Invalid First name")
    }
    else if(!LN.match(fnv)){
        alert("Invalid Last name")
    }
    else if(!PWD.match(pwdv)||!PWD.length>=8){
        alert("Invalid password")
    }
    else if(!UN.match(unv)){
        alert("Invalid username")
    }
    else if(!PC.match(pcv)){
        alert("Invalid postal code")
    }
    else if(!MN.match(mnv)){
        alert("Invalid mobile number")
    }
    else if(!EM.match(emv)){
        alert("Invalid email")
    }
    else{
      $validation="true";
    }
  }
  function Close(){
    var c=document.getElementById('close');
    c.style.display="none";
  }
         </script>
    </head>
    <body>
      <div class="">
        <ul class="nav bg-dark nav-tabs" style="font-size:larger">
          <li class="nav-item">
            <a href="#home" class="nav-link active dropdown" data-bs-toggle="tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
              <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z"/>
            </svg> Home</a>
          </li>
          <li class="nav-item">
            <a href="#bookticket" class="nav-link dropdown" data-bs-toggle="tab">Book Ticket</a>
          </li>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Train-info</a>
            <div class="dropdown-menu">
              <ul>
                <a href="#alltrains" class="dropdown-item" data-bs-toggle="tab">All Trains</a>
                <a href="#addtrains" class="dropdown-item" data-bs-toggle="tab">Add Train</a>
                <a href="#deletetrain" class="dropdown-item" data-bs-toggle="tab">Delete Train</a>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a href="#cancelticket" class="nav-link dropdown" data-bs-toggle="tab">Cancel Ticket</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#login"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
              <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
              <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
            </svg> Login</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane m-5 active" id="home" >
            <div style="width:30%;">
              <form action="" method="post">
                <input type='hidden' name='search' value='true'>
                <table class="table  table-hover table-dark">
                  <tr>
                    <th>From: </th>
                    <td><input type="text" placeholder="Source Station" size="45" name="from" required></td>
                  </tr>
                  <tr>
                    <th>To: </th>
                    <td><input type="text" placeholder="Destination Station" size="45" name="to" required></td>
                  </tr>
                  <tr>
                    <th>Date: </th>
                    <td><input type="date" name="date"></td>
                  </tr>
                  <tr>
                    <th>Category: </th>
                    <td>
                      <select name="category" class="form-select">
                        <option>All Classes</option>
                        <option>Anubhuti Class (EA)</option>
                        <option>AC First Class (1A)</option>
                        <option>Vistadome AC (EV)</option>
                        <option>Exec. Chair Car (EC)</option>
                        <option>AC 2 Tier (2A)</option>
                        <option>First Class (FC)</option>
                        <option>AC 3 Tier (3A)</option>
                        <option>AC 3 Economy (3E)</option>
                        <option>Vistadome Chair Car (VC)</option>
                        <option>AC Chair car (CC)</option>
                        <option>Sleeper (SL)</option>
                        <option>Vistadome Non AC (VS)</option>
                        <option>Second Sitting (2S)</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><input class="btn btn-lg btn-info col-sm-12" width="30" type="submit" value="Search"></td>
                  </tr>
                </table>
              </form>
            </div>
            <div>
            <?php
              if(isset($_POST['search'])&&$_SERVER['REQUEST_METHOD']==='POST'){
                  $conn=connect();
                  if($conn->connect_error){
                    die("Could not connect ".$conn->connect_error);
                  }
                  $from=$_POST['from'];
                  $to=$_POST['to'];
                  $date=$_POST["date"];
                  $sql="SELECT * FROM `train` WHERE `Source` LIKE '$from' AND `Destination` LIKE '$to' AND `Date_Of_Journey` LIKE '$date'";
                  $search=$conn->query($sql);
                  if($search->num_rows>0){
                    echo "<table class='table'> <tr class='table-primary'><th>Train No.</th><th>Train Name</th><th>Source Station</th><th>Destination Station</th><th>Date Of Journey</th></tr>";
                    while($row=$search->fetch_assoc()){
                      echo "<tr><td>".$row['Train_No']."</td><td>".$row['Train_Name']."</td><td>".$row['Source']."</td><td>".$row['Destination']."</td><td>".$row['Date_Of_Journey']."</td></tr>";
                    }
                    echo "</table>";
                  }
                  else{
                    echo'<div style="color:white;background-color:black;text-align:center;" id="close">
                    <h1>No Train Details Found!!!</h1>
                    <button type="button" onclick="Close()">close</button>
                    </div>';
                  }
                  $conn->close();
                }
              ?>
            </div>
          </div>
          <div class="tab-pane m-5" id="bookticket">
            <form action="" method="POST">
              <input type="hidden" name="bookticket" value="true">
              <table class="table table-warning" style="background-color:burlywood;">
                <tr style="background-color:burlywood;">
                  <th>Train No.</th>
                  <td><input type="text" placeholder="Train No." name="trainno" Required></td>
                </tr>
                <tr>
                  <th>From: </th>
                    <td><input type="text" placeholder="Source Station" size="45" name="from" Required></td>
                  </tr>
                  <tr>
                    <th>To: </th>
                    <td><input type="text" placeholder="Destination Station" size="45" name="to" Required></td>
                  </tr>
                  <tr>
                    <th>Date: </th>
                    <td><input type="date" name="date" Required></td>
                  </tr>
                  <tr>
                    <th>Name</th>
                    <td><input type="text" name="name" placeholder="Person Name" Required></td>
                  </tr>
                  <tr>
                    <th>Age</th>
                    <td><input type="text" name="age" placeholder="Age" Required></td>
                  </tr>
                  <tr>
                    <th>Gender</th>
                    <td><input type="radio" name="gender" value="Male">Male <input type="radio" name="gender" value="Female">Female <input type="radio" name="gender" value="Other">Other</td>
                  </tr>
                  <tr>
                    <th>Mobile No.</th>
                    <td><input type="text" name="mobileno" placeholder="Mobile No." Required></td>
                  </tr>
                  <tr>
                    <td colspan="2"><input class='btn btn-info col-sm-3 col align-self-center'  type="submit" value="Add Passenger"></td>
                  </tr>
              </table>
            </form>     
          </div>
          <div class="tab-pane m-5" id="cancelticket">
            <form action="" method="POST">
              <input type="hidden" name="cancelticket" value="true">
              <table class="table table-warning" style="background-color:burlywood;">
                <tr style="background-color:burlywood;">
                  <th>Train No.</th>
                  <td><input type="text" placeholder="Train No." name="trainno" Required></td>
                </tr>
                <tr>
                  <th>From: </th>
                    <td><input type="text" placeholder="Source Station" size="45" name="from" Required></td>
                  </tr>
                  <tr>
                    <th>To: </th>
                    <td><input type="text" placeholder="Destination Station" size="45" name="to" Required></td>
                  </tr>
                  <tr>
                    <th>Date: </th>
                    <td><input type="date" name="date" Required></td>
                  </tr>
                  <tr>
                    <th>Name</th>
                    <td><input type="text" name="name" placeholder="Person Name" Required></td>
                  </tr>
                  <tr>
                    <th>Age</th>
                    <td><input type="text" name="age" placeholder="Age" Required></td>
                  </tr>
                  <tr>
                    <th>Gender</th>
                    <td><input type="radio" name="gender" value="Male">Male <input type="radio" name="gender" value="Female">Female <input type="radio" name="gender" value="Other">Other</td>
                  </tr>
                  <tr>
                    <th>Mobile No.</th>
                    <td><input type="text" name="mobileno" placeholder="Mobile No." Required></td>
                  </tr>
                  <tr>
                    <td colspan="2"><input class='btn btn-danger col-sm-3 col align-self-center'  type="submit" value="Delete Passenger"></td>
                  </tr>
              </table>
            </form>     
          </div>
          <div class="tab-pane m-auto" id="addtrains" style="width:50%;">
            <h1>Provide Details for Adding Train</h1>
            <form action="" method="post">
                <input type="hidden" name='addtrain' value='true'>
                <table class="table table-primary">
                    <tr>
                        <th>Train Number: </th>
                        <td><input type="text" placeholder="Train No." name="trainno" required>
                    </tr>
                    <tr>
                        <th>Train Name: </th>
                        <td><input type="text" placeholder="Train Name" name="trainname" required>
                    </tr>
                    <tr>
                        <th>Source: </th>
                        <td><input type="text" placeholder="Source Station" name="source" required>
                    </tr>
                    <tr>
                        <th>Destination: </th>
                        <td><input type="text" placeholder="Destination Station" name="destination" required></td>
                    </tr>
                    <tr>
                        <th>Date Of Journey:</th>
                        <td><input type="date" name="doj" required></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="ADD"></td>
                    </tr>
                </table>
            </form>
            <?php
              if($isadded){
                  echo "<script>alert('Train Added Successfully');</script>";
              }
              else if($isnotadded){
                  echo "<script>alert('Train Not Added');</script>";
              }
            ?>
          </div>
          <div class="tab-pane" id="deletetrain">
            <div class="mx-auto">
              <form action="" method="POST">
                <input type="hidden" name='deletetrain' value='true'>
                <table class="table table-danger">
                  <tr>
                    <th>Enter Train No.</th>
                    <td><input type="text" placeholder="Train No." name='trainno'></td>
                  </tr>
                  <tr>
                    <td colspan="2"><input type="submit" value="DELETE"></td>
                  </tr>
                </table>
              </form>
              <?php
                if($isdeleted){
                    echo "<script>alert('Train Deleted Successfully');</script>";
                }
                else if($isnotdeleted){
                    echo "<script>alert('Train Not Deleted ');</script>";
                }
              ?>
            </div>
          </div>
          <div class="tab-pane m-5" style="width:40%;" id="login">
            <ul class="nav bg-dark nav-fill nav-tabs">
              <li class="nav-item">
                <a href="#signin" class="nav-link dropdown active" data-bs-toggle="tab">Sign In</a>
              </li>
              <li class="nav-item">
                <a href="#signup" class="nav-link dropdown" data-bs-toggle="tab">Sign Up</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="signin">
                <form action="" method="POST">
                <input type="hidden" name="signin" value="true">
                  <table class="table table-warning ">
                    <tr>
                      <th>Username: </th>
                      <td><input type="text" name="uname" placeholder="username" size="25"></td>
                    </tr>
                    <tr>
                      <th>Password: </th>
                      <td><input type="password" name="pwd" placeholder="password" size="25"></td>
                    </tr>
                    <tr>
                      <td colspan="2"><input type="submit" value="Login" size="25"></td>
                    </tr>
                  </table>
                </form>
              </div>
              <div class="tab-pane" id="signup">
                <form action="" method="POST">
                    <input type="hidden" name="signup" value="true">
                    <table class="table table-warning">
                      <tr>
                        <th>First Name:</th>
                        <td><input type="text" id="fn" name="fn" value="" required></td>
                      </tr>
                      <tr>
                        <th>Last Name:</th>
                        <td><input type="text" id="ln" name="ln" required></td>
                      </tr>
                      <tr>
                        <th>Date of Birth:</th>
                        <td><input type="date" id="dob" name="dob" required></td>
                      </tr>
                      <tr>
                        <th>User Name:</th>
                        <td><input type="text" id="un" name="un" required></td>
                      </tr>
                      <tr>
                        <th>Password:</th>
                        <td><input type="password" id="pwd" name="pwd" required></td>
                      </tr>
                      <tr>
                        <th>Mobile No:</th>
                        <td><input type="text" id="mn" name="mn" required></td>
                      </tr>
                      <tr>
                        <th>Email Id:</th>
                        <td><input type="text" id="em" name="em" required></td>
                      </tr>
                      <tr><td colspan="2"><input type="submit" onclick="validate()"></td></tr>
                  </table>
                </form>
              </div>
          </div>
          </div>
          <div class="tab-pane" id="alltrains">
            <form action="" method="post">
              <input type="hidden" name="alltrains" value="true">
            </form>
            <?php
              $conn=connect();
              if($conn->connect_error){
                die("Could not connect ".$conn->connect_error);
              }
              $sql="select * from train";
              $alltrains=$conn->query($sql);
              if($alltrains->num_rows>0){
                echo "<table class='table'> <tr class='table-primary'><th>Train No.</th><th>Train Name</th><th>Source Station</th><th>Destination Station</th><th>Date Of Journey</th></tr>";
                while($row=$alltrains->fetch_assoc()){
                  echo "<tr><td>".$row['Train_No']."</td><td>".$row['Train_Name']."</td><td>".$row['Source']."</td><td>".$row['Destination']."</td><td>".$row['Date_Of_Journey']."</td></tr>";
                }
                echo "</table>";
              }
              else{
                echo "No Train Details Found!!!";
              }
              $conn->close();
            ?>
          </div>
        </div>
      </div>
    </body>
</html>