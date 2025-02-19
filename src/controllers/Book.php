<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\BookModel;
use App\Utils\Route;
use App\Utils\HttpException;

class Book extends Controller {
  protected object $book;

  public function __construct($param) {
    $this->book = new BookModel();
    parent::__construct($param);
  }

  #[Route("POST", "/books")]
  public function addBook() {
    $this->book->add($this->body);
    return $this->book->getLast();
  }

  #[Route("DELETE", "/books/:id")]
  public function deleteBook() {
    return $this->book->delete(intval($this->params['id']));
  }

  #[Route("GET", "/books/:id")]
  public function getBook() {
    return $this->book->get(intval($this->params['id']));
  }

  #[Route("GET", "/books")]
  public function getBooks() {
    $limit = isset($this->params['limit']) ? intval($this->params['limit']) : null;
    return $this->book->getAll($limit);
  }

  #[Route("PATCH", "/books/:id")]
  public function updateBook() {
    try {
      $id = intval($this->params['id']);
      $data = $this->body;

      if (empty($data)) {
        throw new HttpException("Missing parameters for the update.", 400);
      }

      $missingFields = array_diff($this->book->authorized_fields_to_update, array_keys($data));
      if (!empty($missingFields)) {
        throw new HttpException("Missing fields: " . implode(", ", $missingFields), 400);
      }

      $this->book->update($data, $id);
      return $this->book->get($id);
    } catch (HttpException $e) {
      throw $e;
    }
  }
}
