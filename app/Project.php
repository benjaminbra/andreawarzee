<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = "project";

    public $timestamps = false;

    public static function updateProject($projectList){

        foreach($projectList as $key=>$project){
            $projectList[$key]->imageList = ProjectImage::where('idProject',$project->id)
                                                            ->orderBy('position','asc')->get();

            $projectList[$key]->content = ProjectTranslate::where('idProject',$project->id)->get();
        }

        return $projectList;
    }
}
