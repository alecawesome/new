 <?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalayanTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('subjects', function (Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
      });
      Schema::create('sections', function (Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
      });
      Schema::create('courses', function (Blueprint $table){
            $table->increments('id');
            $table->string('subject_name');
            $table->string('section_name');
            $table->string('professor_no');
            $table->timestamps();

            $table->foreign('subject_name')->references('name')->on('subjects')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('section_name')->references('name')->on('sections')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('professor_no')->references('user_no')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');
      });
      Schema::create('students', function (Blueprint $table){
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->string('student_no');
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('student_no')->references('user_no')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');
      });
      Schema::create('announcements', function (Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->string('content');
            $table->integer('course_id')->unsigned();//professors
            $table->string('status')->default('inactive');
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')
            ->onUpdate('cascade')->onDelete('cascade');
      });

      Schema::create('modules', function(Blueprint $table){
      			$table->increments('id');
            $table->integer('course_id')->unsigned();//professors
      			$table->string('filename');
      			$table->string('mime');
      			$table->string('original_filename');
            $table->string('status')->default('active');
      			$table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')
            ->onUpdate('cascade')->onDelete('cascade');
		  });
      Schema::create('homeworks', function (Blueprint $table){
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->string('student_no');
            $table->integer('score');
            $table->integer('homework_no');
            $table->integer('total');
            $table->timestamps();

            $table->foreign('student_no')->references('user_no')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')
            ->onUpdate('cascade')->onDelete('cascade');
      });
      Schema::create('seatworks', function (Blueprint $table){
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->string('student_no');
            $table->integer('score');
            $table->integer('seatwork_no');
            $table->integer('total');
            $table->timestamps();

            $table->foreign('student_no')->references('user_no')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')
            ->onUpdate('cascade')->onDelete('cascade');
      });
      Schema::create('recitations', function (Blueprint $table){
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->string('student_no');
            $table->integer('score');
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('student_no')->references('user_no')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');
      });
      Schema::create('exams', function (Blueprint $table){
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->string('name');
            $table->integer('total_points');
            $table->string('type');
            $table->string('status')->default('inactive');
            $table->timestamps();
            $table->foreign('course_id')->references('id')->on('courses')
            ->onUpdate('cascade')->onDelete('cascade');
      });

      Schema::create('questions', function (Blueprint $table){
            $table->increments('id');
            $table->integer('exam_id');
            $table->string('question_type');
            $table->string('question');
            $table->string('choice1')->nullable();
            $table->string('choice2')->nullable();
            $table->string('choice3')->nullable();
            $table->string('choice4')->nullable();
            $table->string('correct_answer');
            $table->integer('points');
            $table->timestamps();
            $table->foreign('exam_id')->references('id')->on('exams')
            ->onUpdate('cascade')->onDelete('cascade');
      });

      Schema::create('studentans', function (Blueprint $table){
            $table->increments('id');
            $table->string('student_no');
            $table->integer('exam_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->string('answer');
            $table->integer('score');
            $table->string('is_correct');
            $table->timestamps();

            $table->foreign('student_no')->references('user_no')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('exam_id')->references('id')->on('exams')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')
            ->onUpdate('cascade')->onDelete('cascade');
      });

      Schema::create('results', function (Blueprint $table){
            $table->increments('id');
            $table->string('student_no');
            $table->integer('exam_id')->unsigned();
            $table->integer('percentage');
            $table->integer('total');
            $table->integer('no_correct');
            $table->integer('no_incorrect');
            $table->string('rating');
            $table->string('examstatus');
            $table->timestamps();

            $table->foreign('student_no')->references('user_no')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('exam_id')->references('id')->on('exams')
            ->onUpdate('cascade')->onDelete('cascade');
      });

      /*Schema::create('choices', function (Blueprint $table){
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            $table->string('choices')->nullable();
            $table->timestamps();
            $table->foreign('question_id')->references('id')->on('questions')
            ->onUpdate('cascade')->onDelete('cascade');
      });
      Schema::create('answers', function (Blueprint $table){
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            $table->string('correct_answer') ;
            $table->timestamps();
            $table->foreign('question_id')->references('id')->on('questions')
            ->onUpdate('cascade')->onDelete('cascade');
      });*/
      /*Schema::create('types', function (Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
      });*/

    }
    //student exam results table (examid, score, student_no, percentage)
    //student answer table (student exam result id, question_id, answer, score)
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('announcements');
        Schema::drop('courses');
        Schema::drop('sections');
        Schema::drop('subjects');
        Schema::drop('students');
        Schema::drop('exams');
        Schema::drop('questions');
        Schema::drop('studentans');
        Schema::drop('modules');
        Schema::drop('homeworks');
        Schema::drop('seatworks');
        Schema::drop('recitations');
        Schema::drop('results');
         //Schema::drop('types');
         // Schema::drop('answers');
         //Schema::drop('choices');
    }
}
