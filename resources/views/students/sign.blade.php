@extends('layouts.app')
@section('content')
<div class="row justify-content-center mt-3">
  <div class="col-md-9">
    <div class="container">
      @if ($message = Session::get('success'))
      <div class="alert alert-success mt-2" role="alert">
      {{ $message }}
      </div>
    @elseif($message = Session::get('error'))
      <div class="alert alert-danger mt-2" role="alert">
      {{$message}}
      </div>
    @elseif($message = Session::get('info'))
      <div class="alert alert-info mt-2" role="alert">
      {{$message}}
      </div>
    @endif
      <div class="card">
        <div class="card-header">
          <div class="float-start">
            <strong>Coloca el DNI del estudiante en el campo</strong>
          </div>
          <div class="float-end">
            <a href="{{ route('students.index') }}" class="btn btn-primary btn-sm">&larr; Volver</a>
          </div>
        </div>
        <div class="card-body">
          <div class="container">
            <form action="{{route('findThis')}}" method="GET">
              @csrf
              <div class="row align-items-center">
                <div class="col-sm">
                  <input type="number" name="dni_student"
                    class="form-control form-control-sm rounded border border-grey">
                  @if ($errors->has('dni_student'))
            <span class="text-danger">{{ $errors->first('dni_student') }}</span>
          @endif
                </div>
                <div class="col-sm">
                  <input type="submit" value="Buscar" class="form-control btn btn-success m-2">
                </div>
                <div class="col"></div>
                <div class="col"></div>
              </div>
            </form>
          </div>
        </div>
      </div>
      @if ($message = Session::get('status'))
      <div class="alert alert-success mt-2" role="alert">
      {{ $message }}
      </div>
    @endif
      <div class="container">
        @if (isset($student))
        @if(($student->isEmpty()) != true)
        <table class="table table-striped table-bordered">
        <thead>
        <tr>
        <th scope="col"><strong>DNI</strong></th>
        <th scope="col"><strong>Nombre</strong></th>
        <th scope="col"><strong>Apellido</strong></th>
        <th scope="col"><strong>Año</strong></th>
        <th scope="col"><strong>Acción</strong></th>
        </tr>
        </thead>
        <tbody>
        <td>{{$student[0]->dni_student}}</td>
        <td>{{$student[0]->name}}</td>
        <td>{{$student[0]->last_name}}</td>
        <td>{{$student[0]->year->year}}</td>
        @if($bool == true)
      <td>
      <a href="{{route("storeFromButton", $student[0]->dni_student)}}" class="btn btn-success btn-sm m-1"><i
      class="bi bi-pencil-square">Asistir!</i></a>
      <a href="{{route("StudentAssist", $student[0]->id)}}" class="btn btn-primary btn-sm m-1"><i
      class="bi bi-eye">Ver
      Asistencias!</i></a>
      </td>
    @elseif($bool == false)
        <td>
        <button disabled class="btn btn-success btn-sm m-1"><i class="bi bi-pencil-square">Asistir!</i></button>
        <a href="{{route("StudentAssist", $student[0]->id)}}" class="btn btn-primary btn-sm m-1"><i
        class="bi bi-eye">Ver
        Asistencias!</i></a>
        </td>
        @endif

        </tbody>
        </table>
      @else
        <div class="alert alert-danger mt-2" role="alert">
        No se ha encontrado el estudiante
        </div>
      @endif
    @endif
      </div>
    </div>
  </div>
</div>

<div class="row justify-content-center mt-3">
  <div class="col-md-9">
    <div class="container">
      <div class="card">
        <div class="card-header">
          <div class="float-start">
            <strong>O busca por año en la barra desplegable debajo</strong>
          </div>
        </div>
        <div class="card-body">
          <div class="container">
            <form action="{{route('getStudentsPerYear')}}" method="GET">
              @csrf
              <div class="row align-items-center">
                <div class="col-sm">
                  <select name="selectedYear" class="form-control">
                    <option selected value="0">Seleccionar Año</option>
                    @if(isset($years))
            @for ($i = 1; $i <= count($years); $i++)
        <option value="{{ $years[$i]["id"] }}">{{ $years[$i]["year"] }}</option>
      @endfor
          @endif
                  </select>
                </div>
                <div class="col-sm">
                  <input type="submit" value="Filtrar" class="form-control btn btn-success m-2">
                </div>
                <div class="col"></div>
                <div class="col"></div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!--///////////////////////////////////////////////////////////////////////////////-->
      @if(isset($selectedYear))
      <div class="card mt-3">
      <div class="card-header"><strong>Listado de estudiantes de {{$selectedYear[0]->year}} </strong></div>
      <div class="card-body">
        <table class="table table-striped table-bordered">
        <thead>
          <tr>
          <th scope="col">DNI</th>
          <th scope="col">Nombre</th>
          <th scope="col">Apellido</th>
          <th scope="col">Año</th>
          <th scope="col">Accion</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($students as $student)
        <tr>
        <th scope="row">{{ $student[0]["dni_student"] }}</th>
        <td>{{ $student[0]["name"] }}</td>
        <td>{{ $student[0]["last_name"]}}</td>
        <td>{{ $student[0]["year"]->year}}</td>
        <td>
        @if($student[2] == true)
      <a href="{{route("storeFromButton", $student[0]["dni_student"])}}" class="btn btn-success btn-sm m-1"><i
        class="bi bi-pencil-square">Asistir!</i>
    @elseif($student[2] == false)
    <button disabled class="btn btn-success btn-sm m-1"><i
      class="bi bi-pencil-square">Asistir!</i></button>
  @endif
        <a href="{{route("StudentAssist", $student[0]["id"])}}" class="btn btn-primary btn-sm m-1"><i
          class="bi bi-eye">Ver Asistencias!</i></a>
        </td>

        </tr>
      @empty
      <td colspan="6">
      <span class="text-danger">
      <strong>No hay estudiantes registrados!</strong>
      </span>
      </td>
    @endforelse
        </tbody>
        </table>
    @endif
          @endsection