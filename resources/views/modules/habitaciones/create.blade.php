@extends('layouts.main')

@section('titulo', 'Nueva Habitación')

@section('contenido')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Nueva Habitación</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('habitaciones') }}">Habitaciones</a></li>
                <li class="breadcrumb-item active">Nuevo</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Formulario de Nueva Habitación</h5>

                        {{-- Formulario --}}
                        <form action="{{ route('habitaciones.store') }}" 
                              id="form_habitacion" 
                              method="post" 
                              class="row g-3">
                            @csrf
                            
                            {{-- Número --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text"
                                           class="form-control"
                                           id="numero"
                                           name="numero"
                                           placeholder="Número de habitación">
                                    <label for="numero">Número <span class="text-danger">*</span></label>
                                </div>
                            </div>

                            {{-- Tipo --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="tipo" name="tipo">
                                        <option value="">Seleccione</option>
                                        <option value="Simple">Simple</option>
                                        <option value="Doble">Doble</option>
                                        <option value="Suite">Suite</option>
                                    </select>
                                    <label for="tipo">Tipo <span class="text-danger">*</span></label>
                                </div>
                            </div>

                            {{-- Precio --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number"
                                           step="0.01"
                                           class="form-control"
                                           id="precio"
                                           name="precio"
                                           placeholder="Precio">
                                    <label for="precio">Precio ($) <span class="text-danger">*</span></label>
                                </div>
                            </div>

                            {{-- Estado --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="estado" name="estado">
                                        <option value="Disponible" selected>Disponible</option>
                                        <option value="Ocupada">Ocupada</option>
                                    </select>
                                    <label for="estado">Estado</label>
                                </div>
                            </div>

                            {{-- Botones --}}
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('habitaciones') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i> Guardar Habitación
                                    </button>
                                </div>
                            </div>
                        </form>
                        {{-- Fin Formulario --}}

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
$(document).ready(function () {

    $("#form_habitacion").validate({
        rules: {
            numero: {
                required: true,
                maxlength: 10
            },
            tipo: {
                required: true
            },
            precio: {
                required: true,
                number: true,
                min: 0
            },
            estado: {
                required: true
            }
        },
        messages: {
            numero: {
                required: "Ingrese el número de la habitación",
                maxlength: "Máximo 10 caracteres"
            },
            tipo: {
                required: "Seleccione el tipo de habitación"
            },
            precio: {
                required: "Ingrese el precio",
                number: "Ingrese un valor válido",
                min: "El precio no puede ser negativo"
            },
            estado: {
                required: "Seleccione el estado"
            }
        }
    });

});
</script>

<style>
.invalid-feedback {
    display: block;
}
</style>
@endpush
