@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row" id="quizview-row1">
      @foreach($exams as $exam)
      <p>Exam Name:<strong>{{$exam->name}}</strong></p>
      <p>Points: <strong>{{$exam->total_points}}</strong></p>
      <p>Type: <strong>{{$exam->type}}</strong></p>
      @endforeach
      <p>No. of Questions:<strong>{{$questions->count()}}</strong></p>
    </div>
    <div class="row" id ="quizview-row2">
      <div class="col-sm-12" id ="quizview-row2-col1">
        <form action="{{ route('quiz.store') }}" method="post">
          {{ csrf_field() }}
          @foreach($questions as $index => $question)
          @foreach($exams as $exam)
          <input type="hidden" name="exam_id" value="{{$exam->id}}">
          @endforeach
          <input type="hidden" name="student_no" value="{{Auth::user()->user_no}}">
          <input type="hidden" name="score" value="{{$question->points}}">
          <div class="panel-group">
            <div class="panel panel-default">
              <div class="panel-heading"><h4>No.{{$index+1}}. <strong>{{ $question->question }}</strong> ({{ $question->points }} points)</h4></div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-sm-4">
                    <input type = "radio" name="answer[{{$question->id}}]" value = "{{$question->choice1}}"><h4>A: {{$question->choice1}}</h4></input>
                    <input type = "radio" name="answer[{{$question->id}}]" value = "{{$question->choice2}}"><h4>B: {{$question->choice2}}</h4></input>
                  </div>
                  <div class="col-sm-4">
                    <input type = "radio" name="answer[{{$question->id}}]" value = "{{$question->choice3}}"><h4>C: {{$question->choice3}}</h4></input>
                    <input type = "radio" name="answer[{{$question->id}}]" value = "{{$question->choice4}}"><h4>D: {{$question->choice4}}</h4></input>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
            <button type="submit" class ="btn btn-default" onclick='return confirm("Are you sure you want to submit answers?");'>
              SUBMIT
            </button>
          </form>
      </div>
    </div>
  </div>
@endsection
