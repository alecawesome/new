@extends('layouts.adminapp')


@section('content')
<h1>SUBJECT ASSIGNEMENT PANEL</h1>
<div style="border:solid;">
  <form action="{{url('/uploadc')}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <br>
    <input type="file" name="upload-file">
    <br>
      <p>
        <input type="submit" value="Import CSV">
      </p>
  </form>

  <form action="{{url('/downloadc')}}" method="get">
    <input type="submit" value="Export CSV">
  </form>
</div>

{!! Form::open(
   array(
   'route' => 'admincoursemanagement.store',
   'class' => 'form')
   ) !!}
<div class="row">
  <div class="col-sm-4">
    <div class="form-group">
      <label for="subject_name">Subject List:</label>
      <select name="subject_name"class="form-control">
        @foreach($subjects as $subject)
          <option value="{{$subject->name}}">{{$subject->name}}-{{$subject->description}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="form-group">
      <label for="section_name">Section List:</label>
      <select name="section_name"class="form-control">
        @foreach($sections as $section)
          <option value="{{$section->name}}">{{$section->name}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="form-group">
      <label for="professor_no">Professsor:</label>
      <select name="professor_no"class="form-control">
        @foreach($professors as $professor)
          <option value="{{$professor->user_no}}">{{$professor->user_no}}-{{$professor->firstname}}</option>
        @endforeach
      </select>
    </div>
  </div>
</div>
<div class="form-group">
   {!! Form::submit('Assign Course',
     array('class'=>'btn btn-primary'
   )) !!}
</div>
{!! Form::close() !!}

<table class="table">
  <thead>
    <th>ID</th>
    <th>SUBJECT NAME</th>
    <th>SECTION NAME</th>
    <th>PROFESSOR NO</th>
  </thead>
  <tbody>
  @foreach($courses as $course)
  <tr>
    <td>{{$course->id}}</td>
    <td>{{$course->subject_name}}</td>
    <td>{{$course->section_name}}</td>
    <td>{{$course->professor_no}}</td>
  </tr>
  @endforeach
</tbody>
</table>

@endsection
