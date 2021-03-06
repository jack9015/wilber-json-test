<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WilberController extends Controller
{

    private function getFullNameAttribute($value)
    {
       return ucfirst($value['first_name']) . ' ' . ucfirst($value['last_name']);
    }

    public function index()
    {
        $people = json_decode(file_get_contents(storage_path() . "/people.json"), true);

        echo "<pre>";

        // sort by age descending
        usort($people['data'], function($a, $b) {
            return $b['age'] <=> $a['age'];
        });

        // prepare emails
        $emails = [];

        // add name field
        foreach ($people['data'] as $key => $value) {
            $emails[] = $value['email'];
            $people['data'][$key]['name'] = $this->getFullNameAttribute($value);
        }
        
        echo "<h3>a comma-separated list of email addresses</h3>";

        print_r(implode(',', $emails));

        echo "<h3>the original data, sorted by age descending, with a new field on each record called 'name' which is the first and last name joined.</h3>";

        print_r($people);
    }
}