@extends('layouts.adminapp')


@section('content')
<h1>SUBJECT MANAGEMENT PANEL</h1>

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
<div style="border:solid;">
  <form action="{{url('/uploads')}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <br>
    <input type="file" name="upload-file">
    <br>
      <p>
        <input type="submit" value="Import CSV">
      </p>
  </form>

  <form action="{{url('/downloads')}}" method="get">
    <input type="submit" value="Export CSV">
  </form>
</div>

<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#addsubject">ADD SUBJECT</button>
                  <div class="modal fade" id="addsubject" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-body">
                          <form action="{{ route('adminsubjectmanagement.store') }}" method="post">
                            {{ csrf_field() }}
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <div class="form-group">
                                <label for="name">Subject Name:</label>
                                <input name="name" type="text" class="form-control">
                              </div>
                              <div class="form-group">
                                <label for="description">Subject Description:</label>
                                <input name="description" type="text" class="form-control">
                              </div>
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <h2>SUBJECTS LISTS</h2>
                  <table class="table">
                    <thead>
                      <th>SUBJECT NAME</th>
                      <th>SUBJECT DESCRIPTION</th>
                      <th>ACTION</th>
                    </thead>
                    <tbody>
                    @foreach($subjects as $subject)
                    <tr>
                      <td>{{ $subject->name }}</td>
                      <td>{{ $subject->description }}</td>
                      <td><a class="btn btn-info" data-toggle="modal" data-target="#edit">Edit</a>
                         <div id="edit" class="modal fade" role="dialog">
                           <div class="modal-dialog">
                             <div class="modal-content">
                               <div class='modal-body'>
                                 <form action="{{ route('adminsubjectmanagement.update',['id'=>$subject->id]) }}" method="post">
                                   {{ csrf_field() }}
                                   <input type="hidden" name="_method" value="PUT">

                                   <div class="form-group">
                                     <label for="name">Name:</label>
                                     <input name="name" type="text" class="form-control" value="{{ $subject->name }}">
                                   </div>
                                   <div class="form-group">
                                     <label for="description">Description:</label>
                                     <input name="description" type="text" class="form-control" value="{{ $subject->description }}">
                                   </div>
                                   <input type="hidden" name="editForm" value="editForm">
                                     <button type="submit" class="btn btn-primary">Submit</button>
                                     <a class="btn btn-default pull-right" href="{{ route('adminsubjectmanagement.index') }}">Go Back</a>
                                 </form>
                               </div>
                             </div>
                           </div>
                         </div>
                       </td>
                       <td>
                         <form action="{{ route('adminsubjectmanagement.destroy', ['id'=>$subject->id]) }}" method="POST">
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
