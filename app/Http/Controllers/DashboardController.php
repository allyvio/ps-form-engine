<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Project;
use App\Models\Question;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $breadcrumbButton = false;
    public function quisLayout() {
        $breadcrumb1 = 'Dashboard';
        $breadcrumb2 = 'Quiz';
        $button = $this->breadcrumbButton;
        $data = Project::orderBy('id', 'DESC')->get();
        return view('dashboard.quis.create', compact('breadcrumb1', 'breadcrumb2', 'data', 'button'));
    }
    public function editQuisLayout($id) {
        $breadcrumb1 = 'Dashboard';
        $breadcrumb2 = 'Quiz';
        $project = Project::findOrFail($id);
        $package = Package::where('project_id', $project->id)->orderBy('id', 'DESC')->get();
        $button = true;
        $data = [
            'id' => $project->id,
            'name' => $project->name,
            'start_date' => explode(" ",$project->start_time)[0],
            'start_time' => explode(" ",$project->start_time)[1],
            'end_date' => explode(" ",$project->end_time)[0],
            'end_time' => explode(" ",$project->end_time)[1],
        ];
        return view('dashboard.quis.edit', compact('breadcrumb1', 'breadcrumb2', 'data', 'button', 'package'));
    }
    public function editPackageLayout($id) {
        $breadcrumb1 = 'Dashboard';
        $breadcrumb2 = 'Quiz';
        $package = Package::findOrFail($id);
        $question = Question::where('package_id', $package->id)->orderBy('id', 'ASC')->get();
        $button = false;
        $data = [
            'id' => $package->id,
            'name' => $package->name,
            'start_date' => explode(" ",$package->start_time)[0],
            'start_time' => explode(" ",$package->start_time)[1],
            'end_date' => explode(" ",$package->end_time)[0],
            'end_time' => explode(" ",$package->end_time)[1],
        ];
        return view('dashboard.quis.packageDetail', compact('breadcrumb1', 'breadcrumb2', 'data', 'button', 'question'));
    }
}
