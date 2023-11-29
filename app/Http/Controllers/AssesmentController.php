<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Project;
use App\Models\Question;
use Illuminate\Http\Request;

class AssesmentController extends Controller
{
    public function questionLayout(Request $request) {
        $project = Project::select('projects.name as project_name','packages.*')->join('packages', 'packages.project_id', '=','projects.id')->where('projects.uuid', $request->get('keypro'))->where('packages.uuid', $request->get('keypack'))->first();
        $question = Question::where('package_id',$project->id)->get();
        return view('index', compact('project', 'question'));
    }
    public function projectLCreate(Request $request) {
        $startDate = $request->get('startDate'). " ". $request->get('startTime') . ":00";
        $endDate = $request->get('endDate'). " ". $request->get('endTime') . ":00";
        $data = [
            'name' => $request->get('name'),
            'start_time' => $startDate,
            'end_time'=> $endDate
        ];
        Project::create($data);
        return back();
    }
    public function packageCreate(Request $request) {
        $startDate = $request->get('startDate'). " ". $request->get('startTime') . ":00";
        $endDate = $request->get('endDate'). " ". $request->get('endTime') . ":00";
        $data = [
            'project_id' => $request->get('project_id'),
            'name' => $request->get('name'),
            'start_time' => $startDate,
            'end_time'=> $endDate
        ];
        Package::create($data);
        return back();
    }
    public function soalCreate(Request $request) {
        $value = $request->get('value_'.$request->get('value_multiple'));
        $payload = [
            'question' => $request->get('question'),
            'value_a' => $request->get('value_a'),
            'value_b' => $request->get('value_b'),
            'value_c' => $request->get('value_c'),
            'value_d' => $request->get('value_d'),
            'value_e' => $request->get('value_e'),
            'value_multiple' => $request->get('value_multiple'),
            'value' => $value,
            'package_id' => $request->get('package_id')
        ];
        Question::create($payload);
        return back();
    }
}
