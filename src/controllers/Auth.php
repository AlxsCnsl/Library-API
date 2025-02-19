<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\UserModel;
use App\Utils\Route;
use App\Utils\HttpException;
use Firebase\JWT\JWT;

class Auth extends Controller {
  protected object $user;

  public function __construct($param) {
    $this->user = new UserModel();
    parent::__construct($param);
  }

  #[Route("POST", "/login")]
  public function login() {
    $data = $this->body;
    $user = $this->user->getByEmail($data['email']);

    if (!$user || !password_verify($data['password'], $user['password'])) {
      throw new HttpException("Invalid credentials", 401);
    }

    $token = JWT::encode(['user_id' => $user['id']], 'your_secret_key', 'HS256');
    return ['token' => $token];
  }
}
