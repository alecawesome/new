<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
    //  ['user_no' => '20170000001','password'=> bcrypt('teststudent'),'email' => 'teststudent@gmail.com','name' => 'Student', 'role' => 'student'],
    //  ['user_no' => '20170000002','password'=> bcrypt('teststudent1'),'email' => 'teststudent1@gmail.com','name' => 'Student1', 'role' => 'student'],
      ['user_no' => 'P0001','password'=>bcrypt('testprof'),'email' => 'testprof@gmail.com','firstname' => 'Prof','lastname' => 'prof','middlename' => 'prof', 'role' => 'professor'],
      ['user_no' => 'A0001','password'=>bcrypt('testadmin'),'email' => 'testadmin@gmail.com','firstname' => 'Admin','lastname' => 'admin','middlename' => 'admin', 'role' => 'admin']
    ]);
    }
}
