<? include ('header.php'); ?>

<? if (!$userObj->isUserAuth()) { ?>
    <div>
        <div>
            <p class="title">Добро пожаловать</p>
        </div>

        <div class="link_auth">
            <a class="link" href="reg.php">Зарегистрироваться</a>
            <a class="link" href="auth.php">Авторизоваться</a>
        </div>
    </div>
<? } ?>
<? include ('footer.php'); ?>