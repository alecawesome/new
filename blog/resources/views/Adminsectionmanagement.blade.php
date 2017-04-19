@extends('layouts.adminapp')

@section('content')
<h1>SECTION MANAGEMENT PANEL</h1>
<div style="border:solid;">
  <form action="{{url('/uploadse')}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <br>
    <input type="file" name="upload-file">
    <br>
      <p>
        <input type="submit" value="Import CSV">
      </p>
  </form>

  <form action="{{url('/downloadse')}}" method="get">
    <input type="submit" value="Export CSV">
  </form>
</div>
@if ($errors->any())
  <div class="alert alert-danger">
    @foreach($errors->all() as $error)
      <p> {{$error}} </p>
    @endforeach
  </div>
@endif

@if(Session::has('flash_messsage'))
  <div class="alert alert-success">
    {{Session::get('flash_messsage')}}
  </div>
@endif

<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#addsection">ADD SECTION</button>
                  <div class="modal fade" id="addsection" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-body">
                          <form action="{{ route('adminsectionmanagement.store') }}" method="post">
                            {{ csrf_field() }}
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <div class="form-group">
                                <label for="name">Section Name:</label>
                                <input name="name" type="text" class="form-control" required>
                              </div>
                              <div class="form-group">
                                <label for="description">Section Description:</label>
                                <input name="description" type="text" class="form-control" required>
                              </div>
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        </div>
                      </div>
                    </div>
                  </div>
<h2>SECTIONS LISTS</h2>

<table class="table">
  <thead>
    <th>SECTION NAME</th>
    <th>SECTION DESCRIPTION</th>
  </thead>
  <tbody>
@foreach($sections as $section)
  <tr>
    <td>{{$section->name}}</td>
    <td>{{$section->description}}</td>
    <td><a class="btn btn-info" data-toggle="modal" data-target="#edit">Edit</a>
       <div id="edit" class="modal fade" role="dialog">
         <div class="modal-dialog">
           <div class="modal-content">
             <div class='modal-body'>
               <form action="{{ route('adminsectionmanagement.update',['id'=>$section->id]) }}" method="post">
                 {{ csrf_field() }}
                 <input type="hidden" name="_method" value="PUT">

                 <div class="form-group">
                   <label for="name">Name:</label>
                   <input name="name" type="text" class="form-control" value="{{ $section->name }}">
                 </div>
                 <div class="form-group">
                   <label for="description">Description:</label>
                   <input name="description" type="text" class="form-control" value="{{ $section->description }}">
                 </div>
                 <input type="hidden" name="editForm" value="editForm">
                   <button type="submit" class="btn btn-primary">Submit</button>
                   <a class="btn btn-default pull-right" href="{{ route('adminsectionmanagement.index') }}">Go Back</a>
               </form>
             </div>
           </div>
         </div>
       </div>
     </td>
     <td>
       <form action="{{ route('adminsectionmanagement.destroy', ['id'=>$section->id]) }}" method="POST">
         {{ csrf_field() }}
         <input type="hidden" name="_method" value="DELETE">
         <input type="submit" value='Delete' class="btn btn-danger">
       </form>
     </td>
  </tr>
@endforeach
</tbody>
</table>
@endsection
