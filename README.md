# PHP API Library:

## prerequis:

-nginx
-php-fpm 

### base de doné à crée : 
 dbName : library

table : users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


 table : authors
 CREATE TABLE IF NOT EXISTS authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

table :books
CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author_id INT,
    published_year YEAR,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES authors(id)
);


table : borrows
CREATE TABLE IF NOT EXISTS borrows (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    book_id INT,
    borrow_date DATE NOT NULL,
    return_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
);

## endpoints :
Endpoints
Books
POST /books: Add a new book.
GET /books: Get all books.
GET /books/:id: Get a book by ID.
PATCH /books/:id: Update a book.
DELETE /books/:id: Delete a book.
Authors
POST /authors: Add a new author.
GET /authors: Get all authors.
GET /authors/:id: Get an author by ID.
PATCH /authors/:id: Update an author.
DELETE /authors/:id: Delete an author.
Users
POST /users: Add a new user.
GET /users: Get all users.
GET /users/:id: Get a user by ID.
PATCH /users/:id: Update a user.
DELETE /users/:id: Delete a user.
Borrowings
POST /borrows: Add a new borrowing.
GET /borrows: Get all borrowings.
GET /borrows/:id: Get a borrowing by ID.
PATCH /borrows/:id: Update a borrowing.
DELETE /borrows/:id: Delete a borrowing.
