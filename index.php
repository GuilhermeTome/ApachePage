<?php
// phpcs:disable
class FileDirectory
{
    private $dir;
    private $files;
    private $folders;
    private $blacklist = [
        '.',
        '..',
        'index.php',
        'phpinfo.php',
        'README.md',
        '.git',
        '.gitignore',
    ];

    public function __construct($dir)
    {
        $this->dir = dir($dir);

        while ($file = $this->dir->read()) {
            if (!in_array($file, $this->blacklist)) {
                if (count(explode('.', $file)) > 1) {
                    $this->files[$file] = $file;
                } else {
                    $this->folders[$file] = $file;
                }
            }
        }
    }

    public function getFiles($sort = true)
    {
        $sort ? ksort($this->files) : krsort($this->files);

        return $this->files;
    }

    public function getTotalFiles()
    {
        return count($this->files);
    }

    public function getFolders($sort = true)
    {
        $sort ? ksort($this->folders) : krsort($this->folders);

        return $this->folders;
    }

    public function getTotalFolders()
    {
        return count($this->folders);
    }

    public function getAll($sort = true)
    {
        $all = array_merge($this->getFiles(), $this->getFolders());

        $sort ? ksort($all) : krsort($all);

        return $all;
    }

    public function getTotal()
    {
        return count($this->getAll());
    }

    public function close()
    {
        $this->dir->close();
    }

    public function renderFolders($sort = true)
    {
        ?>
        <?php foreach ($this->getFolders($sort) as $folder): ?>
            <li class="filesystem__item">
                <a class="filesystem__link" href="<?= $folder ?>" target="_blank">
                    <i class="material-icons">folder</i>
                    <span><?= $folder ?></span>
                </a>
            </li>
        <?php endforeach; ?>
        <?php
    }

    public function renderFiles($sort = true)
    {
        ?>
        <?php foreach ($this->getFiles($sort) as $file): ?>
            <li class="filesystem__item">
                <a class="filesystem__link" href="<?= $file ?>" target="_blank">
                    <i class="material-icons">insert_drive_file</i>
                    <span><?= $file ?></span>
                </a>
            </li>
        <?php endforeach; ?>
        <?php
    }
}

$orderBy = filter_input(INPUT_GET, 'order');
$asc = true;
$desc = false;

if ($orderBy === "asc") {
    $asc = true;
} elseif ($orderBy === "desc") {
    $desc = true;
    $asc = false;
}

$fs = new FileDirectory('./');
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
        :root {
           font-size: 14px; 
        }

        @media screen and (min-width: 660px) {
            :root {
                font-size: 15px;
            }
        }

        @media screen and (min-width: 768px) {
            :root {
                font-size: 16px;
            }
        }

        * {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: 'Montserrat', sans-serif;
		}

        body {
            background: #f5f5fa;
        }

        .logo {
            position: relative;
            color: #6C6C6C;
            z-index: 1;
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
			width: 100%;
            height: 80px;
			background-color: #fff;
            box-shadow: 0 15px 30px rgba(100, 100, 100, .2);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999;
		}

        .header__container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-toggler {
            position: relative;
            width: 30px;
            height: 15px;
            background: none;
            border: none;
            z-index: 1;
        }

        .nav-toggler__item {
            position: absolute;
            left: 0;
            width: 100%;
            height: 3px;
            background: #000;
            border-radius: 100px;
            transition: all .3s ease-in-out;
        }        

        .nav-toggler__item:nth-child(1) {
            top: 0;
        }
        
        .nav-toggler__item:nth-child(2) {
            top: 6px;
        }

        .nav-toggler__item:nth-child(3) {
            top: 12px;
        }

        .nav-toggler.is-active .nav-toggler__item {
            top: 50%;
            transform: translate3d(0, -50%, 0);
        }

        .nav-toggler.is-active .nav-toggler__item:nth-child(1) {
            transform: translate3d(0, -50%, 0) rotate(45deg);            
        }
        
        .nav-toggler.is-active .nav-toggler__item:nth-child(2) {
            transform: translate3d(0, -50%, 0) rotate(45deg);            
        }

        .nav-toggler.is-active .nav-toggler__item:nth-child(3) {
            transform: translate3d(0, -50%, 0) rotate(-45deg);            
        }

		.menu {
			display: flex;
            flex-direction: column;
			justify-content: center;
			align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #f5f5fa;
            pointer-events: none;
            opacity: 0;
            z-index: 0;
            transition: all .3s ease-in-out;
		}

        .menu.is-active {
            opacity: 1;
            pointer-events: all;
        }

        @media screen and (min-width: 660px) {
            .menu {
                position: static;
                pointer-events: all;
                flex-direction: row;
                justify-content: space-between;
                background: transparent;
                opacity: 1;
            }

            .nav-toggler { display: none; }
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

        main {
            margin-top: 80px;
            position: relative;
        }

        .section {
            padding-top: 60px;
            padding-bottom: 60px;      
        }

        .section__header {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }


        .section__meta {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 10px;
        }

        @media screen and (min-width: 660px) {
            .section__header {
                flex-direction: row;
            }

            .section__meta {
                justify-content: flex-start;
            }
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
            font-weight: 600;
            font-size: 2rem;
            text-align: center;
            margin-top: 5px;
            margin-bottom: 20px;
        }


        @media screen and (min-width: 660px) {
            .section__title {
                font-size: 2.5rem;
                font-weight: 300;
                text-align: left;
            }
        }

        .section__sub_title {
            color: #6C6C6C;
            font-weight: 300;
            font-size: 1rem;
            padding-left: 10px;
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

        .field {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        @media screen and (min-width: 660px) {
            .field--horizontal {
                flex-direction: row;
                justify-content: flex-start;
                align-items: center;
            }
        }

        .field--horizontal .field__label {
            margin-right: 10px;
        }

        .field__input {
            flex: 1;
            cursor: pointer;
            border: 1px solid #fff;
            background: #fff;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(100, 100, 100, .2);
            padding: 10px 20px;
            outline: none;
            font-size: 1rem;
            font-family: 'Montserrat', sans-serif;
            transition: all .3s ease-in-out;
        }

        .field__input:hover {
            box-shadow: 0 8px 16px rgba(100, 100, 100, .2);
        }

        .field__input:focus {
            box-shadow: 0 12px 24px rgba(100, 100, 100, .3);
        }
	</style>
</head>
<body>
	<header class="header">
        <div class="header__container container">
            <h1 class="logo">Files and folders</h1>
            <button class="nav-toggler">
                <span class="nav-toggler__item"></span>
                <span class="nav-toggler__item"></span>
                <span class="nav-toggler__item"></span>
            </button>
            <nav class="menu">
                <a class="menu__link" href="phpmyadmin/" target="_blank">phpmyadmin</a>
                <a class="menu__link" href="phpinfo.php" target="_blank">view phpinfo() file</a>
            </nav>
        </div>
	</header>
	<main class="container">
        <article class="content">
            <section class="section">
                <div class="section__meta">
                    <p class="section__info">Total Folders <b><?= $fs->getTotalFolders() ?></b></p>
                    <b class="section__info">|</b>
                    <p class="section__info">Total Files <b><?= $fs->getTotalFiles() ?></b></p>
                </div>
                <header class="section__header">
                    <h3 class="section__title">Listening in this folder</h3>
                    <form name="orderbyForm" method="get">
                        <div class="field field--horizontal">
                            <label for="order" class="field__label">Order by: </label>
                            <select name="order" id="order" class="field__input">
                                <option <?= $asc
                                    ? "selected"
                                    : "" ?> value="asc">Crescent(↑)</option>
                                <option <?= $desc
                                    ? "selected"
                                    : "" ?> value="desc">Descendent(↓)</option>
                            </select>
                        </div>
                    </form>
                </header>
                <ul class="filesystem">
                    <?php $fs->renderFolders($asc); ?>
                    <?php $fs->renderFiles($asc); ?>
                </ul>
                
            </section>
        </article>
    </main>

    <script>
        const orderby = document.forms.orderbyForm;
        const order = orderby.elements.order;
        order.addEventListener('change', e => {
            orderby.submit();
        });

        const toggler = document.querySelector(".nav-toggler");
        const nav = document.querySelector('.menu');

        toggler.addEventListener('click', function (event) {
            this.classList.toggle('is-active');
            nav.classList.toggle('is-active');
        });
    </script>
</body>
</html>