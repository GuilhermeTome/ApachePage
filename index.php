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

        .section__header {
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .field {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .field--horizontal {
            flex-direction: row;
            justify-content: flex-start;
            align-items: center;
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
    </script>
</body>
</html>