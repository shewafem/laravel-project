@extends('layouts.layout')
@section('content')
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Title</th>
      <th scope="col">Desc</th>
      <th scope="col">Image</th>
    </tr>
  </thead>
  <tbody>
    @foreach($results as $result)
    <tr>
      <th scope="row">{{$result['date']}}</th>
      <td>{{$result['name']}}</td>
      <td>{{$result['desc']}}</td>
      <td><a href="/galery/{{$result['full_image']}}"><img src="{{URL::asset($result['preview_image'])}}" alt="" height="100" width="100"></a></td>
    </tr>
    @endforeach

  </tbody>
</table>
@endsection