<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Param;
class StudentStatusController extends Controller
{
  public static function getAllAssists()
  {
    $getAllAssists = Student::whereHas('assists')->withCount('assists')->get();
    return $getAllAssists;
  }
  public static function getParams()
  {
    $params = Param::all();
    return $params;
  }
  public function determineRegularized()
  {
    $params = $this->getParams();
    $distinctStudentsAssists = $this->getAllAssists();
    $avgRegularized = [];
    for ($i = 0; $i < count($distinctStudentsAssists); $i++) {
      $calculate = ($distinctStudentsAssists[$i]->assists_count) / ($params[0]->total_classes) * 100;
      if (($calculate >= $params[0]->regular) && ($calculate < $params[0]->promote)) {
        $avgRegularized[$i] = $distinctStudentsAssists[$i];
      }
    }
    return $avgRegularized;
  }
  public function determinePromoted()
  {
    $params = $this->getParams();
    $distinctStudentsAssists = $this->getAllAssists();
    $avgPromoted = [];
    for ($i = 0; $i < count($distinctStudentsAssists); $i++) {
      $calculate = ($distinctStudentsAssists[$i]->assists_count) / ($params[0]->total_classes) * 100;
      if (($calculate >= $params[0]->promote)) {
        $avgPromoted[$i] = $distinctStudentsAssists[$i];
      }
    }
    return $avgPromoted;
  }
  public function determineAuditor()
  {

    $params = $this->getParams();
    $distinctStudentsAssists = $this->getAllAssists();
    $avgAuditor = [];
    for ($i = 0; $i < count($distinctStudentsAssists); $i++) {
      $calculate = ($distinctStudentsAssists[$i]->assists_count) / ($params[0]->total_classes) * 100;
      if (($calculate < $params[0]->regular)) {
        $avgAuditor[$i] = $distinctStudentsAssists[$i];
      }
    }
    return $avgAuditor;
  }
  public function compactPromoted()
  {
    $results = $this->determinePromoted();
    return view('dashboard.aprobados', compact('results'));
  }

  public function compactRegularized()
  {
    $results = $this->determineRegularized();
    return view('dashboard.regulares', compact('results'));
  }

  public function compactAuditors()
  {
    $results = $this->determineAuditor();
    return view('dashboard.libres', compact('results'));
  }

  public function compactAssists()
  {
    $results = $this->getAllAssists();
    return view('dashboard.asistencias', compact('results'));
  }
}