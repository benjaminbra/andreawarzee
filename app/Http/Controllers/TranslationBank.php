<?php

namespace App\Http\Controllers;

use App\Lang;
use App\Profil;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Route;


class TranslationBank extends Controller
{

    /**
     * Return Tag List
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function tagL(){

        $tagList = Tag::all();

        return $tagList;
    }

    /**
     * return Profil Data
     * @param $name
     * @return mixed
     */
    public static function profilD($name){

        $data = Profil::where('label',$name)->get();

        return $data;
    }

    public static function setRoute($lang){
        $route = Route::current();
        $uri = $route->getURI();
        $parameters = $route->parameters();
        $parameters['lang'] = $lang;
        $routeExplode = explode('/',$uri);
        $delimiter = array('{','}');
        $newRoute = "";
        if(count($routeExplode) > 2){
            foreach($routeExplode as $param){
                $realParam = str_replace($delimiter,'',$param);
                if($realParam==$param){
                    $newRoute.= '/'.$realParam;
                } else {
                    foreach($parameters as $key=>$val){
                        if($realParam == $key){
                            $newRoute.= '/'.$val;
                        }
                    }
                }
            }
        } else {
            $newRoute.= '/'.$lang;
        }

        return $newRoute;
    }

    public static function langL(){
        $langList = Lang::all();
        return $langList;
    }

    public static function dateTranslate($origin,$date){
        $newFormat = date('Y-m-d');
        $dSeparator = "";
        $nSep = "";
        switch($origin) {
            case 'en':
                $dSeparator = '-';
                $nSep = '/';
                break;
            case 'fr':
                $dSeparator = '/';
                $nSep = '-';
                break;
        }
        $expD = explode($dSeparator,$date);
        if(count($expD)>=3){
            $newFormat = $expD[2].$nSep.$expD[1].$nSep.$expD[0];
        }

        return $newFormat;
    }
}
