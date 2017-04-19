 @extends('layouts.dashapp')

@section('content')
<div class="container" id="question-container">
  <div class="row" id="main-row-question">
    <div class="col-sm-4" id="qmain-row-col1">
      <h4>CHALLENGE YOUR STUDENTS..</h4>
      <h2>BUILD A QUIZ!</h2>
    </div>
    <div class="col-sm-7">
      <div class="row" id="qmain-row-col2">
        <div class="row" id="qcol2-content1">
          <p>TEST DETAILS</p>
        </div>
        <div class="row" id="qcol2-content2">
          @foreach($exams as $exam)
          <h5>Exam Name:<strong>{{$exam->name}}</strong></h5>
          <h5>Total Points: <strong>{{$exam->total_points}}</strong></h5>
          <h5>Current Points: <strong>{{$questionpoints->sum('points')}}</strong></h5>
          <h5>No. of Questions: <strong>{{$questions->count()}}</strong></h5>
          <h5>Type: <strong>{{$exam->type}}</strong></h5>
          @endforeach
        </div>
      </div>
    </div>
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
  <br>
  <div class="row" id="main-row1-question">
    <div class="col-sm-4">
      <button type="button" class="btn btn-default btn-md" data-toggle="modal" data-target="#addquestion" id="question-btn">ADD QUESTION</button>
       <div class="modal fade" id="addquestion" role="dialog">
         <div class="modal-dialog">
           <div class="modal-content">
             <div class="modal-body">
               <form action="{{ route('questionbuilder.store') }}" method="post">
                 {{ csrf_field() }}
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   @foreach($exams as $exam)
                   <input type="hidden" name="exam_id" value="{{$exam->id}}">
                   @endforeach
                   <div class="form-group">
                     <label for="question">Question:</label>
                     <textarea name="question" cols="10" rows="10" class="form-control"></textarea>
                   </div>
                   <div class="row">
                     <div class="col-sm-2">
                       <div class="form-group">
                         <label for="points">Points:</label>
                         <input name="points" type="text" class="form-control">
                       </div>
                     </div>
                     <div class="col-sm-3">
                       <div class="form-group">
                           {!! Form::label('Question Type:') !!}
                           <select name="question_type" id="selectMe">
                              <option value="mc">Multiple Choice</option>
                              <option value="tf">True or False</option>
                          </select>
                       </div>
                     </div>
                     <div class="col-sm-7">
                       <div class="form-group">
                         <label for="correct_answer">Correct Answer:</label>
                         <input name="correct_answer" type="text" class="form-control" required>
                       </div>
                     </div>
                   </div>
                   <div class="row" id="tf">
                     <div class="col-sm-6">
                       <div class="form-group">
                         <label for="choices">Choice A:</label>
                         <input name="choice1" type="text" class="form-control">
                       </div>
                     </div>
                     <div class="col-sm-6">
                       <div class="form-group">
                         <label for="choices">Choice B:</label>
                         <input name="choice2" type="text" class="form-control">
                       </div>
                     </div>
                   </div>
                   <div class="row" id="mc">
                     <div class="col-sm-6">
                       <div class="form-group">
                         <label for="choices">Choice C:</label>
                         <input name="choice3" type="text" class="form-control">
                       </div>
                     </div>
                     <div class="col-sm-6">
                       <div class="form-group">
                         <label for="choices">Choice D:</label>
                         <input name="choice4" type="text" class="form-control">
                       </div>
                     </div>
                   </div>
                   <input type="submit" value="Submit">
               </form>
             </div>
           </div>
         </div>
       </div>
    </div>
  </div>
  <br>
  <div class="row" id="main-row2-question">
    <div class="col-sm-4" id="qmain-row2-col1">
      <h4>LISTS OF QUESTIONS</h4>
    </div>
  </div>
  <div class="row" id="main-row3-question">
    <div class="col-sm-8" id ="qmain-row3-col1">
        @foreach($questions as $index => $question)
        <div class="panel-group">
          <div class="panel panel-default">
            @if($question->points == 1)
            <div class="panel-heading" id="panel-head">
                <p>{{$index+1}}. <strong>{{ $question->question }}</strong> ({{ $question->points }} point)</p>
                <button type="button" class ="btn btn-default panel-title pull-right" data-toggle="modal" data-target="#editquestion-{{$question->id}}" id="exam-edit">
                  <span class="glyphicon glyphicon-pencil" aria-hidden="true" id ="exam-pencil"></span>
                </button>
                <div id="editquestion-{{$question->id}}" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class='modal-body'>
                        <form action="{{ route('questionbuilder.update',['id'=>$question->id]) }}" method="post">
                          {{ csrf_field() }}
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <div class="form-group">
                              <label for="question">Question:</label>
                              <textarea name="question" cols="10" rows="10" class="form-control">{{$question->question}}</textarea>
                            </div>
                            <div class="row">
                              <div class="col-sm-2">
                                <div class="form-group">
                                  <label for="points">Points:</label>
                                  <input name="points" type="text" class="form-control" value ="{{$question->points}}">
                                </div>
                              </div>
                              <div class="col-sm-3">
                                <div class="form-group">
                                    {!! Form::label('Question Type:') !!}
                                    {!! Form::select('question_type', ['mc' => 'Multiple Choice', 'tf' => 'True or False'],
                                      array(
                                        'class'=>'form-control',
                                        'placeholder'=>'Question Type'
                                        )) !!}
                                </div>
                              </div>
                              <div class="col-sm-7">
                                <div class="form-group">
                                  <label for="correct_answer">Correct Answer:</label>
                                  <input name="correct_answer" type="text" class="form-control" required value ="{{$question->correct_answer}}">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="choices">Choice A:</label>
                                  <input name="choice1" type="text" class="form-control" value ="{{$question->choice1}}">
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="choices">Choice B:</label>
                                  <input name="choice2" type="text" class="form-control" value ="{{$question->choice2}}">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="choices">Choice C:</label>
                                  <input name="choice3" type="text" class="form-control" value ="{{$question->choice3}}">
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="choices">Choice D:</label>
                                  <input name="choice4" type="text" class="form-control" value ="{{$question->choice4}}">
                                </div>
                              </div>
                            </div>
                            <input type="submit" value="Submit">
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            @else
            <div class="panel-heading" id="panel-head">
              <p>{{$index+1}}.  <strong>{{ $question->question }}</strong> ({{ $question->points }} points)</p>
              <button type="button" class ="btn btn-default panel-title pull-right" data-toggle="modal" data-target="#editquestion-{{$question->id}}" id="exam-edit">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true" id ="exam-pencil"></span>
              </button>
              <div id="editquestion-{{$question->id}}" class="modal fade" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class='modal-body'>
                      <form action="{{ route('questionbuilder.update',['id'=>$question->id]) }}" method="post">
                        {{ csrf_field() }}
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <div class="form-group">
                            <label for="question">Question:</label>
                            <textarea name="question" cols="10" rows="10" class="form-control">{{$question->question}}</textarea>
                          </div>
                          <div class="row">
                            <div class="col-sm-2">
                              <div class="form-group">
                                <label for="points">Points:</label>
                                <input name="points" type="text" class="form-control" value ="{{$question->points}}">
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                  {!! Form::label('Question Type:') !!}
                                  {!! Form::select('question_type', ['mc' => 'Multiple Choice', 'tf' => 'True or False'],
                                    array(
                                      'class'=>'form-control',
                                      'placeholder'=>'Question Type'
                                      )) !!}
                              </div>
                            </div>
                            <div class="col-sm-7">
                              <div class="form-group">
                                <label for="correct_answer">Correct Answer:</label>
                                <input name="correct_answer" type="text" class="form-control" required value ="{{$question->correct_answer}}">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="choices">Choice A:</label>
                                <input name="choice1" type="text" class="form-control"value = "{{$question->choice1}}">
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="choices">Choice B:</label>
                                <input name="choice2" type="text" class="form-control" value ="{{$question->choice2}}">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="choices">Choice C:</label>
                                <input name="choice3" type="text" class="form-control" value ="{{$question->choice3}}">
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="choices">Choice D:</label>
                                <input name="choice4" type="text" class="form-control" value ="{{$question->choice4}}">
                              </div>
                            </div>
                          </div>
                          <input type="submit" value="Submit">
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif
            <div class="panel-body">
              <div class="row" id="panel-row">
                <div class="col-sm-4">
                  <h5>Choice A:</h5><h4><strong>{{$question->choice1}}</strong></h4>
                  <h5>Choice B:</h5><h4><strong>{{$question->choice2}}</strong></h4>
                </div>
                <div class="col-sm-4">
                  <h5>Choice C:</h5><h4><strong>{{$question->choice3}}</strong></h4>
                  <h5>Choice D:</h5><h4><strong>{{$question->choice4}}</strong></h4>
                </div>
                <div class="col-sm-4">
                  <h5>Correct Answer:</h5> <h4><strong>{{$question->correct_answer}}</strong></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
    </div>
  </div>
  @foreach($exams as $ex)
  <a href= "{{ url('/subjectview',[$ex->course_id]) }}" class="btn btn-default" id ="question-btn">BACK TO DASHBOARD
  </a>
  @endforeach
</div>

@endsection
