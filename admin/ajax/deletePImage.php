<?php
if (isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ))
{
	include('../../api.php');
	$api = new API;
	$api->dbConnect();
	if (!empty($_POST['name'])) {
	$catid = mysqli_real_escape_string($api->db, $_POST['name']);
	$pid = mysqli_real_escape_string($api->db, $_POST['pid']);
		$cur = $_POST['cur'];
		
		if (preg_match("/vidr/i", $cur)) {
			if (!preg_match("/youtube.com/i", $catid)) {
				unlink('../../uploads/video/'.$catid);
			}
			$q = mysqli_query($api->db, "DELETE FROM n_page_videos WHERE pagevid_url='$catid' AND pagevid_pgid=$pid");	
		} else if (preg_match("/imgr/i", $cur)) {
			unlink('../../uploads/large/'.$catid);
  			unlink('../../uploads/thumbs/'.$catid);
			
			$q = mysqli_query($api->db, "DELETE FROM n_page_images WHERE pgimg_url='$catid' AND pgimg_page_id=$pid");
		}

	
	}
	
	if (!empty($_POST['prname'])) {
	$catid = mysqli_real_escape_string($api->db, $_POST['prname']);
	$pid = mysqli_real_escape_string($api->db, $_POST['pid']);
		$cur = $_POST['prcur'];
		
		if (preg_match("/vidr/i", $cur)) {
			if (!preg_match("/youtube.com/i", $catid)) {
				unlink('../../uploads/pride/video/'.$catid);
			}
			$q = mysqli_query($api->db, "DELETE FROM n_pr_videos WHERE prvid_url='$catid' AND pr_id=$pid");	
		} else if (preg_match("/imgr/i", $cur)) {
			unlink('../../uploads/pride/large/'.$catid);
  			unlink('../../uploads/pride/thumbs/'.$catid);
			
			$q = mysqli_query($api->db, "DELETE FROM pr_images WHERE primg_url='$catid' AND pr_id=$pid");
		}

	
	}
}
?>
