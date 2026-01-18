@extends('layouts.main')

@section('titulo', 'Editar País')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Editar País</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('paises') }}">Países</a></li>
        <li class="breadcrumb-item active">Editar</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Editar País</h5>

            <form action="{{ route('paises.update', $item->id_pais) }}" id="form_pais" method="post">
              @csrf
              @method('PUT')
              
              <div class="form-group mb-3">
                <label for="nombre_pais">Nombre del País</label>
                <input required placeholder="Ingrese el nombre del país" class="form-control" type="text" name="nombre_pais" id="nombre_pais" value="{{ $item->nombre_pais }}">
              </div>

              <div class="d-flex gap-2">
                <button class="btn btn-success" type="submit">Actualizar</button>
                <a class="btn btn-outline-danger" href="{{ route('paises') }}">Cancelar</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<script>
$(document).ready(function() {
    $("#form_pais").validate({
        rules: {
            "nombre_pais": {
                required: true,
                maxlength: 50
            }
        },
        messages: {
            "nombre_pais": {
                required: "Ingrese el nombre del país",
                maxlength: "Máximo 50 caracteres"
            }
        }
    });
});
</script>
@endsection