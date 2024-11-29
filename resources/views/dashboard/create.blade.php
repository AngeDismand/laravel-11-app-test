@extends('layouts.app')

@section('content')
<div class="container">
    <h2> Add book</h2>
<form id="bookForm" enctype="multipart/form-data">
  <div class="row pt-4">
  
    <div class="col-6 mb-3">
        <input type="text" class="form-control"name="title" placeholder="Title" required>

    </div>
    <div class="col-6  mb-3">
        <input type="text" class="form-control" name="author" placeholder="Author" required>

    </div>
    <div class="col-6  mb-3">
        <input type="file"class="form-control" name="pdf" id="pdf" accept="application/pdf" required>
    </div>
    <div class="col-6  mb-3">
        <label for="s3_upload">Upload to S3</label>
        <input type="checkbox" class="form-check-input" name="upload_to_s3" id="upload_to_s3">
    </div>
    <div class="" algin="center">
        <button type="submit" class="btn btn-primary">Create Book</button>
    </div>
   
</div>
</form>
</div>
<script>
    document.getElementById('bookForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);

        fetch('/api/books', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.book) {
                alert('Book created successfully!');
                window.location.href = '/dashboard/';
            }
        })
        .catch(error => console.log(error));
    });
</script>
