<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $input = $request->input('text');

        $employees = file_get_contents('https://interview-assessment-1.realmdigital.co.za/employees');
        $employees = json_decode($employees, true);
        $today = strtotime(date('Y-m-d H:i:s'));
        $todayMonth = date("m", $today);
        $todayDay = date("d", $today);
        $names = []; 

        foreach($employees as $key => $employee)
        {
            $dateValue = strtotime($employee['dateOfBirth']);                     
            $birthMonth = date("m", $dateValue); 
            $birthDay = date("d", $dateValue); 

            //check if it is employee's birthday is today
            if ($todayDay == $birthDay && $todayMonth  == $birthMonth){
                array_push($names,$employee['name']);
            }
        }

        $to_name = 'Employees';
        $to_email = 'koketso.maphopha@gmail.com';
        $data = array('name'=>'Rachael Maphopha', 'body' => 'Happy birthday');

        Mail::send('emails.birthdays', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
            ->subject('Birthday wishes to Realm Digital Employees');
            $message->from('koketso.maphopha@gmail.com','Birthday wishes');
            });
        

        return view('message-sender')->with('employees');
    }
}
