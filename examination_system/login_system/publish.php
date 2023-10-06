<?php
	require 'config.php';
	$user_id = $_GET['user_id'];
	$id = $_GET['result_id'];
	$ex_id = $_GET['ex_id'];
	$score = $_GET['score'];
	$total_questions = $_GET['total_questions'];
	
	$publish_sql = "SELECT COUNT(*) as count FROM publish_tbl WHERE result_id = '$id'";
	$publish = mysqli_query($conn,$publish_sql);
	if(mysqli_num_rows($publish)>0)
	{
		$publish_data = mysqli_fetch_assoc($publish);
	}
	$count = $publish_data['count'];
		if($count == 0)
		{
			$sql = "INSERT INTO publish_tbl(result_id,user_id,ex_id,total_questions,score)VALUES('$id','$user_id','$ex_id','$total_questions','$score')";
			mysqli_query($conn,$sql);
			header('location:publish_result.php?msg=1');
		}
		else
		{
			header('location:publish_result.php?msg=2');
		}
	
	
?>