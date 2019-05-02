<?php

//test_api.php

//include('Api.php');

function delete($id)
{
	$conn= new mysqli("localhost","root","","restapi");
	$query = "DELETE FROM tbl_sample WHERE id = '".$id."'";
	$statement = $conn->query($query);
	if($statement)
	{
		$data[] = array(
			'success'	=>	'1'
		);
	}
	else
	{
		$data[] = array(
			'success'	=>	'0'
		);
	}
	return $data;
}

function fetch_single($id)
{
	$conn= new mysqli("localhost","root","","restapi");
	$query = "SELECT * FROM tbl_sample WHERE id='".$id."'";
	$statement = $conn->query($query);
	if($statement)
	{
		$row = $statement->fetch_assoc();
		
			$data['first_name'] = $row['first_name'];
			$data['last_name'] = $row['last_name'];
			$data['email'] = $row['email'];
		//}
		return $data;
	}
}
 
function fetch_all()
{
	$conn= new mysqli("localhost","root","","restapi");
	$query = "SELECT * FROM tbl_sample ORDER BY id";
	$statement = $conn->query($query);
	if($statement)
	{
		while($row = $statement->fetch_assoc())
		{
			$data[] = $row;
		}
		return $data;
	}
}

function insert()
{
	
	$conn= new mysqli("localhost","root","","restapi");
	if(isset($_POST["first_name"]))
	{
		
		$query = "
		INSERT INTO tbl_sample (first_name, last_name,email) VALUES 
		('".$_POST["first_name"]."','".$_POST["last_name"]."','".$_POST["email"]."')";
		//echo print_r($query); die;
		$statement = $conn->query($query);
		if($statement)
		{
			$data[] = array(
				'success'	=>	'1'
			);
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
	}
	else
	{
		$data[] = array(
			'success'	=>	'0'
		);
	}
	return $data;
}

function update()
{
	$conn= new mysqli("localhost","root","","restapi");
	if(isset($_POST["first_name"]))
	{
		$form_data = array(
			'first_name'	=>	$_POST['first_name'],
			'last_name'	=>	$_POST['last_name'],
			'id'			=>	$_POST['id']
		);
		$query = "
		UPDATE tbl_sample 
		SET first_name = '".$_POST["first_name"]."', last_name = '".$_POST["first_name"]."', email = '".$_POST["email"]."'
		WHERE id = '".$_POST["id"]."'
		";

		$statement = $conn->query($query);
		if($statement)
		{
			$data[] = array(
				'success'	=>	'1'
			);
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
	}
	else
	{
		$data[] = array(
			'success'	=>	'0'
		);
	}
	return $data;
}

$api_object = (object)[]; 

if($_GET["action"] == 'fetch_all')
{
	$data = fetch_all();
}

if($_GET["action"] == 'insert')
{
	$data = insert();
}

if($_GET["action"] == 'fetch_single')
{
	$data = fetch_single($_GET["id"]);
}

if($_GET["action"] == 'update')
{
	$data = update();
}

if($_GET["action"] == 'delete')
{
	$data = delete($_GET["id"]);
}

echo json_encode($data);

?>