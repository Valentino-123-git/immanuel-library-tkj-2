<?php
require_once __DIR__ . "/../config/database.php";

function countBooks($search, $categoryId)
{
  global $pdo;

  $query = "select count(id) from books
            where title like :search
            and (:category_filter = '' or category_id = :category_id)
           ";
  $stmt = $pdo->prepare($query);
  $stmt->execute([
    'search' => "%$search%",
    'category_filter' => $categoryId,
    'category_id' => $categoryId
  ]);

  return $stmt->fetchColumn();
}

function getBooks($search, $categoryId, $page, $perPage)
{
  global $pdo;

  $query = "select b.id, b.title, b.stock, c.name as category from books b
            left join categories c on b.category_id = c.id
            where b.title like :search
            and (:category_filter = '' or b.category_id = :category_id)
            order by b.id desc
            limit :limit offset :offset
           ";
  $stmt = $pdo->prepare($query);
  $stmt->execute([
    'search' => "%$search%",
    'category_filter' => $categoryId,
    'category_id' => $categoryId,
    'limit' => $perPage,
    'offset' => ($page - 1) * $perPage
  ]);

  $books = $stmt->fetchAll();

  // Ambil penulis hanya untuk buku yang tampil di halaman ini.
  $bookByAuthors = [];
  if (!empty($books)) {
    $bookIds = array_column($books, 'id');
    $placeholders = implode(',', array_fill(0, count($bookIds), '?'));

    $query = "select ba.book_id, a.name from book_author ba
              left join authors a on ba.author_id = a.id
              where ba.book_id in ($placeholders)
             ";
    $stmt = $pdo->prepare($query);
    $stmt->execute($bookIds);

    foreach ($stmt->fetchAll() as $bookAuthor) {
      $bookByAuthors[$bookAuthor['book_id']][] = $bookAuthor['name'];
    }
  }

  foreach ($books as $index => $book) {
    $books[$index]['authors'] = $bookByAuthors[$book['id']] ?? [];
  }

  return $books;
}

function getBook($id)
{
  global $pdo;

  $query = "select id, title, isbn, year, stock, category_id, description from books where id = :id";
  $stmt = $pdo->prepare($query);
  $stmt->execute([
    'id' => $id
  ]);

  $book = $stmt->fetch();

  if (!$book) {
    header("Location: ../books/index.php");
    exit;
  }

  $query = "select a.id from book_author ba
            left join authors a on ba.author_id = a.id
            where ba.book_id = :book_id
           ";
  $stmt = $pdo->prepare($query);
  $stmt->execute([
    'book_id' => $book['id']
  ]);

  $authorIds = $stmt->fetchAll();

  $book['author_ids'] = array_column($authorIds, 'id');

  return $book;
}

function isIsbnTaken($isbn, $ignoreBookId)
{
  global $pdo;

  $bookId = intval($ignoreBookId);

  $query = "select count(id) from books where isbn = :isbn and id != :book_id";

  $stmt = $pdo->prepare($query);
  $stmt->execute([
    'isbn' => $isbn,
    'book_id' => $bookId
  ]);

  $isIsbnTaken = $stmt->fetchColumn() > 0;

  return $isIsbnTaken;
}