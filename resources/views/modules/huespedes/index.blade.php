@extends('layouts.main')

@section('titulo', 'Huespedes')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Huespedes</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
        <li class="breadcrumb-item active">Huespedes</li>
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
                <h5 class="card-title mb-1">Administrar Huespedes</h5>
                <p class="text-muted mb-0">Gestiona y administra todos los huespedes del sistema</p>
              </div>
              <a href="{{route('huespedes.create')}}" class="btn btn-primary">
                <i class="fa-solid fa-circle-plus me-2"></i> Nuevo Huesped
              </a>
            </div>

            <table class="table datatable table-striped table-hover">
              <thead class="table-light">
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-start">Nombre</th>
                  <th class="text-start">Apellido</th>
                  <th class="text-start">Cedula</th>
                  <th class="text-center">Telefono</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($huespedes as $huesped)
                <tr>
                  <td class="text-center fw-semibold">{{ $huesped->id }}</td>
                  <td class="text-start">{{ $huesped->nombre }}</td>
                  <td class="text-start">{{ $huesped->apellido }}</td>
                  <td class="text-start">{{ $huesped->cedula}}</td>
                  <td class="text-center">{{ $huesped->telefono }}</td>
                  <td class="text-center">
                    <div class="btn-group" role="group">
                      <a href="{{ route('huespedes.edit', $huesped->id) }}" class="btn btn-outline-warning btn-sm">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      <form action="{{ route('huespedes.delete', $huesped->id) }}" method="POST" class="d-inline">
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