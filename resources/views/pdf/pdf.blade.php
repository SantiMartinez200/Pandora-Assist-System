<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>General</title>
</head>

<style>
  * {
    font-family: sans-serif;
    /* Change your font family */
  }

  .content-table {
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 0.9em;
    min-width: 400px;
    border-radius: 5px 5px 0 0;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    width: 100%;
    text-align: center;
  }

  .content-table thead tr {
    background-color: #1B85B8;
    color: #ffffff;
    text-align: left;
    font-weight: bold;
  }

  .content-table th,
  .content-table td {
    padding: 12px 15px;
  }

  .content-table tbody tr {
    border-bottom: 1px solid #dddddd;
  }

  .content-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
  }

  .content-table tbody tr:last-of-type {
    border-bottom: 2px solid #1B85B8;
  }

  .content-table tbody tr.active-row {
    font-weight: bold;
    color: #1B85B8;
  }

  .big {
    font-size: 1rem;
  }
</style>

<body>
  <div class="container">
    <h3>Informe de Alumnos en base a sus asistencias.</h3>
    <h6>Ciclo lectivo {{date('Y')}}</h6>
    <?php
if (!empty($students)) {
       ?>
    <h6>Curso: <strong class="big"><?php  if ($selectedYear) {
    echo ($selectedYear->year);
  } ?></strong></h6>
    <?php
}
    ?>
    <table class="content-table">
      <thead>
        <tr>
          <th>DNI</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Cantidad de Asistencias</th>
          <th>Condición</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($students as $student)
      <tr>
        @if($selectedYear->id == $student["year_id"])
        <td data-column="dni">{{ $student["dni_student"] }}</td>
        <td data-column="Nombre"> {{ $student["name"] }}</td>
        <td data-column="Apellido">{{ $student["last_name"] }}</td>
        <td data-column="Cantidad de Asistencias">{{ $student["assists_count"]}}</td>
        <td data-column="Condicion">{{ $student[0]["status"] }}</td>
        </tr>
      @endif
    @empty
    <td colspan="6">
      <span class="text-danger">
      <strong>No hay asistencias de alumnos de este año!</strong>
      </span>
    </td>

  @endforelse
      </tbody>
    </table>
  </div>
</body>

</html>