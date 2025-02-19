<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\AuthorModel;
use App\Utils\Route;
use App\Utils\HttpException;

class Author extends Controller {
  protected object $author;

  public function __construct($param) {
    $this->author = new AuthorModel();
    parent::__construct($param);
  }

  #[Route("POST", "/authors")]
  public function addAuthor() {
    $this->author->add($this->body);
    return $this->author->getLast();
  }

  #[Route("DELETE", "/authors/:id")]
  public function deleteAuthor() {
    return $this->author->delete(intval($this->params['id']));
  }

  #[Route("GET", "/authors/:id")]
  public function getAuthor() {
    return $this->author->get(intval($this->params['id']));
  }

  #[Route("GET", "/authors")]
  public function getAuthors() {
    $limit = isset($this->params['limit']) ? intval($this->params['limit']) : null;
    return $this->author->getAll($limit);
  }

  #[Route("PATCH", "/authors/:id")]
  public function updateAuthor() {
    try {
      $id = intval($this->params['id']);
      $data = $this->body;

      if (empty($data)) {
        throw new HttpException("Missing parameters for the update.", 400);
      }

      $missingFields = array_diff($this->author->authorized_fields_to_update, array_keys($data));
      if (!empty($missingFields)) {
        throw new HttpException("Missing fields: " . implode(", ", $missingFields), 400);
      }

      $this->author->update($data, $id);
      return $this->author->get($id);
    } catch (HttpException $e) {
      throw $e;
    }
  }
}
