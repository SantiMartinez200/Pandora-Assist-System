@extends('layouts.app')
@section('content')
<div class="row justify-content-center mt-3">
  <div class="col-md-12">
    <div class="container">
      <div class="card">
        <div class="card-header">Listado de Logueos</div>
        <div class="card-body">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th scope="col">Usuario</th>
                <th scope="col">Accion</th>
                <th scope="col">Movimiento registrado el:</th>
                <th scope="col">IP</th>
                <th scope="col">Navegador</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($logs as $eachLog)
          <tr>
          <td>{{ $eachLog->user_name }}</td>
          <td>{{ $eachLog->action }}</td>
          <td>{{ $eachLog->created_at}}</td>
          <td>{{ $eachLog->ip }}</td>
          <td>{{ $eachLog->browser}}</td>
          </tr>
        @empty
        <td colspan="6">
        <span class="text-danger">
          <strong>No hay Logeos</strong>
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