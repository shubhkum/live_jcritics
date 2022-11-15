<?php 
include('../include/db.php');
?>
<?php
include('../classes/class.php');
?>
<?php
include('../include/session.php');
?>
<?php 
	if(isset($_POST['comment_text'])){
		$comment=$_POST['comment_text'];
		date_default_timezone_set("Asia/Kolkata");
		$currentTime=time();
		$dateTime=strftime("%B-%d-%Y %H:%M:%S",$currentTime);
		$postid=$_GET['id'];
		if(isset($_SESSION['user_id'])){
			$name=$_SESSION['user_name'];
		}
		elseif (isset($_COOKIE['user_id'])) {
			$name=$_COOKIE['user_name'];
		}
		if(empty($comment)){
			$_SESSION['ErrorMessage']='All Fields Are Required';
		}
		elseif(strlen($comment)>500){
			$_SESSION['ErrorMessage']="Only 500 characters are allowed in comments";
		}	
		else{
			global $con;
			$query="INSERT INTO comments(datetime,name,comment,admin_panel_id) VALUES ('$dateTime','$name','$comment','$postid')";
			$execute=mysqli_query($con,$query);
			if($execute){
				global $con;
				$query2="SELECT * FROM comments WHERE datetime='$dateTime' AND name='$name' AND comment='$comment' AND admin_panel_id='$postid'";
				$execute2=mysqli_query($con,$query2);
				while ($datarows=mysqli_fetch_array($execute2)) {
				 		$commentdate=$datarows['datetime'];
				 		$commentername=$datarows['name'];
				 		$commentbyuser=$datarows['comment'];
				 	?>
					<div class="commentblock">
						<img src="images/facebook-anonymous-app.jpg" alt="" style="width:30px;height: 30px;margin-left: 10px;margin-top:5px;" class="float-left">
					<p class="comment-info" style="margin-left:50px; "><?php echo $commentername; ?></p>	
					<p class="description"  style="margin-left:50px;margin-top: -20px; "><?php echo $commentdate; ?></p>
					<p class="comment"  style="margin-left:50px; margin-top: -5px;"><?php echo $commentbyuser; ?></p>
					</div>		
				    <?php 		
				 }			    
			}
			else{
				$_SESSION['ErrorMessage']="Something Went Wrong";
			}
		}
    }
?>