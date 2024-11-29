@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row pt-4">
<form id="registerForm">
    <div class="row">
<h2>Register</h2>
        <div class="col-6 mb-3">
            <input class="form-control "type="text" id="name" name="name" placeholder="Name" required />
        </div>
        <div class="col-6 mb-3">
            <input class="form-control "type="email" id="email" name="email" placeholder="Email" required />
        </div>
        <div class="col-6 mb-3">
            <input class="form-control " type="password" id="password" name="password" placeholder="Password" required />
        </div>
        <div class="col-6 mb-3">
            <select class="form-select" name="type" id="type" required>
                <option value="Author">Author</option>
                <option value="Parent">Parent</option>
            </select>
        </div>
        <div align="center">
        <button class="btn btn-primary "type="submit">Register</button>
    </div>
    </div>
   
</form>
</div>
</div>


<script>
    document.getElementById('registerForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const name = document.getElementById('name').value;
        const type = document.getElementById('type').value;
        console.log(email,password,type,name);
        
        const response = await fetch('/api/register', {
            method: 'POST',
            headers: {
                    'Content-Type': 'application/json',
                },
            body: JSON.stringify({ name,email, password,type }),
        });
        const result = await response.json();
        console.log(result);

        if (response.ok) {
            window.location.href = '/login';
           
        } else {
            alert(result.message || 'something went wrong');
        }
});

        
</script>
