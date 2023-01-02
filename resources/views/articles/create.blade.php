@extends('layouts.layout')
@section('content')

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
            <li>
            {{$error}} 
            </li>
        @endforeach 
    </ul>
</div>
@endif

<form action="store" method="POST">
    @csrf
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Дата</label>
        <input type="date" class="form-control" id="exampleInputEmail1" name="date" aria-describedby="emailHelp">
   </div>
   <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Заголовок</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="title" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Аннотация</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="annotation" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Описание</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="description">
  </div>
  <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
@endsection