<?php

namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class YearController extends Controller
{
  public function returnToReports(){
    $bag = Year::all();
    $years = [];
    $i = 0;
    foreach ($bag as $year) {
      $i++;
      $years[$i] = ["id" => $year->id, "year" => $year->year];
    }
    return view('informes.index', compact('years'));
  }

  public static function returnToSign()
  {
    $bag = Year::all();
    $years = [];
    $i = 0;
    foreach ($bag as $year) {
      $i++;
      $years[$i] = ["id" => $year->id, "year" => $year->year];
    }
    return view('students.sign', compact('years'));
  }

  public static function returnToSignSecondLap()
  {
    $bag = Year::all();
    $years = [];
    $i = 0;
    foreach ($bag as $year) {
      $i++;
      $years[$i] = ["id" => $year->id, "year" => $year->year];
    }
    return $years;
  }


}
