@extends('layouts.app')

@section('content')
<div class="container">
   
    <div class="row pt-4">
        <h2>Login</h2>
<form id="login-form">
    <div class="row">
        <div class="col-6">
            <input class="form-control "type="email" id="email" name="email" placeholder="Email" required />
        </div>
        <div class="col-6 mb-3">
            <input class="form-control " type="password" id="password" name="password" placeholder="Password" required />
        </div>
        <div align="center">
        <button class="btn btn-primary "type="submit">Login</button>
    </div>
    </div>
   
</form>
</div>
</div>
<script>
    document.getElementById('login-form').addEventListener('submit', async function (e) {
        e.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        try {
            const response = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email, password }),
            });
            const data = await response.json();
            console.log(data);
            console.log(response)

            if (response.ok) {
                localStorage.setItem('auth_token', data.access_token);
                alert('Login successful!');
                if (data.type === 'Author') {
                    const uri_dash = await fetch('/dashboard', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                        'Accept': 'application/json'
                    },
        });
                    if (uri_dash.ok) {
                        window.location.href = '/dashboard';
                    } else {
                        alert('Someting went wrong');
                    }

              
                } else{
                    const uri_dash = await fetch('/home', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${data.access_token}`,
                         'Accept': 'application/json'
                    },
                    
                });
                if (uri_dash.ok) {
                        window.location.href = '/dashboard';
                    } else {
                        alert('Someting went wrong');
                    }
                
                   
                }
            } else {
                alert(data.message || 'Login failed');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
</script>
