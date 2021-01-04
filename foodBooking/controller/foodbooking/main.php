<?php

namespace App\Http\Controllers\foodbooking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\foodbooking\book;

class main extends Controller
{
    public function __construct(){

    	$this->data = [];
    	$this->book = new book();
    }

    public function index($name, $id, $month){
        if($this->book->validateEndpoint($id)){
            $data['businessName'] = $this->book->correctName($name);
            $data['business_id'] = $id;
            $this->book->returnMonth($month);
            $data['month'] = $this->book->returnMonth($month);    //create a model returning month
            $data['monthName'] = date('F', mktime(0, 0, 0, $data['month'], 10));
            $data['year'] = $this->book->returnYear($month);
            $data['daysTotal'] = $this->book->getnumDays($data['month'], $data['year']);
            $data['thisDate'] = array('Date' => date('d'), 'Day' => date('D'));
            $data['currentDate'] = $this->book->isCurDateRelevant($data['month'], $data['year']);
            $data['dates'] = $this->book->getOpenDaysLeft($data['month'], $data['year']);
            $data['timeSlots'] = array(array("time"=>"16-18", "tablesLeft" => "10"), array("time"=>"18-20", "tablesLeft" => "10"), array("time"=>"20-22", "tablesLeft" => "10"));
            $data['drinks'] = $this->book->getDrinks();
            $data['dish'] = $this->book->getDish();
            foreach ($data['dish'] as $key) {
                $data['dish'] = $key[0];
            }
            var_dump($data['dish']);
            //$this->book->makeDummyCorps();
            //$this->book->makeDummyBookings($id);
            return view('foodbooking/booktable', compact('data'));
        }
        else
            $data = '';
            return view('foodbooking/errorpage', compact('data'));
    }

    public function getTables(){
        return json_encode('SUCCES');
    }
}
