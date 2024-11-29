@extends('layouts.app')

@section('content')

    <div class="container" style=" background:#fff;border-radius:5px;box-shadow:0 .5rem 1.5rem rgba(0,0,0, .1);">

        <h3 align="center" class="mt-5">Update data</h3>
                <form method="POST" action="{{ route('recruitment.update', $recruitment->id) }}">
                {!! csrf_field() !!}
                  @method("PATCH")
                  <div class="form-group">
                    <div class="row ">
                            <label  class="col-3" >Last name:</label>
                            <div class="col-9">
                            <input type="text" class="form-control shadow-none" name="last_name"  value="{{ $recruitment->last_name }}"id="" autofocus required>
                        </div>
                        </div>
                        </div><br>
                    <div class="form-group">
                    <div class="row ">
                            <label  class="col-3" >First name(s):</label>
                            <div class="col-9">
                            <input type="text" class="form-control shadow-none" name="first_name"value="{{ $recruitment->first_name }}" id="" autofocus required>
                        </div>
                        </div>
                        </div><br>
                    
                    <div class="form-group">
                    <div class="row ">
                            <label  class="col-3" >Email:</label>
                            <div class="col-9">
                            <input type="email" class="form-control shadow-none" name="email" value="{{ $recruitment->email }}" id="" autofocus required>
                        </div>
                        </div>
                        </div><br>
                       
                        <div class="form-group">
                    <div class="row ">
                            <label  class="col-3" >Degree:</label>
                            <div class="col-9">
                            <input type="text" class="form-control shadow-none" name="degree" value="{{ $recruitment->degree }}"id="" autofocus required>
                        </div>
                        </div>
                        </div><br>
                        
                        <div class="form-group">
                    <div class="row ">
                      <div class="col-3">
                    <a href="/recruitment">
                            <p class="btn btn-danger"><i class="fa fa-arrow-left"> Cancel</i></p>
                        </a>
                        </div>
                       
                        <div class="col-9">
                           <button type="submit" class="btn btn-success" name="send"><i class="fa fa-floppy-o"> update</i></button>
                           
                    </div>
                        </div>
                        </div><br>
                    
                </form>
    </div>

@endsection


@push('css')
    <style>
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