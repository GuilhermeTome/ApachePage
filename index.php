<?php
// phpcs:disable
$diretorio = dir("./");

$datafiles = [];
$datafolders = [];
while ($arquivo = $diretorio->read()):
    if (
        $arquivo != '.' &&
        $arquivo != '..' &&
        $arquivo != 'index.php' &&
        $arquivo != 'phpinfo.php' &&
        $arquivo != 'README.md' &&
        $arquivo != '.git' &&
        $arquivo != '.gitignore'
    ) {
        if (count(explode('.', $arquivo)) > 1) {
            $datafiles[$arquivo] = $arquivo;
        } else {
            $datafolders[$arquivo] = $arquivo;
        }
    }
endwhile;

ksort($datafolders);
ksort($datafiles);
?>
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

        body {
            background: #f5f5fa;
        }

        .logo {
            color: #6C6C6C;
        }

        .container {
            display: block;
            max-width: 1140px;
            width: 100%;
            padding: 0 20px;
            margin-left: auto;
            margin-right: auto;
        }

		.header {
			display:flex;
			align-items: center;
			height:80px;
			background-color: #fff;
            box-shadow: 0 15px 30px rgba(100, 100, 100, .2);
		}

        .header__container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

		.menu {
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

        .menu__link {
            display: inline-flex;
            align-items: center;
            color: #F05340;
            font-weight: bold;
            text-decoration: none;
            transition: all .3s ease-in-out;
            padding: 10px 20px;
            border-radius: 4px;
        }

        .menu__link + .menu__link {
            margin-left: 10px;
        }

        .menu__link:hover {
            background: rgba(240, 83, 64, .12);
        }

        .section {
            padding-top: 60px;
            padding-bottom: 60px;      
        }

        .section__meta {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .section__info {
            display: flex;
            align-items: center;
        }

        .section__info + .section__info {
            margin-left: 20px;
        }

        .section__info b {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            width: 30px;
            height: 30px;
            background-color: #fff;
            color: #F05340;
            box-shadow: 0 7px 14px rgba(100, 100, 100, .2);
            border-radius: 4px;
            margin-left: 10px;
        }

        .section__title {
            color: #6C6C6C;
            font-weight: 300;
            font-size: 2.5rem;
        }

        .filesystem {
            list-style: none;
        }

        .filesystem__link {
            display: flex;
            align-items: center;
            background: #fefefe;
            color: #6C6C6C;
            font-weight: bold;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(100, 100, 100, .2);
            transition: all .3s ease-in-out;
        }

        .filesystem__link:hover {
            color: #F05340;
            box-shadow: 0 10px 20px rgba(100, 100, 100, .2);
        }

        .filesystem__link:active {
            box-shadow: 0 15px 30px rgba(100, 100, 100, .3);
        }

        .filesystem__link .material-icons {
            margin-right: 10px;
        }

        .filesystem__item {
            margin-top: 20px;
        }
	</style>
</head>
<body>
	<header class="header">
        <div class="header__container container">
            <h1 class="logo">Files and folders</h1>
            <nav class="menu">
                <a class="menu__link" href="phpmyadmin/" target="_blank">phpmyadmin</a>
                <a class="menu__link" href="phpinfo.php" target="_blank">view phpinfo() file</a>
            </nav>
        </div>
	</header>
	<main class="container">
        <article class="content">
            <section class="section">
                <header class="section__header">
                    <div class="section__meta">
                        <p class="section__info">Total Folders <b><?= count(
                            $datafolders
                        ) ?></b></p>
                        <b class="section__info">|</b>
                        <p class="section__info">Total Files <b><?= count(
                            $datafiles
                        ) ?></b></p>
                    </div>
                    <h3 class="section__title">Listening in this folder:</h3>
                </header>
            
                <ul class="filesystem">
                    <?php foreach ($datafolders as $folder): ?>
                        <li class="filesystem__item">
                            <a class="filesystem__link" href="<?= $folder ?>" target="_blank">
                                <i class="material-icons">folder</i>
                                <span><?= $folder ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    <?php foreach ($datafiles as $file): ?>
                        <li class="filesystem__item">
                            <a class="filesystem__link" href="<?= $file ?>" target="_blank">
                                <i class="material-icons">insert_drive_file</i>
                                <span><?= $file ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>

                    <?php $diretorio->close(); ?>
                </ul>
                
            </section>
        </article>
    </main>
</body>
</html>