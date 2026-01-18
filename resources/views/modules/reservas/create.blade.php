@extends('layouts.main')

@section('titulo', 'Registrar Reserva')

@section('contenido')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Registrar Reserva</h1>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('reservas.store') }}" method="POST" id="formReserva">
                    @csrf

                    <div class="row">

                        {{-- HABITACIÓN --}}
                        <div class="col-md-6 mb-3">
                            <label for="habitaciones_id">Número de Habitación</label>
                            <select class="form-control" name="habitaciones_id" id="habitaciones_id">
                                <option value="">Seleccione un número de habitación</option>
                                @foreach($habitaciones as $habitacion)
                                    <option value="{{ $habitacion->id }}">
                                        {{ $habitacion->numero }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- HUÉSPED --}}
                        <div class="col-md-6 mb-3">
                            <label for="huespedes_id">Huésped (Cédula)</label>
                            <select class="form-control" name="huespedes_id" id="huespedes_id">
                                <option value="">Seleccione un huésped</option>
                                @foreach($huespedes as $huesped)
                                    <option value="{{ $huesped->id }}">
                                        {{ $huesped->cedula }} - {{ $huesped->nombre }} {{ $huesped->apellido }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- FECHA ENTRADA --}}
                        <div class="col-md-6 mb-3">
                            <label for="fecha_entrada">Fecha de Entrada</label>
                            <input type="date" class="form-control" name="fecha_entrada" id="fecha_entrada">
                        </div>

                        {{-- FECHA SALIDA --}}
                        <div class="col-md-6 mb-3">
                            <label for="fecha_salida">Fecha de Salida</label>
                            <input type="date" class="form-control" name="fecha_salida" id="fecha_salida">
                        </div>

                        {{-- ESTADO --}}
                        <div class="col-md-6 mb-3">
                            <label for="estado">Estado de la Reserva</label>
                            <select class="form-control" name="estado" id="estado">
                                <option value="">Seleccione un estado</option>
                                <option value="Activa">Activa</option>
                                <option value="Finalizada">Finalizada</option>
                                <option value="Cancelada">Cancelada</option>
                            </select>
                        </div>

                        {{-- BOTÓN --}}
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                Guardar Reserva
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </section>

</main>
@endsection
@push('scripts')
<script>
$(document).ready(function () {

    $('#formReserva').validate({
        rules: {
            habitaciones_id: {
                required: true
            },
            huespedes_id: {
                required: true
            },
            fecha_entrada: {
                required: true,
                date: true
            },
            fecha_salida: {
                required: true,
                date: true
            },
            estado: {
                required: true
            }
        },
        messages: {
            habitaciones_id: "Seleccione un número de habitación",
            huespedes_id: "Seleccione un huésped",
            fecha_entrada: "Seleccione la fecha de entrada",
            fecha_salida: "Seleccione la fecha de salida",
            estado: "Seleccione el estado de la reserva"
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('text-danger');
            element.closest('.mb-3').append(error);
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        }
    });

});
</script>
@endpush
