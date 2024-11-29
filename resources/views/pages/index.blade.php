@extends('layouts.app')

@section('content')

<nav class="navbar navbar-expand-lg navabar-ligth " style="background:#fff;color:black;" >
    <div class="logo">
    Ange<strong>Dev</strong>
    </div><pre>         

    </pre>
    
    <a class="navbar-brand" style="color:#00"href="index.php">List of candidats</a>
    
</nav>
<div class="row pt-4  m-auto">
    <p ><a href="/recruitment/add">
        <button class="btn btn-primary">Add</button>
    </a>
</p>
</div>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <table class="table mt-5">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone number</th>
                        <th scope="col">Degree</th>
                        <th scope="col">File name</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>

                        @foreach ( $cvs as $key => $recruitment )

                        <tr>
                            <td scope="col">{{ ++$key }}</td>
                            <td scope="col">{{ $recruitment->last_name }}</td>
                            <td scope="col">{{ $recruitment->first_name }}</td>
                            <td scope="col">{{ $recruitment->email }}</td>
                            <td scope="col">{{ $recruitment->phone_number }}</td>
                            <td scope="col">{{ $recruitment->degree }}</td>
                            <td scope="col">{{ $recruitment->file_name }}</td>
                            <td scope="col">

                            <a href="{{  route('recruitment.edit', $recruitment->id) }}">
                            <button class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                            </button>
                            </a>
                            
                            <form action="{{ route('recruitment.destroy', $recruitment->id) }}" method="POST" style ="display:inline">
                             @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            </td>

                          </tr>

                        @endforeach




                    </tbody>
                  </table>
            </div>
        </div>
    </div>

@endsection


@push('css')
    <style>
        nav{
    position: sticky;
    top: 0;
    z-index: 1000;
    overflow-x:hidden;
}
nav .logo
{
    float: left;
    
    font-size: 27px;
    font-weight: 600;
    line-height: 70px;
    padding-left: 60px;
    
    color:#fff;
    
    text-transform: uppercase;
    font-weight: 700;
    font-family: "Josfin Sans", sans-serif;
    background: linear-gradient(
        to right,
        #095fab 10%,
        #25abe8 50%,
        rgb(8, 212, 70) 60%
         
    
    );
    color: rgb(196, 252, 252);
    background-size:auto auto ;
    background-clip: border-box;
    background-size: 200% auto;
    color: #fff;
    background-clip: text;
    text-fill-color:transparent;
    -webkit-background-clip: text;
    -webkit-text-fill-color:transparent;
    animation: textclip 1.5s linear infinite;
    display: inline-block;
}

nav strong
{
    color: white;


}

    
   
    
  


@keyframes textclip{
    to{
        background-position: 200% center;
    }
}

@stack('css')
        .form-area{
            padding: 20px;
            margin-top: 20px;
            background-color:#b3e5fc;
        }

        .bi-trash-fill{
            color:red;
            font-size: 18px;
        }

        .bi-pencil{
            color:green;
            font-size: 18px;
            margin-left: 20px;
        }
    </style>
@endpush