<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\UserModel;
use App\Utils\Route;
use App\Utils\HttpException;

class User extends Controller {
  protected object $user;

  public function __construct($param) {
    $this->user = new UserModel();
    parent::__construct($param);
  }

  #[Route("POST", "/users")]
  public function addUser() {
    // Hash the password before storing it
    $this->body['password'] = password_hash($this->body['password'], PASSWORD_DEFAULT);
    $this->user->add($this->body);
    return $this->user->getLast();
  }

  #[Route("DELETE", "/users/:id")]
  public function deleteUser() {
    return $this->user->delete(intval($this->params['id']));
  }

  #[Route("GET", "/users/:id")]
  public function getUser() {
    return $this->user->get(intval($this->params['id']));
  }

  #[Route("GET", "/users")]
  public function getUsers() {
    $limit = isset($this->params['limit']) ? intval($this->params['limit']) : null;
    return $this->user->getAll($limit);
  }

  #[Route("PATCH", "/users/:id")]
  public function updateUser() {
    try {
      $id = intval($this->params['id']);
      $data = $this->body;

      if (empty($data)) {
        throw new HttpException("Missing parameters for the update.", 400);
      }

      // Check for missing fields
      $missingFields = array_diff($this->user->authorized_fields_to_update, array_keys($data));
      if (!empty($missingFields)) {
        throw new HttpException("Missing fields: " . implode(", ", $missingFields), 400);
      }

      // Hash the password if it's being updated
      if (isset($data['password'])) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
      }

      $this->user->update($data, $id);
      return $this->user->get($id);
    } catch (HttpException $e) {
      throw $e;
    }
  }
}
