<?php 

if(isset($_POST['fname']) && 
   isset($_POST['uname']) && 
   isset($_POST['pass'])){

    include "../db_conn.php";

    $fname = $_POST['fname'];
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];

    $data = "fname=".$fname."&uname=".$uname;
    
    if (empty($fname)) {
    	$em = "Full name is required";
    	header("Location: ../index.php?error=$em&$data");
	    exit;
    }else if(empty($uname)){
    	$em = "User name is required";
    	header("Location: ../index.php?error=$em&$data");
	    exit;
    }else if(empty($pass)){
    	$em = "Password is required";
    	header("Location: ../index.php?error=$em&$data");
	    exit;
    }else {

		$sql = "SELECT * FROM users WHERE username = ?";
    	$stmt = $conn->prepare($sql);
    	$stmt->execute([$uname]);

     
          $user = $stmt->fetch();

          $username =  $user['username'];

          if($username != $uname){
            
              // hashing the password
    	$pass = password_hash($pass, PASSWORD_DEFAULT);

    	$sql1 = "INSERT INTO users(fname, username, password) 
    	        VALUES(?,?,?)";
    	$stmt1 = $conn->prepare($sql1);
    	$stmt1->execute([$fname, $uname, $pass]);

    	header("Location: ../index.php?success=Your account has been created successfully");
	    exit;
           

          }else {
            $em = "User exists";
            header("Location: ../index.php?error=$em&$data");
            exit;
         }

      
		

    	
    }


  }else {
	header("Location: ../index.php?error=error");
	exit;
}
