<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home | ApachePage</title>
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

		.special-section {
			border-bottom: 1px solid black;
			margin: 0px 20px;
			padding: 0 30px 30px 30px;
		}
		.special-section ul {
			list-style: none;
		}
		.special-section li {
			margin-bottom: 5px;	
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

				$datafiles = [];
				$datafolders = [];
				while($arquivo = $diretorio -> read()):
					if($arquivo != '.' && $arquivo != '..' && $arquivo != 'index.php' && $arquivo != 'phpinfo.php' && $arquivo != 'README.md' && $arquivo != '.git' && $arquivo != '.gitignore'){
						if(count(explode('.', $arquivo)) > 1) {
							$datafiles[$arquivo] = $arquivo;
						} else {
							$datafolders[$arquivo] = $arquivo;
						}
					}
				endwhile;

				ksort($datafolders);
				ksort($datafiles);
				foreach($datafolders as $folder):
					?>
						<li>
							<a href="<?= $folder; ?>" target="_blank">
								<i class="material-icons">folder</i>
								<span><?= $folder; ?></span>
							</a>
						</li>
					<?php
				endforeach;
				foreach($datafiles as $file):
					?>
						<li>
							<a href="<?= $file; ?>" target="_blank">
								<i class="material-icons">insert_drive_file</i>
								<span><?= $file; ?></span>
							</a>
						</li>
					<?php
				endforeach;

				$diretorio->close();
				?>
			</ul>
		</div>
	</section>
	<section class="special-section">
		<ul>
			<li>Total Folders: <?= count($datafolders) ?></li>
			<li>Total Files:  <?= count($datafiles) ?></li>
		</ul>
	</section>
</body>
</html>