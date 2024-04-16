<?php

namespace Auth;

use DB\Users;
use Exception\AuthException;
use Helpers\Password;

class User
{
    private Users $userDbObj;

    public function __construct()
    {
        $this->userDbObj = new Users();
    }

    /**
     * @param array $userData
     * @return array
     */
    public function register(array $userData): array
    {
        try {
            $this->checkData($userData);
        } catch (AuthException $e) {
            return [
                'message' => $e->getMessage(),
                'field' => $e->getField(),
                'status' => $e->getCode()
            ];
        }

        foreach ($userData as $key => $value) {
            $userData[$key] = trim($value);
        }

        $result = $this->userDbObj->addUser($userData);

        if ($result['status']) {
            $this->auth($userData['login'], $userData['password']);
        }

        return $result;
    }

    /**
     * @param string $login
     * @param string $password
     * @return array
     */
    public function auth(string $login, string $password): array
    {
        try {
            $userData = $this->userDbObj->getUserByLogin($login);

            if (!$userData) {
                throw new AuthException('Неверный логин', 'login', 0);
            }

            if (!Password::checkPassword($password, $userData['salt'], $userData['password'])) {
                throw new AuthException('Неверный пароль', 'password', 0);
            }

            $this->setUser($login);

            return ['status' => 1];

        } catch (AuthException $e) {
            return [
                'message' => $e->getMessage(),
                'field' => $e->getField(),
                'status' => $e->getCode()
            ];
        }
    }

    public function logout()
    {
        if (isset($_SESSION['userLogin'])) {
            unset($_SESSION['userLogin']);

            return true;

        } else {
            return false;
        }
    }

    /**
     * @param array $userData
     * @return void
     * @throws AuthException
     */
    private function checkData(array $userData): void
    {
        if (empty($userData['login'])) {
            throw new AuthException('Логин не должен быть пустым', 'login', 0);
        }

        if (empty($userData['password'])) {
            throw new AuthException('Пароль не должен быть пустым', 'password', 0);
        }

        if (empty($userData['confirm_password']) || !Password::confirmPassword($userData['password'], $userData['confirm_password'])) {
            throw new AuthException('Пароли не совпадают', 'confirm_password', 0);
        }

        if (empty($userData['email'])) {
            throw new AuthException('Email не должен быть пустым', 'email', 0);
        }

        if (empty($userData['name'])) {
            throw new AuthException('Имя не должно быть пустым', 'name', 0);
        }
    }

    /**
     * @param string $login
     * @return void
     */
    private function setUser(string $login): void
    {
        $_SESSION['userLogin'] = $login;
    }

    /**
     * @return bool
     */
    public function isUserAuth(): bool
    {
        return isset($_SESSION['userLogin']);
    }

    /**
     * @return string
     */
    public function getNameUser(): string
    {
        $login = $_SESSION['userLogin'];
        $user = $this->userDbObj->getUserByLogin($login);

        return $user['name'];
    }
}