<?php if(REQ !== true) die(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Redirect</title>

		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	</head>
	<body>
		<div style="width:800px; margin: 0 auto; padding-top:50px;">
			<div class="alert alert-info">
				<h4>Redirecting!</h4>
				You're currently being redirected, please wait. If the page doesn't load click <a href="<?php echo $redirectto; ?>">here</a>.
			</div>
		</div>
		<script src="http://code.jquery.com/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script>
			setTimeout(function(){ window.location = "<?php echo $redirectto; ?>"; }, 1000);
		</script>
	</body>
</html>