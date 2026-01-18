@extends('layouts.main')

@section('titulo', 'Nuevo Huesped')

@section('contenido')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Nuevo Huesped</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('huespedes') }}">Huespedes</a></li>
                <li class="breadcrumb-item active">Nuevo</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Formulario de Nuevo Huesped</h5>

                        {{-- Formulario --}}
                        <form action="{{ route('huespedes.store') }}" id="form_huesped" method="post" class="row g-3">
                            @csrf
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           placeholder="Ingrese el nombre">
                                    <label for="nombre">Nombre <span class="text-danger">*</span></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="apellido" name="apellido" 
                                           placeholder="Ingrese el apellido">
                                    <label for="apellido">Apellido <span class="text-danger">*</span></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cedula" name="cedula" 
                                           placeholder="Ingrese la cédula">
                                    <label for="cedula">Cédula <span class="text-danger">*</span></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="telefono" name="telefono" 
                                           placeholder="Ingrese el teléfono">
                                    <label for="telefono">Teléfono <span class="text-danger">*</span></label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('huespedes') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i> Guardar Huesped
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
// Sobrescribir la configuración global de validación para este formulario
$(document).ready(function() {
    // Eliminar cualquier validación previa asociada al formulario
    $("#form_huesped").validate().destroy();
    
    // Aplicar validación específica
    $("#form_huesped").validate({
        rules: {
            nombre: {
                required: true,
                maxlength: 30
            },
            apellido: {
                required: true,
                maxlength: 30
            },
            cedula: {
                required: true,
                digits: true,
                minlength: 6,
                maxlength: 20
            },
            telefono: {
                required: true,
                digits: true,
                minlength: 7,
                maxlength: 15
            }
        },
        messages: {
            nombre: {
                required: "Ingrese el nombre del huésped",
                maxlength: "Máximo 30 caracteres"
            },
            apellido: {
                required: "Ingrese el apellido del huésped",
                maxlength: "Máximo 30 caracteres"
            },
            cedula: {
                required: "Ingrese la cédula",
                digits: "Solo se permiten números",
                minlength: "Mínimo 6 dígitos",
                maxlength: "Máximo 20 dígitos"
            },
            telefono: {
                required: "Ingrese el teléfono",
                digits: "Solo se permiten números",
                minlength: "Mínimo 7 dígitos",
                maxlength: "Máximo 15 dígitos"
            }
        },
        
    });
});
</script>

<style>
.invalid-feedback {
    display: block;
}
</style>
@endpush