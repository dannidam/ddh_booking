@extends ('foodbooking.layouts.layout')
@section('content')
<div class="fb_site_wrapper">
	<div class="fb_container_main">
		<div class="fb_title_container">
			<h1 class="fb_title">{{strtoupper($data['businessName'])}}'S BOOKING</h1>
		</div>
		<div class="fb_contentContainer">
			@include('foodbooking.calendar')
			@include('foodbooking.timetable')
			@include('foodbooking.drinks')
			@include('foodbooking.dish')
		</div>
	</div>
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script type="text/javascript">
var month = <?php echo json_encode($data["month"])?>;
var monthName = <?php echo json_encode($data["monthName"])?>;
var year = <?php echo json_encode($data["year"])?>;
var path = window.location.pathname;
var url = window.location.origin;
var date = '';
var id = <?php echo json_encode($data['business_id'])?>;
month = parseInt(month);
year = parseInt(year);


$(document).ready(function(){
  $('#prev_m').on('click', function(){
  	updateUrl('month', '-');
  });
  
  $('#next_m').on('click', function(){
  	updateUrl('month', '+');
  });
  $('#prev_y').on('click', function(){
  	updateUrl('year', '-');
  });
  
  $('#next_y').on('click', function(){
  	updateUrl('year', '+');
  });

  $('.open').on('click', function(){
  		$('#timeTable').text('');
  		date = $(this).attr('id');
  		date = date.split('/');
  		date = date[1];
  		var dateString = monthName + " " + year;
  		$('#timeTable').text(date + " " + dateString.toUpperCase());

  		$('.fb_timetable').show('fade', 250);
  		$('.fb_calender').hide('fade', 250);
  });
  
  $('#back_c').on('click', function(){
  		$('.fb_timetable').hide('fade', 250);
  		$('.fb_calender').show('fade', 250);
  });

  $('#back_t').on('click', function(){
  		$('.fb_drinks').hide('fade', 250);
  		$('.fb_timetable').show('fade', 250);
  });

  $('#back_dr').on('click', function(){
  		$('.fb_dish').hide('fade', 250);
  		$('.fb_drinks').show('fade', 250);
  });

  $('.fb_tables_btn').on('click', function(){
		$('.fb_timetable').hide('fade', 250);
		$('.fb_drinks').show('fade', 250);
	});
  $('.fb_pick_btn').on('click', function(){
		$('.fb_drinks').hide('fade', 250);
		$('.fb_dish').show('fade', 250);
	});

});


function updateTables(){
}

function updateUrl(type, calc){
	if(type == 'month'){
		UpdateMonth(calc);
	}
	else{
		updateYear(calc);
	}
	
	var returnUrl = splitPathToChange();
	location = returnUrl;
}

function splitPathToChange(){
	var parts = path.split('/');
	var parts = parts.slice(0, -1);
	var newUrl = '';
	var newDate = '';
	var first = false;
	for(i = 0; i < parts.length; i++){
		if(!first){
			newUrl += parts[i];
			first = true;
		}
		else{
			newUrl += '/' + parts[i];
		}
	}
	newDate = '/m=' + month + '_' + year;
	newUrl = url + newUrl + newDate;
	return newUrl;
}

function UpdateMonth(calc){
	if(calc == '+'){
		if(month == 12){
			month = 0 + 1;
			year = year + 1;
		}
		else{
			month = month + 1;
		}
	}
	else{
		if(month == 1){
			month = 12;
			year = year - 1;
		}
		else{
			month = month - 1;
		}
	}
}

function updateYear(calc){
	if(calc == '+'){
		year = year + 1;	
	}
	else{
		year = year - 1;
	}
}
</script>

