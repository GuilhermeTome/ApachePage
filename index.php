<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: 'Montserrat', sans-serif;
			font-stretch: 100;
		}

		.navbar {
			display:flex;
			height:80px;
			padding: 0 0 0 20px;
			justify-content: space-between;
			align-items: center;
			background-color: #424242;
			color: white;
		}
		.navbar div {
			display: flex;
			justify-content: space-between;
			align-items: center;
			height: 80px;
			line-height: 80px;
		}
		.navbar a {
			color: white;
			text-decoration: none;
			padding: 0 30px;
			font-stretch: 300;
			transition: 300ms;
		}
		.navbar a:hover {
			background-color: #e0e0e0;
			color: black;
		}

		.section {
			padding: 30px 50px;
		}
		.section h3 {
			margin-bottom: 20px;
		}
		.section ul {
			list-style: none;
		}
		.section li {
			padding: 10px;
			margin-bottom: 5px;
			border-bottom: 1px solid black;			
		}
		.section a{
			text-decoration: none;
			display: flex;
			align-items: center;
			color: black;
		}
		.section a span:hover {
			color: #0277bd;
			text-decoration: underline;
		}

	</style>
</head>
<body>
	<nav class="navbar">
		<h1>Files and folders</h1>
		<div>
			<a href="phpmyadmin/" target="_blank">phpmyadmin</a>
			<a href="phpinfo.php" target="_blank">view phpinfo() file</a>
		</div>
	</nav>
	
	<section class="section">
		<h3>Listing in this folder:</h3>

		<div>
			<ul>
				<?php
				$diretorio = dir("./");

				while($arquivo = $diretorio -> read()):
					if($arquivo != '.' && $arquivo != '..' && $arquivo != 'index.php' && $arquivo != 'phpinfo.php' && $arquivo != 'README.md' && $arquivo != '.git' && $arquivo != '.gitignore'):
						$count = count(explode('.', $arquivo));
					?>
						<li>
							<a href="<?= $arquivo; ?>" target="_blank">
								<i class="material-icons"><?= ($count > 1)? "insert_drive_file" : "folder" ;?></i>
								<span><?= $arquivo; ?></span>
							</a>
						</li>
					<?php
					endif;
				endwhile;

				$diretorio->close();
				?>
			</ul>
		</div>
	</section>
</body>
</html>