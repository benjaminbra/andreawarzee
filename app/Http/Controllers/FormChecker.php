<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class FormChecker extends Controller
{
    public static function value($object,$val,$type="",$typeVal=""){
        $return = "";
        if((!empty($object) && !empty($val)) || $type="date"){
            switch($type){

                case "option":
                    if($object->$val == $typeVal){
                        $return = "selected";
                    }
                    break;

                case "translate":
                    foreach($object as $trnslt){
                        if($trnslt->lang == $typeVal){
                            $return = $trnslt->$val;
                        }
                    }
                    break;

                case "date":
                    if(empty($object) || empty($val)){
                        $return = $typeVal;
                    } else {
                        $return = $object->$val;
                    }
                    break;

                default:
                    $return = $object->$val;
                    break;
            }
        }

        return $return;
    }
}
