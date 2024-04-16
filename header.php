<? include ('core.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="css/style.css" rel="stylesheet"/>
</head>
<body>
    <div>
        <? if ($userObj->isUserAuth()) { ?>
            <div>
                <div>
                    <p>Добро пожаловать, <?= $userObj->getNameUser() ?></p>
                </div>
                <button id="logout" class="btn">Выйти</button>
            </div>
        <? } ?>