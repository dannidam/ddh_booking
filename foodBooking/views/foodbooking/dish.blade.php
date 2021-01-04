<div class="fb_dish">
	<div class="fb_toolbar">
		<div class="fb_toolBar_wrapper">
				<div class="fb_showDate" id="timeTable">{{strtoupper($data['monthName'])}} {{strtoupper($data['year'])}}</div>
		</div>
	</div>
	<div class="fb_header"><h5>Please accept your dish of the day</h5></div>
	<div class="fb_dish_list_container">
		<div class="fb_dish_item">
			<div><img src="{{$data['dish']->strMealThumb}}" /></div>
			<div><h3>{{$data['dish']->strMeal}}</h3></div>
			<div class="fb_dish_btn" id="acceptDish">Accept</div>
			<div class="fb_goBack_dish">
			<div class="fb_back_btn_dish" id="back_dr">Back to drinks</div>
		</div>
		</div>
	</div>
</div>