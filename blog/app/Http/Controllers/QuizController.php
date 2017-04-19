<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Announcement;
use App\Course;
use App\Student;
use App\Exam;
use App\Question;
use App\Studentans;
use App\Result;
use DB;
use Auth;
use Illuminate\Support\Facades\Input;

class QuizController  extends Controller
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
    public function index()
    {

    }
    public function getQuiz($exam_id)
    {
        $loggedinuserno = Auth::user()->user_no;
      /*$subjectshandled = DB::table('questions')
      ->leftJoin('studentans', 'studentans.question_id', '=', 'questions.id')
      ->where('student_no',$loggedinuserno)
      ->select('questions.id','correct_answer','answer')
      ->get();
      return $subjectshandled;
        $questionscore = DB::table('questions')-> where('id','=',1)->select('correct_answer')->get();
        return $questionscore;*/
          $exams = Exam::where('id',$exam_id)->get();
          $questions = Question::where('exam_id',$exam_id)->get();
          $examstatus = Result::where([['exam_id',$exam_id],['student_no',$loggedinuserno]])->get();
          return view('Quiz', compact('exams','questions','examstatus'));
    }

    public function store(Request $request)
    {
        $loggedinuserno = Auth::user()->user_no;
        $answers = Input::get(array('answer'));
        $postId = $request->exam_id;
        $postUser = $request->student_no;
        foreach ($answers as $key => $value) {
          //$key = question id
          //$value = user submitted answer
          $questionanswer = Question::where('id',$key)->select('correct_answer','points')->get();
          $a = new Studentans;
          $a->exam_id=$postId;
          $a->question_id=$key;
          $a->student_no=$postUser;
          $a->answer=$value;
          foreach($questionanswer as $ans)
          {
            if($ans->correct_answer === $value)
            {
              $a->score = $ans->points;
              $a->is_correct = 'YES';
            }
            else
            {
              $a->score=0;
              $a->is_correct = 'NO';
            }
          }
          $a->save();
        }

        $studentscore = Studentans::where([['student_no',$loggedinuserno],['exam_id',$postId]])->select('score')->get();
        $studentiscorrect = Studentans::where([['student_no',$loggedinuserno],['is_correct','=','YES'],['exam_id',$postId]])->get();
        $studentisincorrect = Studentans::where([['student_no',$loggedinuserno],['is_correct','=','NO'],['exam_id',$postId]])->get();
        $questiontotal = Question::where('exam_id',$postId)->select('points')->get();
        $totalscore = $studentscore->sum('score');
        $examtotal = $questiontotal->sum('points');

        $result = new Result;
        $result->student_no = $postUser;
        $result->exam_id = $postId;
        $result->total = $totalscore;
        $result->no_correct = count($studentiscorrect);
        $result->no_incorrect = count($studentisincorrect);
        $result->percentage = ($totalscore/$examtotal)*100;
        $result->examstatus = 'completed';
        if(($totalscore/$examtotal)*100 > 60)
        {
          $result->rating = 'passed';
        }
        else{
          $result->rating = 'failed';  
        }
        $result ->save();

        return redirect()->back();

    }

    /*public function result(Request $req){
		$input = $req->all();
		if(isset($input['option'])){
			$array_of_options = $input['option'];
			foreach($array_of_options as $key => $value){
				//$key = question id
				//$value = user submitted answer
				$answer = Answer::select('answer')->where('question_id','=',$key)->get();
        $correct_answer = Question::select('correct_answer')->where('question_id','=',$key)->get();
        	//Single answer
					$answer = $answer->first();
					if($answer->option_id === $value){
						//User answer is correct
						$correct_answer[$key] = $value;
					}else{
						//User answer isn't correct
						$wrong_answer[$key] = $value;
					}
			}
			if(isset($correct_answer)){
				$correct_answer_count = count($correct_answer);
				//Get the skill result
				//$correct_answer_array = array_keys($correct_answer);
				//$chart = $this->getSkillResult($correct_answer_array);
				//$this->generatePdf($chart);
			}else{
				$correct_answer_count = 0;
				//$correct_answer = null;
				//$chart = null;
			}
			if(isset($wrong_answer)){
				$wrong_answer_count = count($wrong_answer);
			}else {
				$wrong_answer_count = 0;
				//$wrong_answer = null;
			}
			$success_percentage = ($correct_answer_count * 100)/($correct_answer_count + $wrong_answer_count);
			$result_data = [
				'student_no' => Auth::user()->user_no,
				'exam_id' => $req->input('exam_id'),
				'total_attempt' => ($correct_answer_count + $wrong_answer_count),
				'correct_answers' => $correct_answer_count,
				'percentage' => $success_percentage
			];
			DB::table('results')->insert($result_data);
			$user_given_inputs = $input['option'];
			//Call the pdf creation and sending email function here to include the $skill data and user result data

			//return view('result')->with(['chart' => $chart,'user_given_inputs' => $user_given_inputs,'percentage' => $success_percentage,'correct_answer' => $correct_answer,'wrong_answer' => $wrong_answer]);
		//}else{
			//return view('result')->with(['message' => 'You did not answer any question. Try again!']);
		//}
	 }
 }
    public function getQuiz(Request $request, $exam_id)
    {
          $exams = Exam::find($exam_id);
          $question_ids = DB::table('questions')->select('id')->where('exam_id','=',$exam_id)->get();
  		           foreach($question_ids as $question){
  			         $options[$this->getQuestion($question->id)][] = DB::table('choices')->where('question_id','=',$question->id)->select('id','choices','question_id')->get();
  		           }
          return view('Quiz', array('questions'=>$options,'exams'=>$exams));
    }

    public function getQuestion($id){
        $question = Question::find($id);
          return $question->question;
     }

*/
    public function submittedExam(Request $request,$id)
    {
      $change = Exam::where('id',$id)->update(array('status'=>'submitted'));
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
      $section = Section::find($id);

      if (isset($request->name)) {
      $postName = $request->name;
      $section->name = $postName;
      }
      if (isset($request->description)) {
      $postDescription = $request->description;
      $section->description = $postDescription;
      }

      $section->save();

      if (isset($request->editForm)) {
        return redirect()->route('subjectview.index');
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
      $section = Section::find($id);
      $section->delete();
      return redirect()->route('subjectview.index');
    }
}
