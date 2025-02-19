<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\BorrowModel;
use App\Utils\Route;
use App\Utils\HttpException;

class Borrow extends Controller {
  protected object $borrow;

  public function __construct($param) {
    $this->borrow = new BorrowModel();
    parent::__construct($param);
  }

  #[Route("POST", "/borrows")]
  public function addBorrow() {
    $this->borrow->add($this->body);
    return $this->borrow->getLast();
  }

  #[Route("DELETE", "/borrows/:id")]
  public function deleteBorrow() {
    return $this->borrow->delete(intval($this->params['id']));
  }

  #[Route("GET", "/borrows/:id")]
  public function getBorrow() {
    return $this->borrow->get(intval($this->params['id']));
  }

  #[Route("GET", "/borrows")]
  public function getBorrows() {
    $limit = isset($this->params['limit']) ? intval($this->params['limit']) : null;
    return $this->borrow->getAll($limit);
  }

  #[Route("PATCH", "/borrows/:id")]
  public function updateBorrow() {
    try {
      $id = intval($this->params['id']);
      $data = $this->body;

      if (empty($data)) {
        throw new HttpException("Missing parameters for the update.", 400);
      }

      $missingFields = array_diff($this->borrow->authorized_fields_to_update, array_keys($data));
      if (!empty($missingFields)) {
        throw new HttpException("Missing fields: " . implode(", ", $missingFields), 400);
      }

      $this->borrow->update($data, $id);
      return $this->borrow->get($id);
    } catch (HttpException $e) {
      throw $e;
    }
  }
}
