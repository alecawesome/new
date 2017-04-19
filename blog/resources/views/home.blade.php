@extends('layouts.app')

@section('content')
<div class="container">
    @if(Auth::user()->hasRole('student'))
    <h1>SUBJECTS LIST:</h1>
    <a href="{{ url('/student') }}" class="btn btn-default">REDIRECT TO STUDENT DASHBOARD
    </a>
    @elseif (Auth::user()->hasRole('professor'))
    <h1>SUBJECTS HANDLED:</h1>
    <ul>
    <a href="{{ url('/professor') }}" class="btn btn-default">REDIRECT TO PROFESSOR DASHBOARD
    </a>
  </ul>
    @elseif (Auth::user()->hasRole('admin'))
    <a href="{{ url('/admin') }}" class="btn btn-default">REDIRECT TO ADMIN DASHBOARD
    </a>
    @endif

</div>
@endsection
