@extends('layouts.adminapp')


@section('content')
<h1>STUDENT MANAGEMENT PANEL</h1>
<div style="border:solid;">
  <form action="{{url('/uploadst')}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <br>
    <input type="file" name="upload-file">
    <br>
      <p>
        <input type="submit" value="Import CSV">
      </p>
  </form>

  <form action="{{url('/downloadst')}}" method="get">
    <input type="submit" value="Export CSV">
  </form>
</div>
{!! Form::open(
   array(
   'route' => 'adminstudentmanagement.store',
   'class' => 'form')
   ) !!}
<div class="row">
  <div class="col-sm-6">
    <div class="form-group">
      <label for="course_id">Courses:</label>
      <select name="course_id"class="form-control">
        @foreach($courses as $course)
          <option value="{{$course->id}}">{{$course->id}}-{{$course->subject_name}}-{{$course->section_name}}-{{$course->professor_no}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group">
      <label for="student_no">Student:</label>
      <select name="student_no"class="form-control">
        @foreach($students as $student)
          <option value="{{$student->user_no}}">{{$student->user_no}} {{$student->lastname}} {{$student->firstname}}, {{$student->middlename}}</option>
        @endforeach
      </select>
    </div>
  </div>
</div>
<div class="form-group">
   {!! Form::submit('Assign Student',
     array('class'=>'btn btn-primary'
   )) !!}
</div>
{!! Form::close() !!}

<table class="table">
  <thead>
    <th>ID</th>
    <th>COURSE ID</th>
    <th>STUDENT NO</th>
  </thead>
  <tbody>
  @foreach($assigned as $assigned)
  <tr>
    <td>{{$assigned->id}}</td>
    <td>{{$assigned->course_id}}</td>
    <td>{{$assigned->student_no}}</td>
  </tr>
  @endforeach
</tbody>
</table>

@endsection
