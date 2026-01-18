@extends('layouts.main')

@section('titulo', 'Huespedes')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Reservas</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
        <li class="breadcrumb-item active">Reservas</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <div>
                <h5 class="card-title mb-1">Administrar Reservas</h5>
                <p class="text-muted mb-0">Gestiona y administra todos las reservas del sistema</p>
              </div>
              <a href="{{route('reservas.create')}}" class="btn btn-primary">
                <i class="fa-solid fa-circle-plus me-2"></i> Nueva Reserva
              </a>
            </div>

            <table class="table datatable table-striped table-hover">
              <thead class="table-light">
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-start">Habitación</th>
                  <th class="text-start">Nombre Huesped</th>
                  <th class="text-start">Apellido Huesped</th>
                  <th class="text-start">Cédula Huesped</th>
                  <th class="text-start">Fecha Entrada</th>
                  <th class="text-center">Fecha Salida</th>
                  <th class="text-center">Estado</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($reservas as $reserva)
                <tr>
                  <td class="text-center fw-semibold">{{ $reserva->id }}</td>
                  <td>{{ $reserva->habitaciones?->numero ?? 'Sin habitación' }}</td>
                  <td>{{ $reserva->huespedes?->nombre ?? 'Sin huésped' }}</td>
                  <td>{{ $reserva->huespedes?->apellido ?? '' }}</td>
                  <td>{{ $reserva->huespedes?->cedula ?? '' }}</td>
                  <td class="text-start">{{ $reserva->fecha_entrada}}</td>
                  <td class="text-center">{{ $reserva->fecha_salida }}</td>
                  <td class="text-center">{{ $reserva->estado }}</td>
                  <td class="text-center">
                    <div class="btn-group" role="group">
                      <a href="{{ route('reservas.edit', $reserva->id) }}" class="btn btn-outline-warning btn-sm">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      <form action="{{ route('reservas.delete', $reserva->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta Reserva?')">
                          <i class="fa-solid fa-trash-can"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection