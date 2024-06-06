<?php

namespace App\Http\Controllers;

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
    $getAllAssists = DB::table('assists')
      ->join('students', 'assists.student_id', '=', 'students.id')
      ->join('years', 'students.year_id', '=', 'years.id')
      ->select(DB::raw('count(*) as assist_count,students.id,students.name,students.last_name,students.dni_student,years.year,students.group_student,years.id'))
      ->groupBy('students.id')
      ->orderBy('years.id','asc')
      ->orderBy('students.group_student','asc')
      ->get();

    $params = Param::all();

    $students = json_decode(json_encode($getAllAssists), true);
    $completeStudent = [];
    foreach ($students as $eachStudent) {
      $assistCount = $eachStudent["assist_count"];
      $arrayRow = $eachStudent;
      $calculate = intval($assistCount) / ($params[0]->total_classes) * 100;
      $status = 'undefined';
      if ($assistCount > 0) {
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
      $arrayRow["status"] = $status;
      array_push($completeStudent, $arrayRow);
    }
    return $completeStudent;
  }

  public function getYearToPdf($request)
  {
    $students = $this->staticCompleteStudentStatus();
    $og = $students;
    $students = [];
    $multiple = null;
    switch ($request) {
      case '1':
        foreach ($og as $eachStudent) {
          if ($eachStudent["year"] == "Primero") {
            array_push($students, $eachStudent);
          }
        }
        break;
      case '2':
        foreach ($og as $eachStudent) {
          if ($eachStudent["year"] == "Segundo") {
            array_push($students, $eachStudent);
          }
        }
        break;
      case '3':
        foreach ($og as $eachStudent) {
          if ($eachStudent["year"] == "Tercero") {
            array_push($students, $eachStudent);
          }
        }
        break;
      case '4':
        foreach ($og as $eachStudent) {
          if ($eachStudent["year"] == "Cuarto") {
            array_push($students, $eachStudent);
          }
        }
        break;
      case '5':
        foreach ($og as $eachStudent) {
          if ($eachStudent["year"] == "Quinto") {
            array_push($students, $eachStudent);
          }
        }
        break;
      case '6':
        foreach ($og as $eachStudent) {
          if ($eachStudent["year"] == "Sexto") {
            array_push($students, $eachStudent);
          }
        }
        break;
      case '0':
        $students = $og;
        $multiple = true;
        break;
      default:
        $multiple = "No encontrado.";
        break;
    }
    $array = ["multiple" => $multiple, "students" => $students];
    return $array;
  }
  public function pdfAssistGeneral($request)
  {
    $returnedValue = $this->getYearToPdf($request);
    $students = $returnedValue["students"];
    $multiple = $returnedValue["multiple"];
    $pdf = pdf::loadView('pdf.pdf', compact('students', 'multiple'));
    return $pdf->stream();
  }
}
