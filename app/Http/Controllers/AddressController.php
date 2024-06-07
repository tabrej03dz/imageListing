<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function getState(Request $request){
        $cid = $request->post('cid');
        $states = DB::table('states')->where('country_id', $cid)->orderBy('name', 'asc')->get('*');

        $html = '<option value="">Select State</option>';

        foreach ($states as $state){
            $html .= '<option value="'. $state->id. '">'.$state->name.'</option>';
        }

        echo $html;

    }

    public function getCity(Request $request){
        $sid = $request->post('sid');
        $cities = DB::table('cities')->where('state_id', $sid)->orderBy('name', 'asc')->get('*');

        $html = '<option value="">Select State</option>';
        foreach ($cities as $city){
            $html .= '<option value="'.$city->id.'">'.$city->name.'</option>';
        }

        echo $html;
    }
}
