<?php

namespace DB;

use Exception\AuthException;
use Helpers\Password;

class Users
{
    private const DB_FILEPATH = __DIR__ . '/users.json';

    /**
     * @return array
     */
    private function getUsers(): array
    {
        $data = '';

        if (file_exists(self::DB_FILEPATH)) {
            $data = file_get_contents(self::DB_FILEPATH);
        }

        return $data ? json_decode($data, true) : [];
    }

    /**
     * @param string $login
     * @return array
     */
    public function getUserByLogin(string $login): array
    {
        $users = $this->getUsers();

        $user = array_filter($users, function ($user) use ($login) {
            return $user['login'] === $login;
        });

        return count($user) ? current($user) : $user;
    }

    /**
     * @param array $users
     * @return void
     */
    private function writeUsers(array $users): void
    {
        $data = json_encode($users);

        file_put_contents(self::DB_FILEPATH, $data);
    }

    /**
     * @param array $userData
     * @return array
     */
    public function addUser(array $userData): array
    {
        $users = $this->getUsers();

        $result = $this->checkUser($userData, $users);

        if ($result['status']) {
            $salt = Password::getSalt();

            $userData = [
                'login' => $userData['login'],
                'password' => Password::getPasswordHash($userData['password'], $salt),
                'email' => $userData['email'],
                'name' => $userData['name'],
                'salt' => $salt,
            ];

            $users[] = $userData;

            $this->writeUsers($users);

            $result['message'] = 'Пользователь успешно зарегистрирован';
        }

        return $result;
    }

    /**
     * @param array $userData
     * @param array $users
     * @return array
     */
    private function checkUser(array $userData, array $users): array
    {
        try {
            $userWithLogin = array_filter($users, function ($user) use ($userData) {
                return $user['login'] === $userData['login'];
            });

            if (count($userWithLogin) > 0) {
                throw new AuthException('Пользователь с таким логином уже существует', 'login', 0);
            }

            $userWithEmail = array_filter($users, function ($user) use ($userData) {
                return $user['email'] === $userData['email'];
            });

            if (count($userWithEmail) > 0) {
                throw new AuthException('Такой email уже зарегистрирован', 'email', 0);
            }

            return ['status' => 1];

        } catch (AuthException $e) {
            return [
                'message' => $e->getMessage(),
                'field' => $e->getField(),
                'status' => $e->getCode()
            ];
        }
    }
}