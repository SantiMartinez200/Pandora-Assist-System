<?php

namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Param;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
  public static function staticCompleteStudentStatus()
  {
    //get assists
    $students = Student::whereHas('assists')->withCount('assists')->get();
    $params = Param::all();
    $studentsArray = json_decode(json_encode($students), true);
    $i = 0;
    foreach ($students as $eachStudent) {
      $calculate = $eachStudent->assists_count / ($params[0]->total_classes) * 100;
      $status = 'undefined';
      if ($eachStudent->assists_count > 0) {
        if ($calculate >= $params[0]->promote) {
          $status = "Promoción";
        } elseif (($calculate < $params[0]->promote) && ($calculate >= $params[0]->regular)) {
          $status = "Regular";
        } elseif (($calculate < $params[0]->regular)) {
          $status = "Libre";
        }
      } else {
        $status = "Indefinido";
      }
      array_push($studentsArray[$i], ["status" => $status]);
      $i++;
    }
    $students =json_decode(json_encode($studentsArray), true);
    return $studentsArray;
  }

 
  public function pdfAssist($request)
  {
    $selectedYear = Year::find($request);
    $students = $this->staticCompleteStudentStatus();
    $pdf = pdf::loadView('pdf.pdf', compact('students', 'selectedYear'));
    return $pdf->stream();
  }
}
