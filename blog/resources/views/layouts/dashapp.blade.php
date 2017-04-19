<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <title>{{ config('app.name', 'BaLZ') }}</title>

   <!-- Styles -->
   <link href="{{ asset('css/app.css') }}" rel="stylesheet">
   <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css?family=Raleway:600,800,900" rel="stylesheet">
   <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
   <!-- Scripts -->
   <script>
       window.Laravel = {!! json_encode([
           'csrfToken' => csrf_token(),
       ]) !!};
   </script>
   <script src="https://code.highcharts.com/highcharts.js"></script>
   <script src="https://code.highcharts.com/modules/data.js"></script>
   <script src="https://code.highcharts.com/modules/exporting.js"></script>
</head>
<body>
  <div id="mysidenav" class="sidenav">
    <ul id="sidenav-ul">
        <span class="glyphicon glyphicon-remove" onclick="closeNav()" aria-hidden="true" id="close"></span>
        <div class="row" id="sidenav-row">
        <p>SUBJECTS</p>
        @foreach($profsubjectshandled as $profsubject)
          <a href= "{{ url('/subjectview',[$profsubject->id]) }}">
            <strong>{{$profsubject->description}}</strong> {{$profsubject->section_name}}
          </a>
        @endforeach
        @foreach($studsubjectshandled as $studsubject)
          <a href= "{{ url('/subjectview',[$studsubject->id]) }}">
            {{$studsubject->id}}{{$studsubject->subject_name}}
          </a>
        @endforeach
      </div>
      <div class="row">
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            <span class="glyphicon glyphicon-off" aria-hidden="true" id="logout"></span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
      </div>
      </ul>
  </div>

  <div id="main">
    <nav class="navbar navbar-default navbar-static-top" id = "dashapp-nav">
        <div>
            <div class="navbar-header" onclick="openNav()" id="navbar-menu">
                  <div class="row navbar-brand">
                <!-- Branding Image -->
                  <div class="col-sm-2" id="menu-column">
                    <span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>
                  </div>
                  <div class="col-sm-7" id="menu-column">
                    <p>MENU</p>
                  </div>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Center Of Navbar -->
                <ul class="nav navbar-nav"  id = "navbar-logo">
                    <a class="navbar-brand" href="{{ url('/dashboard') }}">
                      {{ config('app.name', 'BalZ') }}
                    </a>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right" id ="navbar-name">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                       <p class="navbar-text">Hi! <strong>{{ Auth::user()->name()}}</strong></p>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
  </div>

   <!-- Scripts -->
   <script src="{{ asset('js/app.js') }}"></script>
   <!--<script src="{{ asset('js/bootstrap.min.js') }}"></script>-->
   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
   <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>


   <script>
   function openNav() {
       document.getElementById("mysidenav").style.width = "300px";
       document.getElementById("main").style.marginLeft = "300px";
       document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
   }
   function closeNav() {
       document.getElementById("mysidenav").style.width = "0";
       document.getElementById("main").style.marginLeft= "0";
       document.body.style.backgroundColor = "white";
   }
   </script>
   <script type="text/javascript">
      $(document).ready(function () {
      $('#mc'+'#tf').show();
      $('#selectMe').change(function () {
      $('#mc').hide();
      $('#'+$(this).val()).show();
        })
      });
   </script>

   <script>
    function sortTable(n) {
      var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
      table = document.getElementById("TotalGrade");
      switching = true;
      //Set the sorting direction to ascending:
      dir = "asc";
      /*Make a loop that will continue until
      no switching has been done:*/
      while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.getElementsByTagName("TR");
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
          //start by saying there should be no switching:
          shouldSwitch = false;
          /*Get the two elements you want to compare,
          one from current row and one from the next:*/
          x = rows[i].getElementsByTagName("TD")[n];
          y = rows[i + 1].getElementsByTagName("TD")[n];
          /*check if the two rows should switch place,
          based on the direction, asc or desc:*/
          if (dir == "asc") {
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
              //if so, mark as a switch and break the loop:
              shouldSwitch= true;
              break;
            }
          } else if (dir == "desc") {
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
              //if so, mark as a switch and break the loop:
              shouldSwitch= true;
              break;
            }
          }
        }
        if (shouldSwitch) {
          /*If a switch has been marked, make the switch
          and mark that a switch has been done:*/
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
          //Each time a switch is done, increase this count by 1:
          switchcount ++;
        } else {
          /*If no switching has been done AND the direction is "asc",
          set the direction to "desc" and run the while loop again.*/
          if (switchcount == 0 && dir == "asc") {
            dir = "desc";
            switching = true;
          }
        }
      }
    }
  </script>


  <script>
      Highcharts.chart('container-percentage-tracker', {
          data: {
              table: 'datatable'
          },
          chart: {
              type: 'column'
          },
          title: {
              text: 'Quiz percentage tracker'
          },
          yAxis: {
              allowDecimals: false,
              title: {
                  text: 'Percent'
              }
          },
          tooltip: {
              formatter: function () {
                  return '<b>' + this.series.name + '</b><br/>' +
                      this.point.y + ' ' + this.point.name.toLowerCase();
              }
          }
      });
  </script>



      <script>
          Highcharts.chart('container-percentage-tracker1', {
              data: {
                  table: 'datatable1'
              },
              chart: {
                  type: 'column'
              },
              title: {
                  text: 'COUNT OF CORRECT AND INCORRECT STUDENTS PER QUESTION'
              },
              yAxis: {
                  allowDecimals: false,
                  title: {
                      text: 'Count'
                  }
              },
              tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                        '<b>' + 'Number of Students:' + '</b>' + ' ' + this.point.y + '</br> ';
                }
              }
          });
      </script>
</body>
</html>
