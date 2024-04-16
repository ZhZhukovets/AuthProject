<? include ('header.php'); ?>

    <div class="reg_block">
        <p class="title">Регистрация</p>

        <form id="reg_form"  class="form_input">
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
            <div class="input_form">
                <label for="confirm_password">Подтвердите пароль</label>
                <input type="password" name="confirm_password">
                <span class="error"></span>
            </div>
            <div class="input_form">
                <label for="email">Email</label>
                <input type="email" name="email">
                <span class="error"></span>
            </div>
            <div class="input_form">
                <label for="name">Имя</label>
                <input type="text" name="name">
                <span class="error"></span>
            </div>

            <button id="reg" type="submit" class="btn">Зарегистрироваться</button>
        </form>
    </div>

<? include ('footer.php'); ?>