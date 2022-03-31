<html>
	<head>
		<title>Log Out</title>
		<meta charset='UTF-8'>
	</head>
	<body>
		<?php
			session_start();
			$validSession = require('checkSession.php');
			
			if ($validSession) {
				$oldUser = $_SESSION['valid_user'];
				unset($_SESSION['valid_user']);
				session_destroy();		
			}
			
			if (!empty($oldUser)) {
				echo 'Logged Out<br>';

			}
			else {
				echo 'You were not logged in, and so have not been logged out.<br>';
			}
			include('footer_logged_out.php');
		?>
	</body>
</html>