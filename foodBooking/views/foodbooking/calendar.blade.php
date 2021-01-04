<div class="fb_calender" id="step1">
	<div class="fb_toolbar">
		<div class="fb_toolBar_wrapper">
			<div class="fb_nav_btn fb_double" id="prev_y"><i class="fas fa-angle-double-left"></i></div>
			<div class="fb_nav_btn" id="prev_m"><i class="fas fa-angle-left"></i></div>
			<div class="fb_showDate">{{strtoupper($data['monthName'])}} {{strtoupper($data['year'])}}</div>
			<div class="fb_nav_btn" id="next_m"><i class="fas fa-angle-right"></i></div>
			<div class="fb_nav_btn fb_double" id="next_y"><i class="fas fa-angle-double-right"></i></div>
		</div>
	</div>
	<div class="fb_header"><h5>Please choose date for your reservation</h5></div>
	<div class="fb_calender_content">
		@foreach($data['dates'] as $days)
			@if($days['Date'] < $data['currentDate']['Date'])
				@if(!$days['closed'])
				<div class="fb_dateBox_wrapper">
					<div class="fb_dateBox open unavailable" id="fb_dateBox/{{$days['Date']}}">
						<div class="fb_day">{{$days['Day']}}</div>
						<div class="fb_date">{{$days['Date']}}</div>
					</div>
				</div>
				@else
				<div class="fb_dateBox_wrapper">
					<div class="fb_dateBox closed" id="fb_dateBox/{{$days['Date']}}">
						<div class="fb_day">{{$days['Day']}}</div>
						<div class="fb_date">{{$days['Date']}}</div>
					</div>
				</div>
				@endif
			@else
				@if(!$days['closed'])
					<div class="fb_dateBox_wrapper">
						<div class="fb_dateBox open available" id="fb_dateBox/{{$days['Date']}}">
							<div class="fb_day">{{$days['Day']}}</div>
							<div class="fb_date">{{$days['Date']}}</div>
						</div>
					</div>
				@else
					<div class="fb_dateBox_wrapper">
						<div class="fb_dateBox closed" id="fb_dateBox/{{$days['Date']}}">
							<div class="fb_day">{{$days['Day']}}</div>
							<div class="fb_date">{{$days['Date']}}</div>
						</div>
					</div>
				@endif
			@endif
		@endforeach
	</div>
	<div class="fb_legend">
	<div class="fb_legend_wrapper">
		<div class="box_unavailable"></div>
		<label> Date not available</label>
	</div>
	<div class="fb_legend_wrapper">
		<div class="box_closed"></div>
		<label> restaurant is closed</label>
	</div>
	<div class="fb_legend_wrapper">
		<div class="box_available"></div>
		<label> Date is available</label>
	</div>
</div>
</div>
