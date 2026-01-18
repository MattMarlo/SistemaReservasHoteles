@extends('layouts.main')

@section('titulo', 'Huespedes')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Habitaciones</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
        <li class="breadcrumb-item active">Habitaciones</li>
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
                <h5 class="card-title mb-1">Administrar Habitaciones</h5>
                <p class="text-muted mb-0">Gestiona y administra todos las habitaciones del sistema</p>
              </div>
              <a href="{{route('habitaciones.create')}}" class="btn btn-primary">
                <i class="fa-solid fa-circle-plus me-2"></i> Nueva Habitación
              </a>
            </div>

            <table class="table datatable table-striped table-hover">
              <thead class="table-light">
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-start">Numero</th>
                  <th class="text-start">Tipo</th>
                  <th class="text-start">Precio</th>
                  <th class="text-center">Estado</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($habitaciones as $habitacion)
                <tr>
                  <td class="text-center fw-semibold">{{ $habitacion->id }}</td>
                  <td class="text-start">{{ $habitacion->numero }}</td>
                  <td class="text-start">{{ $habitacion->tipo }}</td>
                  <td class="text-start">{{ $habitacion->precio}}</td>
                  <td class="text-center">{{ $habitacion->estado }}</td>
                  <td class="text-center">
                    <div class="btn-group" role="group">
                      <a href="{{ route('habitaciones.edit', $habitacion->id) }}" class="btn btn-outline-warning btn-sm">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      <form action="{{ route('habitaciones.delete', $habitacion->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este Huesped?')">
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