@extends('layouts.app')

@section('content')


<div class="row pt-4  m-auto">
    <div class=" d-flex justify-content-start ">
        <a href="/dashboard/create">
            <button class="btn btn-primary">Add</button>
        </a>
    </div>
    
<div class="d-flex justify-content-end ">
    <a href="/logout">
        <button class="btn btn-danger">Log out</button>
    </a>
</div>
</div>

    <div class="container mt-">
        <table class="table mt-5">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Author</th>
                <th scope="col">Pdf</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody id="bookList">

            </tbody>
          </table>
    </div>
  
  <!-- Modal Bootstrap -->
  <div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editBookModalLabel">Update the book</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="editFormContainer">
          
        </div>
      </div>
    </div>
  </div>
  

<script>
         function deleteBook(bookId) {
            if (confirm('Are-you sure to delete this book ?')) {
                fetch(`/api/books/${bookId}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert('Book deleted');
                        document.getElementById(`book-${bookId}`).remove();
                    } else {
                        alert('something went wrong');
                    }
                })
                .catch(error => console.log(error));
            }
        }
        function editBook(bookId) {
            fetch(`/api/books/${bookId}`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const book = data.book;
                const editFormHtml = `
                    <form id="editBookForm">
                        <input type="hidden" name="book_id" value="${book.id}">
                        <input type="text" name="title" value="${book.title}" required class="form-control mb-2">
                        <input type="text" name="author" value="${book.author}" required class="form-control mb-2">                        
                        <button type="submit" class="btn btn-primary mt-3">Save</button>
                    </form>
                `;
                document.getElementById('editFormContainer').innerHTML = editFormHtml;

                document.getElementById('editBookForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const title = document.querySelector('[name="title"]').value;
                    const author = document.querySelector('[name="author"]').value;
                    const bookId = document.querySelector('[name="book_id"]').value;
                    const updatedBook = {
                    title: title,
                    author: author
                };
                    fetch(`/api/books/${bookId}`, {
                        method: 'PUT',
                        headers: {
                            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json' 
                        },
                        body: JSON.stringify(updatedBook)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data) {
                            console.log(data);
                            alert('The book has been updated');
                            loadBooks(); 
                            const modal = bootstrap.Modal.getInstance(document.getElementById('editBookModal'));
                            modal.hide();
                    
                            document.querySelector('.modal-backdrop').remove();
                            
                        } else {
                            alert('Something went wrong. Please try again');
                        }
                    })
                    .catch(error => console.log(error));
                });
            })
            .catch(error => console.log(error));
        }


        function loadBooks() {
            fetch('/api/books', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const books = data.books;
                let bookListHtml = '';
    
                books.forEach((book, index) => {
                    bookListHtml += `
                        <tr id="book-${book.id}">
                            <td>${index + 1}</td>
                            <td>${book.title}</td>
                            <td>${book.author}</td>
                            <td><a href="${book.pdf_path}" target="_blank">${book.pdf_path}</a></td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editBook(${book.id})" data-bs-toggle="modal" data-bs-target="#editBookModal" id="">Update</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteBook(${book.id})">Delete</button>
                            </td>
                        </tr>
                    `;
                });
    
                document.getElementById('bookList').innerHTML = bookListHtml;
            })
            .catch(error => console.log(error));
        }
    
        loadBooks();
       
    </script>

