@extends('layouts.dashapp')

@section('content')
@if ($errors->any())
  <div class="alert alert-danger">
    @foreach($errors->all() as $error)
      <p>{{$error}}</p>
    @endforeach
  </div>
@endif

@if(Session::has('flash_messsage'))
  <div class="alert alert-success">
    {{Session::get('flash_messsage')}}
  </div>
@endif
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-2 col-xs-6" id="course-name">
      @foreach($courses as $course)
        <h3>{{$course->subject_name}}-{{$course->description}}<h3>
      @endforeach
    </div>
  </div>
  <div class="row">
    <div class="col-sm-4" id="col-1">
      <div class="row" id = "announce-row">
        <div class="row" id="announcements-row1">
          <div class="col-sm-6">
            <p>ANNOUNCEMENTS</p>
          </div>
          <div class="col-sm-6">
            @if(Auth::User()->hasRole('professor'))
            <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#createannounce" id= "announce-add">
              <span class="glyphicon glyphicon-plus" aria-hidden="true" id ="announce-plus"></span>
            </button>
            <div id="createannounce" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class='modal-body'>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <form action="{{ route('announcement.store') }}" method="post">
                      {{ csrf_field() }}
                      <input type="hidden" name="course_id" value="{{$course->id}}">
                      <div class="form-group">
                        <label for="title">Title:</label>
                         <input name="title" type="text" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="content">Content:</label>
                        <textarea name="content" cols="30" rows="10" class="form-control"></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a class="btn btn-default pull-right" >Go Back</a>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
        <div class="row" id="announcements-row2">
          @if(Auth::User()->hasRole('professor'))
          @foreach($announcements as $announce)
          @if($announce->status == 'active'||$announce->status == 'inactive')
          <div class="row" id = "announcements-row2-content">
            <div class="col-sm-8" id="announcements-row2-content1">
              <p><strong>{{$announce->content}}</strong></p>
              <p>Status: <strong>{{$announce->status}}</strong></p>
              <p>Created at: <strong>{{$announce->created_at->month}}/{{$announce->created_at->month}}/{{$announce->created_at->year}}</strong></p>
            </div>
            <div class="col-sm-1" id="announcements-row2-content2">
              <form action="{{ url('changeannouncestatus',[$announce->id]) }}" method="POST">
                {{ csrf_field() }}
                <button type="submit" class ="btn btn-default" id="announce-status">
                  <span class="glyphicon glyphicon-upload" aria-hidden="true" id ="announce-upload"></span>
                </button>
              </form>
            </div>
            <div class="col-sm-1" id="announcements-row2-content3">
                <button type="button" class ="btn btn-default" data-toggle="modal" data-target="#editannounce-{{$announce->id}}" id="announce-edit">
                  <span class="glyphicon glyphicon-pencil" aria-hidden="true" id ="announce-pencil"></span>
                </button>
                <div id="editannounce-{{$announce->id}}" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class='modal-body'>
                           <form action="{{ route('announcement.update',['id'=>$announce->id]) }}" method="post">
                          {{ csrf_field() }}
                          <input type="hidden" name="_method" value="PUT">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <div class="form-group">
                            <label for="title">Title:</label>
                            <input name="title" type="text" class="form-control" value="{{ $announce->title }}">
                          </div>
                          <div class="form-group">
                            <label for="content">Content:</label>
                            <input name="content" type="text" class="form-control" value="{{ $announce->content }}">
                          </div>
                          <input type="hidden" name="editForm" value="editForm">
                          <button type="submit" class="btn btn-primary">EDIT</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-sm-1" id="announcements-row2-content4">
              <form action="{{ url('deactivateannounce',[$announce->id]) }}" method="POST">
                {{ csrf_field() }}
                <button type="submit" class ="btn btn-default" id="announce-deactivate" onclick='return confirm("Are you sure want to delete announcement?");'>
                  <span class="glyphicon glyphicon-remove" aria-hidden="true" id ="announce-remove"></span>
                </button>
              </form>
            </div>
          </div>
          @endif
          @endforeach
          @elseif(Auth::User()->hasRole('student'))
            @foreach($activeannounce as $activea)
            <div class="row" id = "announcements-row2-content">
              <div class="col-sm-8" id="announcements-row2-content1">
                <p><strong>{{$activea->content}}</strong></p>
              </div>
            </div>
            @endforeach
          @endif
        </div>
      </div>

      <div class="row" id = "module-row">
        <div class="row" id="modules-row1">
          <div class="col-sm-6">
            <p>MODULES</p>
          </div>
          <div class="col-sm-6">
            @if(Auth::User()->hasRole('professor'))
            <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#createmodule" id= "module-add">
              <span class="glyphicon glyphicon-plus" aria-hidden="true" id ="module-plus"></span>
            </button>
            <div id="createmodule" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class='modal-body'>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <form action="{{ route('module.store') }}" method="post" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <input type="hidden" name="course_id" value="{{$course->id}}">
                      </div>
                      <div class="form-group">
                        <input type="file" name="filefield">
                      </div>
                      <div class="form-group">
                        <input type="submit">
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
        <div class="row" id="modules-row2">
          @if(Auth::User()->hasRole('professor'))
          @foreach($modules as $module)
          @if($module->status == 'active')
          <div class="row" id="modules-row2-content">
            <div class="col-sm-9" id="modules-row2-content1">
              <p>{{$module->original_filename}}</p>
              <p>Created at: <strong>{{$module->created_at->month}}/{{$module->created_at->month}}/{{$module->created_at->year}}</strong></p>
              <p>Status<strong>{{$module->status}}</strong></p>
            </div>
            <div class="col-sm-1" id="modules-row2-content2">
              <form action="{{ url('getmodule', [$module->filename]) }}" method="get">
                {{ csrf_field() }}
                <button type="submit" class ="btn btn-default" id="module-download">
                  <span class="glyphicon glyphicon-save" aria-hidden="true" id ="module-save"></span>
                </button>
              </form>
            </div>
            <div class="col-sm-1" id="modules-row2-content3">
              <form action="{{ url('deactivatemodule',[$module->id]) }}" method="POST">
                {{ csrf_field() }}
                <button type="submit" class ="btn btn-default" id="module-deactivate" onclick='return confirm("Are you sure want to delete module?");'>
                  <span class="glyphicon glyphicon-remove" aria-hidden="true" id ="module-remove"></span>
                </button>
              </form>
            </div>
          </div>
          @endif
          @endforeach
          @elseif(Auth::User()->hasRole('student'))
            @foreach($activemodule as $mod)
            <div class="row" id="modules-row2-content">
              <div class="col-sm-9" id="modules-row2-content1">
                <p>{{$mod->original_filename}}</p>
                  <p>Created at: <strong>{{$mod->created_at->month}}/{{$mod->created_at->month}}/{{$mod->created_at->year}}</strong></p>
              </div>
              <div class="col-sm-1" id="modules-row2-content2">
                <form action="{{ url('getmodule', [$mod->filename]) }}" method="get">
                  {{ csrf_field() }}
                  <button type="submit" class ="btn btn-default" id="module-download">
                    <span class="glyphicon glyphicon-save" aria-hidden="true" id ="module-save"></span>
                  </button>
                </form>
              </div>
            </div>
            @endforeach
          @endif
        </div>
      </div>
      <div class="row" id = "exam-row">
        <div class="row" id="exams-row1">
          <div class="col-sm-6">
            <p>EXAMS</p>
          </div>
          <div class="col-sm-6">
            @if(Auth::User()->hasRole('professor'))
            <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#createexam" id= "exam-add">
              <span class="glyphicon glyphicon-plus" aria-hidden="true" id ="exam-plus"></span>
            </button>
            <div id="createexam" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class='modal-body'>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <form action="{{ route('exam.store') }}" method="post">
                      {{ csrf_field() }}
                      @foreach($courses as $course)
                      <input type="hidden" name="course_id" value="{{$course->id}}">
                      @endforeach
                      <div class="form-group">
                          {!! Form::label('Exam Type:') !!}
                          {!! Form::select('type', ['quiz' => 'Quiz', 'pe' => 'Preliminary Exam', 'fe' => 'Final Exam'],
                            array(
                              'class'=>'form-control',
                              'placeholder'=>'Question Type'
                              )) !!}
                      </div>
                      <div class="row">
                        <div class="col-sm-10">
                          <div class="form-group">
                            <label for="name">Name:</label>
                            <input name="name" type="text" class="form-control">
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="total_points">Points:</label>
                            <input name="total_points" type="text" class="form-control">
                          </div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
        <div class="row" id ="exams-row2">
          @if(Auth::User()->hasRole('professor'))
          @foreach($exams as $exam)
          @if($exam->status == 'active'||$exam->status == 'inactive')
          <div class="row" id = "exams-row2-content">
            <div class="col-sm-6" id="exams-row2-content1">
              <p><strong>{{$exam->name}}</strong></p>
              @if($exam->type == 'quiz')
              <p><strong>Quiz- {{$exam->total_points}} points</strong></p>
              @elseif($exam->type == 'pe')
              <p><strong>Prelim Exam- {{$exam->total_points}} points</strong></p>
              @elseif($exam->type == 'fe')
              <p><strong>Final Exam- {{$exam->total_points}} points</strong></p>
              @endif
              <p>Status: <strong>{{$exam->status}}</strong></p>
              <p>Created at: <strong>{{$exam->created_at->month}}/{{$exam->created_at->month}}/{{$exam->created_at->year}}</strong></p>
            </div>
            <div class="col-sm-2">
              <a href= "{{ url('/questionbuilder',[$exam->id]) }}" class="btn btn-default" id = "exam-question">
              <span class="glyphicon glyphicon-th-list" aria-hidden="true" id ="exam-list"></span></a>
            </div>
            <div class="col-sm-2">
              <a href= "{{ url('/viewresults',[$exam->id]) }}" class="btn btn-default" id = "exam-question">
              <span class="glyphicon glyphicon-th-list" aria-hidden="true" id ="exam-list"></span></a>
            </div>
            <div class="col-sm-1" id="exams-row2-content2">
              <form action="{{ url('changeexamstatus',[$exam->id]) }}" method="POST">
                {{ csrf_field() }}
                <button type="submit" class ="btn btn-default" id="exam-status">
                  <span class="glyphicon glyphicon-upload" aria-hidden="true" id ="exam-upload"></span>
                </button>
              </form>
            </div>
            <div class="col-sm-1" id="exams-row2-content3">
                <button type="button" class ="btn btn-default" data-toggle="modal" data-target="#editexam-{{$exam->id}}" id="exam-edit">
                  <span class="glyphicon glyphicon-pencil" aria-hidden="true" id ="exam-pencil"></span>
                </button>
                <div id="editexam-{{$exam->id}}" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class='modal-body'>
                        <form action="{{ route('exam.update',['id'=>$exam->id]) }}" method="post">
                          {{ csrf_field() }}
                          <input type="hidden" name="_method" value="PUT">
                          <div class="form-group">
                              {!! Form::label('Exam Type:') !!}
                              {!! Form::select('type', ['quiz' => 'Quiz', 'pe' => 'Preliminary Exam', 'fe' => 'Final Exam'],
                                array(
                                  'class'=>'form-control',
                                  'placeholder'=>'Question Type'
                                  )) !!}
                          </div>
                          <div class="row">
                            <div class="col-sm-10">
                              <div class="form-group">
                                <label for="name">Name:</label>
                                <input name="name" type="text" class="form-control" value="{{$exam->name}}">
                              </div>
                            </div>
                            <div class="col-sm-2">
                              <div class="form-group">
                                <label for="total_points">Points:</label>
                                <input name="total_points" type="text" class="form-control" value="{{$exam->total_points}}">
                              </div>
                            </div>
                          </div>
                          <input type="hidden" name="editForm" value="editForm">
                            <button type="submit" class="btn btn-primary">EDIT</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-sm-1" id="exams-row2-content4">
              <form action="{{ url('deactivateexam',[$exam->id]) }}" method="POST">
                {{ csrf_field() }}
                <button type="submit" class ="btn btn-default" id="exam-deactivate" onclick='return confirm("Are you sure want to delete exam?");'>
                  <span class="glyphicon glyphicon-remove" aria-hidden="true" id ="exam-remove"></span>
                </button>
              </form>
            </div>
          </div>
          @endif
          @endforeach
          @elseif(Auth::User()->hasRole('student'))
            @foreach($activeexams as $ex)
            <div class="row" id = "exams-row2-content">
              <div class="col-sm-6" id="exams-row2-content1">
                <p><strong>{{$ex->name}}</strong></p>
                @if($ex->type == 'quiz')
                <p>Type: <strong>Quiz</strong></p>
                @elseif($ex->type == 'pe')
                <p>Type: <strong>Prelim Exam</strong></p>
                @elseif($ex->type == 'fe')
                <p>Type: <strong>Final Exam</strong></p>
                @endif
                <p>Created at: <strong>{{$ex->created_at->month}}/{{$ex->created_at->month}}/{{$ex->created_at->year}}</strong></p>
              </div>
              <div class="col-sm-6">
                <a href= "{{ url('/quizquestions',[$ex->id]) }}" class="btn btn-default" id = "exam-question">
                <span class="glyphicon glyphicon-th-list" aria-hidden="true" id ="exam-list"></span></a>
              </div>
            </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
    <div class="col-sm-8">

      <div class="row" >
        <div class="row" id="cs-results-row1">
          <div class="col-sm-6">
            <p>CLASS STANDING RESULTS</p>
          </div>
        </div>
        <div class="row" id="cs-results-row2">

          <table>
              <thead>
                  <tr>
                      <th>Student Number</th>
                      @foreach($hwavg as $index => $hwavg)
                      <th>HW{{$index+1}} ({{$hwavg->scorehw}})</th>
                      @endforeach
                      <th>Total Score</th>
                      <th>Total Homework Points</th>
                      <th>Percentage</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($hwresults as $hwr)
                  <tr>
                      <th>{{$hwr->student_no}}</th>
                      <td>{{$hwr->score}}</td>
                      <td>{{$hwr->total}}</td>
                      <td>{{$hwr->totalhw}}</td>
                      <td>{{number_format((float) $hwr->percentage, 2)}} %</td>
                  </tr>
                @endforeach
              </tbody>
          </table>

          <table>
              <thead>
                  <tr>
                      <th>Student Number</th>
                      @foreach($swavg as $index => $swavg)
                      <th>SW{{$index+1}} ({{$swavg->scorehw}})</th>
                      @endforeach
                      <th>Total Score</th>
                      <th>Total Homework Points</th>
                      <th>Percentage</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($swresults as $swr)
                  <tr>
                      <th>{{$swr->student_no}}</th>
                      <td>{{$swr->score}}</td>
                      <td>{{$swr->total}}</td>
                      <td>{{$swr->totalhw}}</td>
                      <td>{{number_format((float) $swr->percentage, 2)}} %</td>
                  </tr>
                @endforeach
              </tbody>
          </table>
          <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#createhomework" id= "announce-add">
            <span class="glyphicon glyphicon-plus" aria-hidden="true" id ="announce-plus"></span>
          </button>
          <div id="createhomework" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class='modal-body'>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <form action="{{ route('homework.store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label for="total">Total:</label>
                      <input name="total" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        {!! Form::label('Homework Number:') !!}
                        {!! Form::selectRange('homework_no', 1, 10,
                          array(
                            'class'=>'form-control',
                            'placeholder'=>'Question Type'
                            )) !!}
                    </div>
                    <input type="hidden" name="course_id" value="{{$course->id}}">
                    @foreach($students as $studenthw)
                    <div class="form-group">
                      {{$studenthw -> student_no}}
                      <label for="score">score:</label>
                      <input name="score[{{$studenthw -> student_no}}]" type="text" class="form-control">
                    </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a class="btn btn-default pull-right" >Go Back</a>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#createseatwork" id= "announce-add">
            <span class="glyphicon glyphicon-plus" aria-hidden="true" id ="announce-plus"></span>
          </button>
          <div id="createseatwork" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class='modal-body'>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <form action="{{ route('seatwork.store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label for="total">Total:</label>
                      <input name="total" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        {!! Form::label('Seatwork Number:') !!}
                        {!! Form::selectRange('seatwork_no', 1, 10,
                          array(
                            'class'=>'form-control',
                            'placeholder'=>'Question Type'
                            )) !!}
                    </div>
                    <input type="hidden" name="course_id" value="{{$course->id}}">
                    @foreach($students as $studentsw)
                    <div class="form-group">
                      {{$studentsw -> student_no}}
                      <label for="score">score:</label>
                      <input name="score[{{$studentsw -> student_no}}]" type="text" class="form-control">
                    </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a class="btn btn-default pull-right" >Go Back</a>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row" id="charts">
    <div class="row" id="charts-row1">
      <div class="col-sm-3">
        <p>ACADEMIC PERFORMANCE CHARTS</p>
      </div>
    </div>
    <div class="row" id ="charts-row2">
      @if(Auth::User()->hasRole('student'))
      <div class="col-sm-6">
        <div id="container-percentage-tracker">
        </div>
      </div>
      <table id="datatable"style="display:none">
          <thead>
              <tr>
                  <th></th>
                  <th>Percentage</th>
              </tr>
          </thead>
          <tbody>
              @foreach($studresults as $stud)
              <tr>
                  <th>{{$stud->name}}</th>
                  <td>{{$stud->percentage}}</td>
              </tr>
              @endforeach
          </tbody>
      </table>
      @endif
    </div>
  </div>
</div>
@endsection
