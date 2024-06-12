<?php
namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Param;
use Illuminate\Support\Facades\DB;

class ExcelController extends Controller
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
          $status = "Promocion";
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
    $students = json_decode(json_encode($studentsArray), true);
    return $students;
  }


  public function excelAssist($request)
  {
    $selectedYear = Year::find($request);
    $students = $this->staticCompleteStudentStatus();
    $output = "";

    $output .= "
			<table  border=1 cellpadding=1 cellspacing=1>
				<thead>
        <tr>
        <th colspan='5'>Grado seleccionado: $selectedYear->year</th>
        </tr>
					<tr>
						<th style='background-color: #069; color: white; width: 100px;'>DNI</th>
						<th style='background-color: #069; color: white; width: 200px;'>Nombre</th>
						<th style='background-color: #069; color: white; width: 100px;'>Apellido</th>
            <th style='background-color: #069; color: white; width: 100px;'>Cantidad de Asistencias</th>
            <th style='background-color: #069; color: white; width: 100px;'>Condicion</th>
					</tr>
				<tbody>
		";
    if (empty($students)) {
      $msg = "No hay estudiantes de este grado con asistencias";
      $output .= "<tr> 
        <td colspan=7 style='font-size: 20px; color: red; '>" . $msg . "</td>
      </tr>";

    } else {
      foreach ($students as $eachStudent) {
        if (($selectedYear->id == $eachStudent["year_id"])) {
          $output .= "
					<tr>
			<td>" . $eachStudent['dni_student'] . "</td>
      <td>" . $eachStudent['name'] . "</td>
      <td>" . $eachStudent['last_name'] . "</td>
      <td>" . $eachStudent['assists_count'] . "</td>
      <td>" . $eachStudent[0]['status'] . "</td>
					</tr>
		";
        }
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