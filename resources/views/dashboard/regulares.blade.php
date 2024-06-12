@extends('layouts.app')
  @section('content')
<div class="row justify-content-center mt-3">
    <div class="col-md-12">
      <div class="container">
        <div class="card">
            <div class="card-header"><strong>Alumnos Regulares</strong>
          <div class="float-end">
            <a href="{{ route('/dashboard') }}" class="btn btn-primary btn-sm">&larr; Volver</a>
          </div>
        </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">Id del estudiante</th>
                        <th scope="col">DNI del estudiante</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Año</th>
                        <th scope="col">Cantidad de asistencias</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($results as $row)
                <tr>
                  <td>{{ $row->id }}</td>
                  <td>{{ $row->dni_student }}</td>
                  <td>{{ $row->name }}</td>
                  <td>{{ $row->last_name }}</td>
                  <td>{{ $row->year->year }}</td> <!--El primer ->year es la relacion, el segundo ->year el nombre del año.-->
                  <td>{{$row->assists_count}}</td>
                </tr>
            @empty
                            <td colspan="6">
                                <span class="text-danger">
                                    <strong>No hay alumnos regulares!</strong>
                                </span>
                            </td>
                        @endforelse
                    </tbody>
                  </table>
            </div>
        </div>
      </div>
    </div>    
</div>
    
@endsection