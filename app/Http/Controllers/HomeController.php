<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Lang;
use App\Project;
use App\ProjectImage;
use App\ProjectTranslate;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function indexDefault(){
        return $this->index('fr');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang){
        $projectList = Project::orderBy('datePost','desc')->get();
        $projectList = Project::updateProject($projectList);
        self::langCheck($lang);

        return view('home',[
            'lang' => $lang,
            'projectList' => $projectList,
        ]);
    }

    public function page($lang,$tagLabel){
        $projectList = Project::where('labelTag',$tagLabel)
                                ->orderBy('datePost','desc')->get();
        $projectList = Project::updateProject($projectList);
        $tagList = Tag::where('label',$tagLabel)->get();
        self::langCheck($lang);

        return view('home', [
            'lang' => $lang,
            'projectList' => $projectList,
            'tagList' => $tagList,
        ]);
    }

    public function project($lang,$id){
        self::langCheck($lang);
        self::projectCheck($id);

        $project = Project::where('id',$id)->get();
        $project = Project::updateProject($project);

        return view('project',[
            'lang' => $lang,
            'project' => $project,
        ]);
    }

    public function contact($lang){
        return view('contact',[
            'lang' => $lang,
        ]);
    }

    public function send(Request $request, $lang){

    }

    /*
     * Functions for data treatment
     */

    private static function langCheck($langSearch){
        $langCheck = false;
        $langs = Lang::all();
        foreach($langs as $lang){
            if($lang->label == $langSearch ){
                $langCheck = true;
            }
        }

        if($langCheck == false){
            abort(404,"Not found");
        }
    }

    private static function projectCheck($id){
        $project = Project::find($id);
        if(!isset($project->id) || empty($project->id)){
            abort(404,"Not Found");
        }
    }
}
