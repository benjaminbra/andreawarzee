<?php

namespace App\Http\Controllers;

use App\Lang;
use App\Profil;
use App\Project;
use App\ProjectImage;
use App\ProjectTranslate;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class Admin extends Controller
{

    private static $maxWidth = 800; // Reverse if image is paysage
    private static $maxHeight = 1300; // Default value if image is portrait

    function __construct(){
        $this->middleware('auth');
    }

    public function index(){

        $projectList = Project::all();
        $projectList = Project::updateProject($projectList);

        return view('admin.home',[
            'projectList' => $projectList,
        ]);
    }

    public function listProject($labelTag){

        $projectList = Project::where('labelTag',$labelTag)->get();
        $projectList = Project::updateProject($projectList);
        $tag = Tag::where('label',$labelTag)->get();

        return view('admin.home',[
            'projectList' => $projectList,
            'category' => $tag,
        ]);
    }

    public function loadType(Request $request){
        $route = 'admin/project/tag';
        if(isset($request->category) && !empty($request->category)){
            $route .= '/'.$request->category;
        }
        return redirect($route);
    }

    public function newProject(){

        return view('admin.project',[
            "project" => "",
            "pT" => "",
            "pI" => "",
        ]);
    }

    public function editProject($id){

        $project = Project::find($id);
        $pImages = ProjectImage::where('idProject',$project->id)
                                    ->orderBy('position','asc')->get();
        $pTranslate = ProjectTranslate::where('idProject',$project->id)->get();

        return view('admin.project',[
            'project' => $project,
            'pT' => $pTranslate,
            'pI' => $pImages,
        ]);
    }

    public function deleteProject($id){

        $images = ProjectImage::where('idProject',$id)->get();
        foreach($images as $image){
            $request = new Request;
            $request->id = $image->id;
            self::deleteImage($request);
        }
        $translates = ProjectTranslate::where('idProject',$id)->get();
        foreach($translates as $translate){
            $translate->delete();
        }
        $project = Project::find($id);
        $project->delete();

        return redirect('/admin');
    }

    public function save(Request $request){
        $langL = Lang::all();
        $project = new Project;
        $returnPath = '/admin/project/tag/'.$request->tag;
        $updateImages = array();

        if(isset($request->id) && !empty($request->id)){
            $project = Project::find($request->id);
            $returnPath = '/admin/project/edit/'.$request->id;
        }
        $project->datePost = TranslationBank::dateTranslate('fr',$request->datePost);
        $project->labelTag = self::checkDifference($project->labelTag, $request->tag);
        $project->save();

        foreach($langL as $lang){
            $projectTranslate = new ProjectTranslate;
            if(isset($request->id) && !empty($request->id)){
                $projectTranslate = ProjectTranslate::where('idProject',$request->id)
                                                        ->where('lang',$lang->label)
                                                        ->get()[0];
            } else {
                $projectTranslate->lang = $lang->label;
                $projectTranslate->idProject = $project->id;
            }
            $projectTranslate->title = $request->title[$lang->label];
            $projectTranslate->description = $request->description[$lang->label];
            $projectTranslate->save();
        }
        if(isset($request->images) && !empty($request->images)){
            foreach($request->images as $image){
                //If no file, then no image to save
                if(isset($image["file"]) && $image["file"] != null){
                  $projectImage = new ProjectImage;
                  $projectImage->type = $image["type"];
                  $projectImage->extension = $image["file"]->extension();
                  $projectImage->idProject = $project->id;
                  $projectImage->position = self::getLastPos($project->id)+1;
                  $projectImage->save();

                  $updateImages[$projectImage->id]['id'] = $projectImage->id;
                  $updateImages[$projectImage->id]['pos'] = $image["position"];

                  $newFileName = $projectImage->id.'.'.$image["file"]->extension();
                  self::uploadImage($image["file"]->path(),$newFileName);
                }
            }
        }
        if(isset($request->imageUpdate) && !empty($request->imageUpdate)){
            $updateImages = array_merge($updateImages,$request->imageUpdate);
        }
        self::updatePosition($updateImages);

        return redirect($returnPath);
    }

    public function deleteImage(Request $request){

        $image = ProjectImage::find($request->id);
        File::delete(self::getImagePath().$image->id.'.'.$image->extension);
        $image->delete();

        return $request->id;
    }

    public function param(){
        $params = Profil::all();

        return view('admin.param',[
            "params" => $params,
        ]);
    }

    public function paramSave(Request $request){
        $params = Profil::all();
        foreach($params as $param){
            $label = $param->label;
            if(isset($request->$label) && !empty($request->$label)){
                if($param->type == "text"){
                    if($param->content != $request->$label){
                        $param->content = $request->$label;
                    }
                } elseif ($param->type == "image"){

                    File::delete($param->content);
                    $file = $request->$label;
                    $name = $param->label.'.'.$file->extension();
                    $param->content = self::getImagePath().$name;
                    self::uploadImage($file->path(),$name,array(150,150));
                }

                $param->save();

            }
        }

        return redirect('/admin/param');
    }

    public function imageOptimizer(){
        $imageList = scandir(self::getImagePath());
        foreach($imageList as $imageName){
            if($imageName!="." && $imageName!=".."){
                $imageExplode = explode('.',$imageName);
                $image = ProjectImage::find($imageExplode[0]);
                if(!isset($image->id) && $imageExplode[0]!="logo"){
                    File::delete(self::getImagePath().$imageName);
                } else {
                    $imageOptimize = Image::make(self::getImagePath().$imageName);
                    if($imageExplode[0]=="logo"){
                        $imageLink = Profil::where('label','logo')->get();
                    } elseif($image->type == "diaporama") {
                        $imageOptimize = self::resizeImage($imageOptimize);
                    } elseif($image->type == "vignette"){
                        $imageOptimize = self::resizeImage($imageOptimize,array(500,500));
                    }

                    $imageOptimize->save();
                }
            }
        }

        return redirect('/admin');
    }

    /*
     * Additional functions for Administration routes
     */

    /**
     * @param $initial
     * @param $new
     * @return mixed
     */
    private static function checkDifference($initial, $new){
        $actual = $initial;
        if($initial != $new){
            $actual = $new;
        }
        return $actual;
    }

    /**
     * @param $projectId
     * @return int
     */
    private static function getLastPos($projectId){
        $image = ProjectImage::where('idProject',$projectId)->get();
        return count($image);
    }

    private static function updatePosition($imageList){
        $sortedList = usort($imageList,function($a,$b){
            return $a["pos"]-$b["pos"];
        });
        $pos = 1;
        foreach($imageList as $image){
            $projectImage = ProjectImage::where('id',$image["id"])->get()[0];
            $projectImage->position = $pos;
            $projectImage->save();
            $pos++;
        }
    }

    /**
     * @return string
     */
    private static function getImagePath(){
        $path = getcwd().'/res/img/';
        if(strtoupper(substr(PHP_OS, 0, 3)) == 'WIN'){
            $path = str_replace('/','\\',$path);
        }
        return $path;
    }

    /**
     * @param $image
     * @param $imageName
     * @param null $size
     */
    private static function uploadImage($image,$imageName,$size = null){
        $newImage = self::resizeImage($image,$size);
        $newImage->save(self::getImagePath().$imageName);
    }

    /**
     * @param $image
     * @param null $size
     * @return mixed
     */
    private static function resizeImage($image,$size = null){
        $imageLoad = Image::make($image);
        $h = $imageLoad->height();
        $w = $imageLoad->width();
        if($h>$w){
            $size = self::newSize($w,$h,$size);
            $imageLoad->resize($size[0],$size[1]);
        } else {
            $size = self::newSize($h,$w,$size);
            $imageLoad->resize($size[1],$size[0]);
        }

        return $imageLoad;

    }

    /**
     * @param $w
     * @param $h
     * @param null $size
     * @return array
     */
    private static function newSize($w,$h,$size = null){
        if($size != null){
            $maxW = $size[0];
            $maxH = $size[1];
        } else {
            $maxW = self::$maxWidth;
            $maxH = self::$maxHeight;
        }
        if($w>$maxW){
            $ratio = $maxW/$w;
            $w = round($w*($ratio));
            $h = round($h*($ratio));
        }
        if($h>$maxH){
            $ratio = $maxW/$w;
            $w = round($w*($ratio));
            $h = round($h*($ratio));
        }

        return array($w,$h);
    }
}
