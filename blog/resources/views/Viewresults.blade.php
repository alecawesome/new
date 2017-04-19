@extends('layouts.dashapp')
@section('content')

<div class="container" id = "results-container">
  <div class="row" id="row1">
    <div class="col-sm-5">
      <div class="row" id="first-row1">
        <h4>QUIZ REPORT</h4>
      </div>
      <div class="row" id="first-row2">
        <p>TEST DETAILS</p>
        @foreach($exams as $exam)
        <h5>Name: <strong>{{$exam->name}}</strong></h5>
        <h5>Total Points: <strong>{{$exam->total_points}}</strong></h5>
        <h5>No. of Questions: <strong>{{$questions->count()}}</strong></h5>
        <h5>Type: <strong>{{$exam->type}}</strong></h5>
        @endforeach
      </div>
    </div>
    <div class="col-sm-7">
      <div class="row" id="first-row3">
        <div class="col-sm-4" id="first-row3-col1">
          <h4>Passed</h4>
          <p>{{$passed->count()}}</p>
        </div>
        <div class="col-sm-3" id="first-row3-col2">
          <h4>Failed</h4>
          <p>{{$failed->count()}}</p>
        </div>
        <div class="col-sm-5" id="first-row3-col3">
          <h4>Average Percentage</h4>
          <p>{{ number_format((float) $percentage, 2) }} %</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row" id = "row1">
    <div class="col-sm-12" id="total-grade">
      <table id="TotalGrade">
          <thead>
              <tr>
                  <th onclick="sortTable(1)">Student Number</th>
                  <th>Name</th>
                  <th>Score</th>
                  <th onclick="sortTable(0)">Percentage (%)</th>
                  <th>Rating</th>
              </tr>
          </thead>
          <tbody>
              @foreach($results as $results)
              <tr>
                  <td>{{$results->student_no}}</td>
                  <td>{{$results->lastname}}, {{$results->firstname}} {{$results->middlename}}.</td>
                  <td>{{$results->total}}</td>
                  <td>{{$results->percentage}}</td>
                  <td>{{$results->rating}}</td>
              </tr>
              @endforeach
          </tbody>
      </table>
    </div>
  </div>
  <div class="row" id = "row1">
    <div class="col-sm-6">
      <div class="row" id="third-row1">
        <h4>TOP 5 STUDENTS WITH HIGH PERCENTAGE</h4>
      </div>
      <div class="row" id="third-row2">
        @foreach($topresults as $tresults)
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="col-sm-6" id = "panel-col1">
              <strong><p>{{$tresults->student_no}}</p></strong>
              <p>{{$tresults->lastname}}, {{$tresults->firstname}} {{$tresults->middlename}}.</p>
            </div>
            <div class="col-sm-6" id = "panel-col2">
              <p>{{$tresults->percentage}} %</p>
            </div>
          </div>
        </div>
        @endforeach
    </div>
    </div>
    <div class="col-sm-6">
      <div class="row" id="third-row1">
        <h4>TOP 5 STUDENTS WITH LOW PERCENTAGE</h4>
      </div>
      <div class="row" id="third-row2">
        @foreach($bottomresults as $bresults)
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="col-sm-6" id = "panel-col1">
              <strong><p>{{$bresults->student_no}}</p></strong>
              <p>{{$bresults->lastname}}, {{$bresults->firstname}} {{$bresults->middlename}}.</p>
            </div>
            <div class="col-sm-6" id = "panel-col2">
              <p>{{$bresults->percentage}} %</p>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  <div class="row" id = "row1">
    <div id="container-percentage-tracker1">
    </div>
    <table id = "datatable1" style="display:none">
        <thead>
            <tr>
                <th></th>
                <th>Correct Count</th>
                <th>Incorrect Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questioncount as $index => $qc)
            <tr>
                <th>Question{{$index +1}}</th>
                <td>{{$qc->correct_count}}</td>
                <td>{{$qc->incorrect_count}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
  </div>
</div>
@endsection
