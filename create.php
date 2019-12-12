<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */


if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_user = array(
            "firstname" => $_POST['firstname'],
            "lastname"  => $_POST['lastname'],
            "email"     => $_POST['email'],
            "age"       => $_POST['age'],
            "location"  => $_POST['location']
        );
		$x=0;
		if (preg_match("/^[a-zA_Z -]+$/", $_POST['firstname'])===0)
		{
			echo "name is not valid";
			$x++;
		}
		if (preg_match("/^[a-zA_Z -]+$/", $_POST['lastname'])===0)
		{
			echo "name is not valid";
			$x++;
		}
		$email=$_POST["email"];
		if(filter_var($email,FILTER_VALIDATE_EMAIL))
		{
		}
		else{
			echo("<br>$email is not a valid email address");
			$x++;
		}
		$age=$_POST['age'];
		if(!is_numeric($age))
		{
			echo"<br> age should be in digit";
			$x++;
		}
		else if (strlen($age)>3)
		{
			echo"not a valid age";
			$x++;
		}
			
		if($x<1)
		{			

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "users",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
		}
		else{
			echo"there are some errors";
		}
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['firstname']; ?> successfully added.</blockquote>
<?php } ?>


<h2>Add a user</h2>

<form name="form"  method="post" onsubmit="return validate()";>
<script>/*
function validate()
{
	var fname=document.forms["form"]["firstname"].value;
	var lname=document.forms["form"]["lastname"].value;
	var email=document.forms["form"]["email"].value;
	var age=document.forms["form"]["age"].value;
	var loc=document.forms["form"]["location"].value;
	
	if(fname=="")
	{
		alert("enter first name");
		document.forms["form"]["firstname"].focus;
		return false; 
	}
	else if(!isNaN(fname))
	{
		alert("enter valid name");
		document.forms["form"]["firstname"].focus;
		return false;
	}
	
	else if(lname=="")
	{
		alert("enter last name");
		document.forms["form"]["lastname"].focus;
		return false; 
	}
	else if(!isNaN(lname))
	{
		alert("enter valid name");
		document.forms["form"]["lastname"].focus;
		return false; 
	}
	var atposition=email.indexOf("@");
	var dotposition=email.lastIndexOf(".");
	if(atposition<1||dotposition<atposition+2||dotposition+2>=email.length)
	{
		alert("enter a valid email");
		document.forms["form"]["email"].focus;
		return false; 
	}
	else if(age=="")
	{
		alert("enter age");
		document.forms["form"]["age"].focus;
		return false; 
	}
	else if(isNaN(age))
	{
		alert("age must me neumeric");
		document.forms["form"]["age"].focus;
		return false; 
	}
    else if(loc=="")
	{
		alert("enter location");
		document.forms["form"]["location"].focus;
		return false; 
	}
	
	
}*/
	</script>
    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="firstname">
    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" id="lastname">
    <label for="email">Email Address</label>
    <input type="text" name="email" id="email">
    <label for="age">Age</label>
    <input type="text" name="age" id="age">
    <label for="location">Location</label>
    <input type="text" name="location" id="location">
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
