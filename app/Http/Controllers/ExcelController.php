<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Param;
use Illuminate\Support\Facades\DB;

class ExcelController extends Controller
{
  public static function staticCompleteStudentStatus()
  {
    //get assists
    $getAllAssists = DB::table('assists')
      ->join('students', 'assists.student_id', '=', 'students.id')
      ->join('years', 'students.year_id', '=', 'years.id')
      ->select(DB::raw('count(*) as assist_count,students.id,students.name,students.last_name,students.dni_student,years.year,students.group_student,years.id'))
      ->groupBy('students.id')
      ->orderBy('years.id', 'asc')
      ->orderBy('students.group_student', 'asc')
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
          $status = "Promocion";
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
  public function excelAssistGeneral($request)
  {
    $returnedValue = $this->getYearToPdf($request);
    $students = $returnedValue["students"];
    $multiple = $returnedValue["multiple"];

 
    $output = "";

    $output .= "
			<table  border=1 cellpadding=1 cellspacing=1>
				<thead>
					<tr>
						<th style='background-color: #069; color: white; width: 100px;'>DNI</th>
						<th style='background-color: #069; color: white; width: 200px;'>Nombre</th>
						<th style='background-color: #069; color: white; width: 100px;'>Apellido</th>
            <th style='background-color: #069; color: white; width: 100px;'>Grado</th>  
            <th style='background-color: #069; color: white; width: 100px;'>Cantidad de Asistencias</th>
            <th style='background-color: #069; color: white; width: 100px;'>Condicion</th>
					</tr>
				<tbody>
		";
    if(empty($students)){
      $msg = "No hay estudiantes de este grado con asistencias";
      $output .= "<tr> 
        <td colspan=7 style='font-size: 20px; color: red; '>". $msg ."</td>
      </tr>";

    }else{
      foreach ($students as $eachStudent) {

        $output .= "
					<tr>
			<td>" . $eachStudent['dni_student'] . "</td>
      <td>" . $eachStudent['name'] . "</td>
      <td>" . $eachStudent['last_name'] . "</td>
      <td>" . $eachStudent['year'] . "</td>
      <td>" . $eachStudent['assist_count'] . "</td>
      <td>" . $eachStudent['status'] . "</td>
					</tr>
		";
      }
    }
    
    $output .= "
				</tbody>
				
			</table>
		";
    echo $output;
    header("Content-Type: charset=utf-8; application/xls");
    header("Content-Disposition: attachment; filename=planilla_de_asistencias_" . date('Y/m/d') . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");

  }
}
?>