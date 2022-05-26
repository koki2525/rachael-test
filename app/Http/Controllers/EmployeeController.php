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
            $employeeEndDate = $employee['employmentEndDate'];
            $employmentStartDate = strtotime($employee['employmentStartDate']);

            //check if it is employee's birthday is today, if they have started yet and if they still work here
            if ($todayDay == $birthDay && $todayMonth  == $birthMonth && $employeeEndDate==null && $employmentStartDate <= $today){
                array_push($names,$employee['name']);

            $removeFromList = file_get_contents('https://interview-assessment-1.realmdigital.co.za/do-not-send-birthday-wishes');
            $removeFromList = json_decode($removeFromList, true);
            }
        }

        $names = implode(", ", $names);

        if (empty($names)) {
            $to_name = 'Employees';
            $to_email = 'koketso.maphopha@gmail.com';
            $data = array('name'=>'Rachael Maphopha', 'body' => 'No birthdays today.');

            Mail::send('emails.birthdays', $data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                ->subject('Birthday wishes to Realm Digital Employees');
                $message->from('koketso.maphopha@gmail.com','Birthday wishes');
                });
                return view('message-sender')->with('message', 'No birthdays today');
        }
        else{
        $to_name = 'Employees';
        $to_email = 'koketso.maphopha@gmail.com';
        $data = array('name'=>'Rachael Maphopha', 'body' => $input.' '.$names);

        Mail::send('emails.birthdays', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
            ->subject('Birthday wishes to Realm Digital Employees');
            $message->from('koketso.maphopha@gmail.com','Birthday wishes');
            });

            return view('message-sender')->with('names')->with(['message' => 'Message sent successfully', 'alert' => 'alert-sucess'] );
        }

        
    }
}
