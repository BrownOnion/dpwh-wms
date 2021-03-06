@extends('MasterTemplate.hr')

@section('head')
    <style>
        .text-liner
        {
            line-height:10px !important;
        }
        .logo
        {
            width: 10%;
            height:  10%;
            margin-top: 30px;
            margin-left: 140px;
        }
        .padder
        {
            margin-top: -100px;
        }
    </style>
@endsection()

@section('header')
    Salary Details
@endsection()

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-title">
                Search Worker Salary Information
            </div>

            <div>
                <div class="panel-body">
                    <form class="form-inline" action="/adminDtrReportSearch" method="POST">
                        {{@csrf_field()}}
                        <div class="form-group col-md-3">
                            <label class="form-label col-md-3">Month</label>
                            <select name="month" id="" class="col-md-8">
                                <option value="1" @if($monthNow == 1) selected @endif>January</option>
                                <option value="2"  @if($monthNow == 2) selected @endif>Febuary</option>
                                <option value="3" @if($monthNow == 3) selected @endif>March</option>
                                <option value="4"  @if($monthNow == 4) selected @endif>April</option>
                                <option value="5" @if($monthNow == 5) selected @endif>May</option>
                                <option value="6" @if($monthNow == 6) selected @endif>June</option>
                                <option value="7" @if($monthNow == 7) selected @endif>July</option>
                                <option value="8" @if($monthNow == 8) selected @endif>August</option>
                                <option value="9" @if($monthNow == 9) selected @endif>September</option>
                                <option value="10" @if($monthNow == 10) selected @endif>October</option>
                                <option value="11" @if($monthNow == 11) selected @endif>November</option>
                                <option value="12" @if($monthNow == 12) selected @endif>December</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="form-label col-md-3">Year</label>
                            <select name="year" id="" class="col-md-8" >
                                @for($i = 2015; $i <= $yearNow; $i++)
                                <option value="{{$i}}" @if($i == $yearNow)selected @endif>{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="col-md-12">
        <div class="panel panel-default">
  
          {{-- <div class="panel-title">
            Worker Salary Information
          </div>
   --}}
          <div class="panel-body">

            <div class="row">
                <img class="img-responsive logo" src="{{asset('img/Dpwh Logo.png')}}" width="100%">
                  <div class="col-md-12 col-sm-12 text-center text-liner padder">
                    
                    <b><p style="font-size: 14px;"> Republic of the Philippines</p></b><br>
                    <p style="font-size: 20px; font-family: 'Brush Script MT'">Department of Public Works and Highways</p><br>
                    <p style="font-size: 14px;">Region X</p><br>
                    <b><p style="font-size: 22px;">OFFICE OF THE DISTRICT ENGINEER</p></b><br>
                    <p style="font-size: 20px; font-family: 'Brush Script MT'">Lanao del Norte 2nd Engineering District</p><br>
                    <p style="font-size: 14px;">Seminary Drive, Del Carmen, Iligan City, Tel. No. (063) 221-5703</p><br><br><br>
                    <b><p style="font-size:18px; text-decoration: underline">DAILY TIME RECORD SUMMARY REPORT</p></b><br><br><br>
                  </div>
              </div>
              
              <div class="row text-liner">
                  <div class="col-md-3">
                    <p style="font-size: 14px;">For The Period covering:</p>
                    <p style="font-size: 14px;">Month-Year</p>
                  </div>
              </div>
            <table class="table table-bordered table-striped" >
              <thead>
                <tr>
                    <th  rowspan="2">No.</th>
                    <th  rowspan="2">Name</th>
                    <th  rowspan="2">ID Number</th>
                    <th  rowspan="2">Designation</th>
                    <th colspan="2" class="text-center">Rendered Hours</th>
                </tr>
                <tr>
                    <th>Hours</th>
                    <th>Minutes</th>
                    
                </tr>
              </thead>
              <tbody class="text-capitalize">
                  <?php $no= 0;?>
                @if($worker)
               
                    @foreach($worker as $workers)
                        @if($workers->role_id == 3)
                        <?php $no++; ?>
                            @foreach($attendance as $atten)
                                @if($workers->id == $atten->worker_id)
                                    @if($monthNow == \Carbon\Carbon::createFromFormat('Y-m-d', $atten->Date)->month)
                                        @if($yearNow  == \Carbon\Carbon::createFromFormat('Y-m-d', $atten->Date)->year )

                                        <?php
                                        
                                            $m_total_hour = 0;
                                            $m_signin_time = \Carbon\Carbon::createFromTime(8,0,0, 'Asia/Manila');
                                            $m_signout_time = \Carbon\Carbon::createFromTime(12,0,0, 'Asia/Manila');

                                            if($atten->morningSignin <= $m_signin_time->toTimeString() && $atten->morningSignout > $m_signout_time->toTimeString())
                                            {
                                                $m_total_hour = 240;
                                                $total_hour =  $total_hour + $m_total_hour;
                                            }

                                            if($atten->morningSignin <= $m_signin_time->toTimeString() && $atten->morningSignout < $m_signout_time->toTimeString())
                                            {
                                                if($atten->morningSignout == '00:00:00')
                                                {
                                                    $m_total_hour = 0;
                                                    $total_hour =  $total_hour + $m_total_hour;
                                                }
                                                else 
                                                {
                                                    $m_signout = $atten->morningSignout;
                                                    $hour =  $m_signout[0].''.$m_signout[1];
                                                    $minute = $m_signout[3].''.$m_signout[4];
                                                    $second = $m_signout[6].''.$m_signout[7];

                                                    $m_signout = \Carbon\Carbon::createFromTime($hour,$minute,$second, 'Asia/Manila');
                                                    $m_total_hour = $m_signin_time->diffInMinutes($m_signout);
                                                    $total_hour =  $total_hour + $m_total_hour;
                                                }
                                                    
                                            }
                                            if($atten->morningSignin > $m_signin_time->toTimeString() && $atten->morningSignout >= $m_signout_time->toTimeString()) 
                                            {
                                                if($atten->morningSignin == '00:00:00')
                                                {
                                                    $m_total_hour = 0;
                                                    $total_hour =  $total_hour + $m_total_hour;
                                                }
                                                else 
                                                {
                                                    $m_signin = $atten->morningSignin;
                                                    $hour =  $m_signin[0].''.$m_signin[1];
                                                    $minute = $m_signin[3].''.$m_signin[4];
                                                    $second = $m_signin[6].''.$m_signin[7];

                                                    $m_signin = \Carbon\Carbon::createFromTime($hour,$minute,$second, 'Asia/Manila');
                                                    $m_total_hour = $m_signin->diffInMinutes($m_signout_time);
                                                    $total_hour =  $total_hour + $m_total_hour;
                                                }
                                            }

                                            if($atten->morningSignin > $m_signin_time->toTimeString() && $atten->morningSignout < $m_signout_time->toTimeString()) 
                                            {
                                                if($atten->morningSignin == '00:00:00' || $atten->morningSignout == '00:00:00')
                                                {
                                                    $m_total_hour = 0;
                                                    $total_hour =  $total_hour + $m_total_hour;
                                                }
                                                else 
                                                {
                                                    $m_signin = $atten->morningSignin;
                                                    $hour =  $m_signin[0].''.$m_signin[1];
                                                    $minute = $m_signin[3].''.$m_signin[4];
                                                    $second = $m_signin[6].''.$m_signin[7];

                                                    $m_signout = $atten->morningSignout;
                                                    $hour1 =  $m_signout[0].''.$m_signout[1];
                                                    $minute1 = $m_signout[3].''.$m_signout[4];
                                                    $second1 = $m_signout[6].''.$m_signout[7];

                                                    $m_signin = \Carbon\Carbon::createFromTime($hour,$minute,$second, 'Asia/Manila');
                                                    $m_signout = \Carbon\Carbon::createFromTime($hour1,$minute1,$second1, 'Asia/Manila');
                                                    $m_total_hour = $m_signin->diffInMinutes($m_signout);
                                                    $total_hour =  $total_hour + $m_total_hour;
                                                }
                                            }
                                        ?>

                                        <?php
                                            $a_total_hour = 0;
                                            $a_signin_time = \Carbon\Carbon::createFromTime(13,0,0, 'Asia/Manila');
                                            $a_signout_time = \Carbon\Carbon::createFromTime(17,0,0, 'Asia/Manila');

                                            if($atten->afternoonSignin <= $a_signin_time->toTimeString() && $atten->aftrenoonSignout >= $a_signout_time->toTimeString())
                                            {
                                                $a_total_hour = 240;
                                                $total_hour =  $total_hour + $a_total_hour;
                                            }

                                            if($atten->afternoonSignin <= $a_signin_time->toTimeString() && $atten->aftrenoonSignout < $a_signout_time->toTimeString())
                                            {
                                                if($atten->afternoonSignout == '00:00:00')
                                                {
                                                    $a_total_hour = 0;
                                                    $total_hour =  $total_hour + $a_total_hour;
                                                }
                                                else 
                                                {
                                                    $a_signout = $atten->afternoonSignout;
                                                    $hour =  $a_signout[0].''.$a_signout[1];
                                                    $minute = $a_signout[3].''.$a_signout[4];
                                                    $second = $a_signout[6].''.$a_signout[7];

                                                    $a_signout = \Carbon\Carbon::createFromTime($hour,$minute,$second, 'Asia/Manila');
                                                    $a_total_hour = $a_signin_time->diffInMinutes($a_signout);
                                                    $total_hour =  $total_hour + $a_total_hour;
                                                }
                                                    
                                            }
                                            if($atten->afternoonSignin > $a_signin_time->toTimeString() && $atten->afternoonSignout >= $a_signout_time->toTimeString()) 
                                            {
                                                if($atten->afternoonSignin == '00:00:00')
                                                {
                                                    $a_total_hour = 0;
                                                    $total_hour =  $total_hour + $a_total_hour;
                                                }
                                                else 
                                                {
                                                    $a_signin = $atten->afternoonSignin;
                                                    $hour =  $a_signin[0].''.$a_signin[1];
                                                    $minute = $a_signin[3].''.$a_signin[4];
                                                    $second = $a_signin[6].''.$a_signin[7];

                                                    $a_signin = \Carbon\Carbon::createFromTime($hour,$minute,$second, 'Asia/Manila');
                                                    $a_total_hour = $a_signin->diffInMinutes($a_signout_time);
                                                    $total_hour =  $total_hour + $a_total_hour;
                                                }
                                            }

                                            if($atten->afternoonSignin > $a_signin_time->toTimeString() && $atten->afternoonSignout < $a_signout_time->toTimeString()) 
                                            {
                                                if($atten->afternoonSignin == '00:00:00' || $atten->aftternoonSignout == '00:00:00')
                                                {
                                                    $a_total_hour = 0;
                                                    $total_hour =  $total_hour + $a_total_hour;
                                                }
                                                else 
                                                {
                                                    $a_signin = $atten->afternoonSignin;
                                                    $hour =  $a_signin[0].''.$a_signin[1];
                                                    $minute = $a_signin[3].''.$a_signin[4];
                                                    $second = $a_signin[6].''.$a_signin[7];

                                                    $a_signout = $atten->afternoonSignout;
                                                    $hour1 =  $a_signout[0].''.$a_signout[1];
                                                    $minute1 = $a_signout[3].''.$a_signout[4];
                                                    $second1 = $a_signout[6].''.$a_signout[7];

                                                    $a_signin = \Carbon\Carbon::createFromTime($hour,$minute,$second, 'Asia/Manila');
                                                    $a_signout = \Carbon\Carbon::createFromTime($hour1,$minute1,$second1, 'Asia/Manila');
                                                    $a_total_hour = $a_signin->diffInMinutes($a_signout);
                                                    $total_hour =  $total_hour + $a_total_hour;
                                                }
                                            }
                                        ?>                    
                                                
                                        
                                        @endif
                                    @endif
                                @endif
                            @endforeach

                            @foreach($OT as $ot)
                                @if($workers->id == $ot->worker_id)
                                    @if($monthNow == \Carbon\Carbon::createFromFormat('Y-m-d', $ot->date)->month)
                                        @if($yearNow  == \Carbon\Carbon::createFromFormat('Y-m-d', $ot->date)->year )
                                            <?php
                                                $o_total_hour = 0;
                                                $o_signin_time = \Carbon\Carbon::createFromTime(18,0,0, 'Asia/Manila');
                                                $o_signout_time = \Carbon\Carbon::createFromTime(23,59,0, 'Asia/Manila');

                                                if($ot->signin <= $o_signin_time->toTimeString() && $ot->signout >= $o_signout_time->toTimeString())
                                                {
                                                    if($ot->signin == '00:00:00')
                                                    {
                                                        $o_total_hour = 0;
                                                        $total_hour =  $total_hour + $o_total_hour;
                                                    }
                                                    $o_total_hour = 360;
                                                    $total_hour =  $total_hour + $o_total_hour;
                                                }

                                                if($ot->signin <= $o_signin_time->toTimeString() && $ot->signout < $o_signout_time->toTimeString())
                                                {
                                                    if($ot->signout == '00:00:00' || $ot->signin == '00:00:00' )
                                                    {
                                                        $o_total_hour = 0;
                                                        $total_hour =  $total_hour + $o_total_hour;
                                                    }
                                                    else 
                                                    {
                                                        $o_signout = $ot->signout;
                                                        $hour =  $o_signout[0].''.$o_signout[1];
                                                        $minute = $o_signout[3].''.$o_signout[4];
                                                        $second = $o_signout[6].''.$o_signout[7];

                                                        $o_signout = \Carbon\Carbon::createFromTime($hour,$minute,$second, 'Asia/Manila');
                                                        $o_total_hour = $o_signin_time->diffInMinutes($o_signout);
                                                        $total_hour =  $total_hour + $o_total_hour;
                                                    }
                                                        
                                                }
                                                if($ot->signin > $o_signin_time->toTimeString() && $ot->signout >= $o_signout_time->toTimeString()) 
                                                {
                                                    if($ot->signin == '00:00:00')
                                                    {
                                                        $o_total_hour = 0;
                                                        $total_hour =  $total_hour + $o_total_hour;
                                                    }
                                                    else 
                                                    {
                                                        $o_signin = $ot->signin;
                                                        $hour =  $o_signin[0].''.$o_signin[1];
                                                        $minute = $o_signin[3].''.$o_signin[4];
                                                        $second = $o_signin[6].''.$o_signin[7];

                                                        $o_signin = \Carbon\Carbon::createFromTime($hour,$minute,$second, 'Asia/Manila');
                                                        $o_total_hour = $o_signin->diffInMinutes($o_signout_time);
                                                        $total_hour =  $total_hour + $o_total_hour;
                                                    }
                                                }

                                                if($ot->signin  > $o_signin_time->toTimeString() && $ot->signout < $o_signout_time->toTimeString()) 
                                                {
                                                    if($ot->signin == '00:00:00' || $ot->signout == '00:00:00')
                                                    {
                                                        $o_total_hour = 0;
                                                        $total_hour =  $total_hour + $o_total_hour;
                                                    }
                                                    else 
                                                    {
                                                        $o_signin = $ot->signin;
                                                        $hour =  $o_signin[0].''.$o_signin[1];
                                                        $minute = $o_signin[3].''.$o_signin[4];
                                                        $second = $o_signin[6].''.$o_signin[7];

                                                        $o_signout = $ot->signout;
                                                        $hour1 =  $o_signout[0].''.$o_signout[1];
                                                        $minute1 = $o_signout[3].''.$o_signout[4];
                                                        $second1 = $o_signout[6].''.$o_signout[7];

                                                        $o_signin = \Carbon\Carbon::createFromTime($hour,$minute,$second, 'Asia/Manila');
                                                        $o_signout = \Carbon\Carbon::createFromTime($hour1,$minute1,$second1, 'Asia/Manila');
                                                        $o_total_hour = $o_signin->diffInMinutes($o_signout);
                                                        $total_hour =  $total_hour + $o_total_hour;
                                                    }
                                                }
                                            ?>                
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                           
                            <tr>
                                <td>{{$no}}.</td>
                                <td>{{$workers->firstName}} {{$workers->lastName}}</td>
                                <td>{{$workers->idNumber}}</td>
                                <td>{{$workers->section->name}}</td>
                                <td>{{(int)($total_hour / 60)}}</td>
                                <td>{{$total_hour % 60}}</td>
                            </tr>
                        @endif
                        <?php $total_hour = 0?>
                    @endforeach
                @endif  
            </tbody>
            </table>
            <br>
            <br>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <p style="font-size: 14px; text-indent: 50px;">
                        <b>I CERTIFY</b> on my honor that the above is true and correct report of the hour of work performed - the record of which was
                        made daily at the time of arrival at and departure from office using the district's Workers Management System.
                    </p>
                </div>
            </div>
            <br>
            <div class="row ">
                <div class="col-md-4">
                    <p><b>Recomending By:</b></p>
                    <br>
                    <p><b>_________________________________________________</b></p>
                    <p class="text-center" style="font-size:14px; margin-top: -15px"> Time Keeper</p>
                </div>
                <div class="col-md-4"></div>
  
                <div class="col-md-4">
                  <p><b>Approved By:</b></p>
                  <br>
                  <p><b>_____________________________________________</b></p>
                  <p class="text-center" style="font-size:14px; margin-top: -15px">District Engineer</p>
              </div>  
                </div>
            </div>
          </div>
        </div>
      </div>

@endSection()

@section('jsScript')
    <script>
        $(document).ready(function() {
            $('#salaryIndex').DataTable();
        } );
    </script>
@endsection()