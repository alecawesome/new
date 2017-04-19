<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Announcement;
use App\Course;
use App\Student;
use App\Exam;
use App\Question;
use App\Choice;
use App\Answer;
use DB;
use Session;
use Auth;
use Illuminate\Support\Facades\Input;

class QuestionBuilderController  extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($exam_id)
    {
        $loggedin = Auth::user()->user_no;
        $exams = Exam::where('id',$exam_id)->get();
        $questions = Question::where('exam_id',$exam_id)->get();
        $questionpoints = Question::select('points')->where('exam_id',$exam_id)->get();
        /*questionlist = DB::table('questions')->select('id')->where('exam_id','=',$exam_id)->get();
        foreach($questionlist as $question){
          $choices = DB::table('choices')->where('question_id','=',$question->id)->get();
        }*/
        $profsubjectshandled = DB::table('courses')
          ->leftJoin('subjects','subjects.name','=','courses.subject_name')
          ->where('professor_no',$loggedin)
          ->get();
        $studsubjectshandled = DB::table('students')
          ->leftJoin('courses', 'courses.id', '=', 'students.course_id')
          ->where('student_no',$loggedin)
          ->get();
        return view('QuestionBuilder', compact('exams','questions','questionpoints','profsubjectshandled','studsubjectshandled'));
    }
    public function store(Request $request)
    {
/*          $question = new Question;
          $postQuestionType = $request->question_type;
          $postQuestion = $request->question;
          $postPoints = $request->points;
          $postId = $request->exam_id;

          $question->question_type= $postQuestionType;
          $question->question= $postQuestion;
          $question->points= $postPoints;
          $question->exam_id= $postId;

          $question->save();
          $choices = Input::get(array('choices'));
          $postQuestionId = $question->id;

          foreach($choices as $choice){
          $choicea = new Choice;
          $choicea->choices= $choice;
          $choicea->question_id= $postQuestionId;
          $choicea->save();
          }
          $answers = new Answer;
          $postAnswer = $request->correct_answer;

          $answers->correct_answer = $postAnswer;
          $answers->question_id = $postQuestionId;

          $answers->save();
*/
          $this->validate($request, [
          'points' => 'required|numeric|min:1|max:100',
          'correct_answer' => 'required|min:1|max:50',
          ]);

          $question = new Question;
          $postQuestionType = $request->question_type;
          $postQuestion = $request->question;
          $postPoints = $request->points;
          $postId = $request->exam_id;
          $postChoice1 = $request->choice1;
          $postChoice2 = $request->choice2;
          $postChoice3 = $request->choice3;
          $postChoice4 = $request->choice4;
          $postAnswer = $request->correct_answer;

          $question->question_type= $postQuestionType;
          $question->question= $postQuestion;
          $question->points= $postPoints;
          $question->exam_id= $postId;
          $question->choice1= $postChoice1;
          $question->choice2= $postChoice2;
          $question->choice3= $postChoice3;
          $question->choice4= $postChoice4;
          $question->correct_answer= $postAnswer;

          $question->save();
          Session::flash('flash_messsage', 'Question successfully added!');

          return redirect()->back();
    }


    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $question = Question::find($id);

      if (isset($request->question)) {
      $postQuestion = $request->question;
      $question->question = $postQuestion;
      }
      if (isset($request->points)) {
      $postPoints = $request->points;
      $question->points = $postPoints;
      }
      if (isset($request->choice1)) {
      $postChoice1 = $request->choice1;
      $question->choice1 = $postChoice1;
      }
      if (isset($request->choice2)) {
      $postChoice2 = $request->choice2;
      $question->choice2 = $postChoice2;
      }
      if (isset($request->choice3)) {
      $postChoice3 = $request->choice3;
      $question->choice3 = $postChoice3;
      }
      if (isset($request->choice4)) {
      $postChoice4 = $request->choice4;
      $question->choice4 = $postChoice4;
      }
      if (isset($request->correct_answer)) {
      $postCorrectAnswer = $request->correct_answer;
      $question->correct_answer = $postCorrectAnswer;
      }

      $question->save();

      if (isset($request->editForm)) {
        return redirect()->back();
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
