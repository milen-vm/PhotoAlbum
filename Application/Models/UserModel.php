<?php
namespace MyMVC\Application\Models;

use MyMVC\Library\MVC\Model;
use MyMVC\Library\Core\Database;
use MyMVC\Application\Exceptions\UserException;

class UserModel extends Model
{

    const AUTHENTICATED_ROLE = 'authent';

    const ADMINISTRATION_ROLE = 'admin';

    const MODEL_TABLE_NAME = 'users';

    public function __construct()
    {
        parent::__construct(['table' => self::MODEL_TABLE_NAME]);
    }

    public function register($name, $password, $email, $birthDay = null)
    {
        $emailUsed = $this->find([
            'select' => 'id',
            'where' => 'email = ?'
        ], [$email]);

        if (count($emailUsed) > 0) {
            throw new UserException('This email is already used.', 403);
        }

        $pairs = [
	       'name' => $name,
	       'password' => password_hash($password, PASSWORD_DEFAULT),
	       'email' => $email,
	       'role_id' => 2
        ];

        if ($this->insert($pairs)) {
            return true;
        }

        throw new UserException('Registration failed', 500);
    }

    public function login($email, $password)
    {
        $result = $this->find([
            'select' => 'u.id, u.name, u.email, u.password, r.name AS role',
            'from' => 'users AS u',
            'join' => ['roles AS r ON u.role_id = r.id'],
            'where' => 'email = ?'
        ], [$email]);

        if (count($result) == 0) {
            throw new UserException('Invalid email.', 403);
        }

        if (!password_verify($password, $result['password'])) {
            throw new UserException('Invalid password.', 403);
        }

        return [
            'id' => $result['id'],
            'name' => $result['name'],
            'role' => $result['role']
        ];
    }
}