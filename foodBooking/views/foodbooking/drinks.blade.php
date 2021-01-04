<div class="fb_drinks">
	<div class="fb_toolbar">
		<div class="fb_toolBar_wrapper">
				<div class="fb_showDate" id="timeTable">{{strtoupper($data['monthName'])}} {{strtoupper($data['year'])}}</div>
		</div>
	</div>
	<div class="fb_header"><h5>Please choose a drink for your reservation</h5></div>
	<div class="fb_drinks_list_container">
		@foreach($data['drinks'] as $drinks)
		<div class="fb_drinks_wrapper">
			<div class="fb_drinks_spot">
				<div><img src="{{$drinks->image_url}}" /></div>
				<div class="title_plate_wrapper">
					<div class="title_plate">{{substr($drinks->name, 0, 10)}}</div>
					<div class="fb_pick_btn" id="pick_Beer/{{$drinks->name}}">Choose</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
	<div class="fb_goBack">
		<div class="fb_back_btn" id="back_t">Back to time spots</div>
	</div>
</div>