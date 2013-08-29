<html>
	<head>
		<title>Online server management</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	</head>
	<body style="background: #fff url(./img/y.background.light.png) top center fixed no-repeat;">
		<script src="http://code.jquery.com/jquery.js"></script>
		<script src="./js/bootstrap.min.js"></script>
		<script src="./js/jquery.inputHistory.min.js"></script>
	
		<div style="margin:0 auto; width:900px; padding-top:15px;">
		
			<div class="navbar">
				<div class="navbar-inner">
					<a class="brand" href="index.php">Online RCON</a>
				
				
					<ul class="nav">
						<li class="divider-vertical"></li>
						<li {if $page == "home"}class="active"{/if}>
							<a href="./"><i class="icon-home"></i> Home</a>
						</li>
						{if $isadmin}
							<li {if $page == "logs"}class="active"{/if}><a href="./?page=logs"><i class="icon-leaf"></i> Logs</a></li>
							<li {if $page == "users"}class="active"{/if}><a href="#"><i class="icon-user"></i> Users</a></li>
							<li {if $page == "servers"}class="active"{/if}><a href="./?page=servers"><i class="icon-hdd"></i> Servers</a></li>
						{/if}
					</ul>
					
					<ul class="nav pull-right">
						<li class="divider-vertical"></li>
						<li><a href="?action=logout"><i class="icon-share-alt"></i> Logout</a></li>
					</ul>
				</div>
			</div>
		
		
			<div class="alert alert-success">
				<strong>Beta!</strong> this utility is still in development, please contact hello@entirely.pro if you see any issues
			</div>
