<?php

namespace App\models\foodbooking;

use Illuminate\Database\Eloquent\Model;
use DB;

class book extends Model
{
	public function correctName($name){
		$parts = explode("_", $name);
		$first = false;
		$newName = "";
		foreach ($parts as $part) {
			if(!$first){
				$newName .= " ".ucfirst($part);
			}
			else{
				$newName .= ucfirst($part);
			}
		}
		return $newName;
	}

    public function returnMonth($month){
        $time = explode("_", $month);
        $returnValue = '';
        if($time[0] == 'cur'){
            $returnValue = date('m');
        }
        else{
            $returnValue = $time[0];
        }

        return $returnValue;
    }

    public function isCurDateRelevant($month, $year){
        $thisYear = date('Y');
        $thisMonth = date('m');
        $validate = array('Date' => date('d'), 'Day' => date('D'));

        //dd($thisYear, $year);

        
        if($year == $thisYear){
            if($month < $thisMonth){
                $validate['Date'] = 100;
            }
            elseif($month > $thisMonth){
                $validate['Date'] = 0;
            }
        }

        elseif($year > $thisYear){
            $validate['Date'] = 0;
        }

        elseif($year < $thisYear){
            $validate['Date'] = 100;
        }
        //return $validate;
        return $validate;
    }

    public function returnYear($month){
        $date = explode("_", $month);
        return $date[1];
    }

	public function getnumDays($month, $year = null){
		if(!$year)
    		$year = date("Y");
    	$daysInMonth = cal_days_in_month( 0, $month, $year);
    	$days = [];

    	for($i = 1; $i <= $daysInMonth; $i++){
    			$time = mktime(12, 0, 0, $month, $i, $year);
	    		if (date('m', $time)==$month){
	    			if(date('D', $time) != 'Sat' && date('D', $time) != 'Sun'){
	    				//we need to create a sub array and then it to openDays       
	        			$day = array(
	        				'Date' => date('d', $time),
	        				'Day' => date('D', $time),
	        				'closed' => false
	        			);
	        		}
	        		else{
	        			$day = array(
	        				'Date' => date('d', $time),
	        				'Day' => date('D', $time),
	        				'closed' => true
	        			);
	        		}
	        		array_push($days, $day);
	    		}
    		}
    	return $days;
	}
    public function getOpenDaysLeft($month, $year = null){
    	$openDays = [];
    	if(!$year)
    		$year = date("Y");
    	// this function returns how many days are left in the current month
    	$daysInMonth = cal_days_in_month( 0, $month, $year);
    	$currentDate = array(
    		'Date' => date("d"),
    		'Day' => date("D")
    	);
  		$currentMonth = date("m");
    	
    		for($i = 1; $i <= $daysInMonth; $i++){
    			$time = mktime(12, 0, 0, $month, $i, $year);
	    		if (date('m', $time)==$month){
	    			if(date('D', $time) != 'Sat' && date('D', $time) != 'Sun'){
	    				//we need to create a sub array and then it to openDays       
	        			$days = array(
	        				'Date' => date('d', $time),
	        				'Day' => date('D', $time),
	        				'closed' => false
	        			);
	        		}
	        		else{
	        			$days = array(
	        				'Date' => date('d', $time),
	        				'Day' => date('D', $time),
	        				'closed' => true
	        			);
	        		}
	        		array_push($openDays, $days);
	    		}
    		}
    	

    	$openDays = $this->checkHDays($month, $openDays);
    	return $openDays;
    }

    private function checkHDays($month, $openDays){
    	$holidays = $this->getholidays();
    	$newOpenDays = [];

    	foreach($openDays as $days){
    		foreach ($holidays as $h) {
	    		if($h['Month'] == $month){
	    			if($days['Date'] == $h['Date']){
	    				$days['closed'] = true;
	    			}
	    		}
    		}
    	array_push($newOpenDays, $days);
    	}

    	return $newOpenDays;
    }

    private function getholidays(){
    	$holidays = array(array("Date" => "01", "Month" => "01"), array("Date" => "09", "Month" => "04"), array("Date" => "10", "Month" => "04"), array("Date" => "13", "Month" => "04"), array("Date" => "08", "Month" => "05"), array("Date" => "21", "Month" => "05"), array("Date" => "22", "Month" => "05"), array("Date" => "01", "Month" => "06"), array("Date" => "05", "Month" => "06"), array("Date" => "24", "Month" => "12"), array("Date" => "25","Month" => "12"), array("Date" => "26", "Month" => "12"), array("Date" => "31", "Month" => "12"));

    	return $holidays;
    }

    private function getDummyData(){
        $companies = array(array('name' => 'sundown_boulevard', 'shop_id' => 'fb_845521'), array('name' => 'rolling_thunder_boulevard', 'shop_id' => 'fb_524568'), array('name' => 'the_sticky_fish', 'shop_id' => 'fb_52455687'));

        return $companies;
    }

    public function makeDummyCorps(){
        $shop = $this->getDummyData();
        foreach ($shop as $s) {
            DB::table('foodbooking_users')->insert([
                'shop_name' => $s['name'],
                'shop_id' => $s['shop_id'],
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }
    }

    public function getReservationId($name){
        $prefix = substr($name, 0,3);
        $num = DB::table('foodbooking_bookings')->count() + 1;
        $reservation = $prefix.$num;
        return $reservation;
    }

    public function makeDummyBookings($shop_id){
        $name = DB::table('foodbooking_users')->where('shop_id', $shop_id)->first();
        $reservation = $this->getReservationId($name->shop_name);
        
        DB::table('foodbooking_bookings')->insert([
            'shop_id' => $shop_id,
            'email' => 'someEmail@email.com',
            'reservation_id' => $reservation,
            'seats' => '4',
            'timespot' => '1',
            'drink' => 'drink',
            'food' => 'food',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    public function validateEndpoint($shop_id){
        $exist = DB::table('foodbooking_users')->where('shop_id', $shop_id)->first();
        $validate = ($exist != null)?true:false;
        return $validate;
    }

    public function getTables($shop_id, $date){
        //check if any bookings
        $bookingsExist = DB::table('foodbooking_bookings')->where('shop_id', $shop_id)->where('date', $date)->first();

        if($bookingExist != null){
            $query = DB::table('foodbookings_bookings')->select('seats')->where('shop_id', $shop_id)->where('date', $date)->get();
        }

        return $query;
    }

    public function getDrinks(){
            $url = 'https://api.punkapi.com/v2/beers';

            $curl = curl_init();
            // Set some options - we are passing in a useragent too here
            curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
            ]); 
            //  Send the request & save response to $resp   
            $idResp = curl_exec($curl); 
            // Close request to clear up some resources
            curl_close($curl);

            $idResp = json_decode($idResp);
            $idResp = $this->removeKegsFromList($idResp);
            return $idResp;
    }

    public function getDish(){
            $url = 'https://www.themealdb.com/api/json/v1/1/random.php';

            $curl = curl_init();
            // Set some options - we are passing in a useragent too here
            curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
            ]); 
            //  Send the request & save response to $resp   
            $idResp = curl_exec($curl); 
            // Close request to clear up some resources
            curl_close($curl);

            $idResp = json_decode($idResp);
            //$idResp = $this->removeKegsFromList($idResp);
            return $idResp;
    }

    private function removeKegsFromList($list){
        $newList = [];
        foreach($list as $l){
            //var_dump($l->image_url);
            $img = $l->image_url;
            $parts = explode("/", $img);
            $lastEl = array_pop($parts);
            if($lastEl != "keg.png"){
                array_push($newList, $l);
            }
        }
        return $newList;
    }   
}