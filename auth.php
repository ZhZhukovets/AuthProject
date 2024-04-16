<? include ('header.php'); ?>
    <div>
        <p class="title">Авторизация</p>

        <form id="auth_form" class="form_input">
            <div class="input_form">
                <label for="login">Логин</label>
                <input type="text" name="login">
                <span class="error"></span>
            </div>
            <div class="input_form">
                <label for="password">Пароль</label>
                <input type="password" name="password">
                <span class="error"></span>
            </div>

            <button type="submit" class="btn">Авторизоваться</button>
        </form>
    </div>
<? include ('footer.php'); ?>