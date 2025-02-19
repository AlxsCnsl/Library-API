Table authors {
  id integer [primary key]
  first_name varchar
  last_name varchar
  created_at timestamp
}

Table books {
  id integer [primary key]
  title varchar
  author_id integer
  published_year year
  created_at timestamp
}

Table users {
  id integer [primary key]
  first_name varchar
  last_name varchar
  email varchar [unique]
  password varchar
  created_at timestamp
}

Table borrows {
  id integer [primary key]
  user_id integer
  book_id integer
  borrow_date date
  return_date date
  created_at timestamp
}

Ref: books.author_id > authors.id
Ref: borrows.user_id > users.id 
Ref: borrows.book_id > books.id 
