@extends('layouts.adminapp')

@section('content')
<h1>USER MANAGEMENT PANEL</h1>

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

 <div class="container">
   <div class="row">
     <div class="col-sm-6">
       <div style="border:solid;">
         <form action="{{url('/upload')}}" method="post" enctype="multipart/form-data">
           {{csrf_field()}}
           <br>
           <input type="file" name="upload-file">
           <br>
             <p>
               <input type="submit" value="Import CSV">
             </p>
         </form>

         <form action="{{url('/download')}}" method="get">
           <input type="submit" value="Export CSV">
         </form>
       </div>
     </div>
     <div class="col-sm-6">
       <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#add">Add User</button>
       <div id="add" class="modal fade" role="dialog">
         <div class="modal-dialog">
           <div class="modal-content">
             <div class='modal-body'>
               {!! Form::open(
                  array(
                  'route' => 'adminusermanagement.store',
                  'class' => 'form')
                  ) !!}
              {{ csrf_field() }}
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h3>Create New User</h3>
              <br>
              <div class="form-group">
                  {!! Form::label('Role:') !!}
                  {!! Form::select('role', ['admin' => 'Admin', 'professor' => 'Professor','student' => 'Student'],
                    array(
                      'class'=>'form-control',
                      'placeholder'=>'Role'
                    )) !!}
              </div>
              <div class="form-group">
                <label for="user_no">User Number:</label>
                <input name="user_no" type="text" class="form-control" value = "{{$studno}}" required placeholder="Enter user number">
              </div>
              <div class="form-group">
                <label for="password">Password:</label>
                <input name="password" type="password" class="form-control" required >
              </div>
              <div class="form-group">
                <label for="firstname">Firstname:</label>
                <input name="firstname" type="text" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="lastname">Lastname:</label>
                <input name="lastname" type="text" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="middlename">Middlename:</label>
                <input name="middlename" type="text" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="email">Email:</label>
                <input name="email" type="email" class="form-control" required placeholder="Enter a valid email address">
              </div>
              <div class="form-group">
                  {!! Form::submit('Create User!',
                    array('class'=>'btn btn-primary'
                  )) !!}
              </div>
              {!! Form::close() !!}
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
 </div>
 <h2>USERS LISTS</h2>
 <table class="table">
   <thead>
     <th>id</th>
     <th>User Number</th>
     <th>Firstname</th>
     <th>Lastname</th>
     <th>Middlename</th>
     <th>email</th>
     <th>status</th>
   </thead>
   <tbody>
   @foreach($userslist as $user)
     <tr>
       <td>{{ $user->id }}</td>
       <td>{{ $user->user_no }}</td>
       <td>{{ $user->firstname }}</td>
       <td>{{ $user->lastname }}</td>
       <td>{{ $user->middlename }}</td>
       <td>{{ $user->email }}</td>
       <td>{{ $user->status }}</td>

      <td><a class="btn btn-info" data-toggle="modal" data-target="#edit-{{$user->id}}">Edit</a>
         <div id="edit-{{$user->id}}" class="modal fade" role="dialog">
           <div class="modal-dialog">
             <div class="modal-content">
               <div class='modal-body'>
                 <form action="{{ route('adminusermanagement.update',['id'=>$user->id]) }}" method="post">
                   {{ csrf_field() }}
                   <input type="hidden" name="_method" value="PUT">
                   <div class="form-group">
                       {!! Form::label('Role:') !!}
                       {!! Form::select('role', ['admin' => 'Admin', 'professor' => 'Professor','student' => 'Student'],
                         array(
                           'class'=>'form-control',
                           'placeholder'=>'Role'
                         )) !!}
                   </div>
                   <div class="form-group">
                     <label for="user_no">User Number:</label>
                     <input name="user_no" type="text" class="form-control" value="{{ $user->user_no }}">
                   </div>
                   <div class="form-group">
                     <label for="password">Password:</label>
                     <input name="password" type="password" class="form-control" value="{{ $user->password }}">
                   </div>
                   <div class="form-group">
                     <label for="firstname">Firstname:</label>
                     <input name="firstname" type="text" class="form-control" value="{{ $user->firstname }}">
                   </div>
                   <div class="form-group">
                     <label for="lastname">Lastname:</label>
                     <input name="lastname" type="text" class="form-control" value="{{ $user->lastname }}">
                   </div>
                   <div class="form-group">
                     <label for="middlename">Middlename:</label>
                     <input name="middlename" type="text" class="form-control" value="{{ $user->middlename }}">
                   </div>
                   <div class="form-group">
                     <label for="email">Email:</label>
                     <input name="email" type="text" class="form-control" value="{{ $user->email }}">
                   </div>
                   <input type="hidden" name="editForm" value="editForm">
                     <button type="submit" class="btn btn-primary">Submit</button>
                     <a class="btn btn-default pull-right" href="{{ route('adminusermanagement.index') }}">Go Back</a>
                 </form>
               </div>
             </div>
           </div>
         </div>
       </td>
       <td>
         <form action="{{ url('deactivateuser',[$user->id]) }}" method="POST">
           {{ csrf_field() }}
           <button type="submit" class ="btn btn-default" id="announce-deactivate" onclick='return confirm("Are you sure want to delete user?");'>
             <span class="glyphicon glyphicon-remove" aria-hidden="true" id ="announce-remove"></span>
           </button>
         </form>
       </td>
       </tr>
   @endforeach
   </tbody>
 </table>

@endsection
