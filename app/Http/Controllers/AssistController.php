<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Assist;
use App\Models\Param;
use App\Models\Student;
use App\Http\Requests\AssistRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\IsEmpty;
use Illuminate\View\View;

class AssistController extends Controller
{
  /*
  Esta función valida si el estudiante ya tiene asistencia para el dia de hoy.
  Retorna un booleano true si no hay asistencia para el dia de hoy, false si ya hay asistencia para el dia de hoy.
  */
  public static function ValidateDate($dni)
  {
    $todayDate = Carbon::now()->toDateString();;
    $todayDate = $todayDate . "%";
    $studentDate = Assist::where('student_dni', '=', $dni)->where('created_at', 'LIKE', $todayDate)->get();
    if ($studentDate->IsEmpty()) {
      return true; //Cargar asistencia.
    } else {
      return false; //No cargar la asistencia
    }
  }

  public function storeFromButton($dni)
  {
    /*
    Esta función Almacena la asistencia del estudiante.
    Además verifica que no haya superado el límite de asistencias.
    */
    $bool = $this->ValidateDate($dni);
    $params = Param::all();
    $assists = Assist::where('student_dni', '=', $dni)->count();
    if($assists < ($params[0]->total_classes)){
      if ($bool == true) {
        $assist = Assist::create(['student_dni' => $dni]);
        return redirect()->back()->withSuccess('Se ha marcado la asistencia del alumno');
      } else {
        return redirect()->back()->with('error', 'Este Estudiante ya ha asistido hoy.');
      }
    }else{
      return redirect()->back()->with('info', 'Este Estudiante alcanzó el limite de asistencias.');
    }
    
  }


}
