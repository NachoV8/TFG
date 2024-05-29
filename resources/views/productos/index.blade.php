@extends('layouts.layout')

@section('contenido')

    @if(Auth::check() && Auth::user()->rol == 3)

        <div class="admin-productos">

            <h2>Gestión de Productos</h2>

            <a href="{{route('productos.create')}}"><button class="nuevo-producto">Nuevo Producto</button></a>

            <div class="tablas-productos-reservas">
                <div>
                    <h2>Productos</h2>
                    <table>
                        <thead>
                        <tr>
                            <th>Precio</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($productosAll as $producto)
                            <tr>
                                <td>{{ $producto->precio }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->cantidad }}</td>
                                <td>{{ $producto->tipo }}</td>
                                <td class="td-actions">
                                    <div class="left-action">
                                        <a href="{{ route('productos.show', $producto->id_producto) }}"><img src="{{ asset('imagenes/index/lapiz.png') }}" alt="Logo Editar"></a>
                                    </div>
                                    <div class="right-action">
                                        <form action="{{route("productos.destroy", $producto->id_producto)}}" method="POST">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="delete-btn">
                                                <img src="{{ asset('imagenes/index/borrar.png') }}" alt="Eliminar">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div>
                    <h2>Reservas</h2>
                    <table>
                        <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($reservas as $reserva)
                            <tr>
                                <td>{{ $reserva->producto->nombre }}</td>
                                <td>{{ $reserva->cantidad }}</td>
                                <td>{{ $reserva->cantidad * $reserva->producto->precio }}</td>
                                <td>{{ $reserva->usuario->name }}</td>
                                <td class="td-actions">
                                    <div class="left-action">
                                        <a href="{{ route('reservas.show', $reserva->id_reserva) }}"><img src="{{ asset('imagenes/index/lapiz.png') }}" alt="Logo Editar"></a>
                                    </div>
                                    <div class="right-action">
                                        <form action="{{route("reservas.destroy", $reserva->id_reserva)}}" method="POST">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="delete-btn">
                                                <img src="{{ asset('imagenes/index/borrar.png') }}" alt="Eliminar">
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

    @else

        <div class="tienda">
        <div class="filtros">
            <h3>Filtrar por tipo:</h3>

            <div>
                <div class="checkbox-wrapper-33">
                    <label for="pala" class="checkbox">
                        <input class="checkbox__trigger visuallyhidden" type="checkbox" id="pala" name="producto" value="pala"/>
                        <span class="checkbox__symbol">
                    <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 14l8 7L24 7"></path>
                    </svg>
                    </span>
                        <p class="checkbox__textwrapper">Palas</p>
                    </label>
                </div>

                <div class="checkbox-wrapper-33">
                    <label for="pelota" class="checkbox">
                        <input class="checkbox__trigger visuallyhidden" type="checkbox" id="pelota" name="producto" value="pelota"/>
                        <span class="checkbox__symbol">
                    <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 14l8 7L24 7"></path>
                    </svg>
                    </span>
                        <p class="checkbox__textwrapper">Pelotas</p>
                    </label>
                </div>

                <div class="checkbox-wrapper-33">
                    <label for="grip" class="checkbox">
                        <input class="checkbox__trigger visuallyhidden" type="checkbox" id="grip" name="producto" value="grip"/>
                        <span class="checkbox__symbol">
                    <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 14l8 7L24 7"></path>
                    </svg>
                    </span>
                        <p class="checkbox__textwrapper">Grips</p>
                    </label>
                </div>

            </div>
            <div>
                <div class="checkbox-wrapper-33">
                    <label for="cinta" class="checkbox">
                        <input class="checkbox__trigger visuallyhidden" type="checkbox" id="cinta" name="producto" value="cinta"/>
                        <span class="checkbox__symbol">
                    <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 14l8 7L24 7"></path>
                    </svg>
                    </span>
                        <p class="checkbox__textwrapper">Cintas</p>
                    </label>
                </div>

                <div class="checkbox-wrapper-33">
                    <label for="mochila" class="checkbox">
                        <input class="checkbox__trigger visuallyhidden" type="checkbox" id="mochila" name="producto" value="mochila"/>
                        <span class="checkbox__symbol">
                    <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 14l8 7L24 7"></path>
                    </svg>
                    </span>
                        <p class="checkbox__textwrapper">Mochila</p>
                    </label>
                </div>
            </div>

        </div>
        <div class="productos">
            @foreach($productos->chunk(4) as $chunk)
                <div class="productosL">
                    @foreach($chunk as $producto)
                        <div class="producto" data-tipo="{{ $producto->tipo }}">
                            <img src="{{ asset('imagenes/tienda/Pala.png') }}" alt="Dibujo Pala Padel">
                            <h4>{{ $producto->nombre }}</h4>
                            <p>{{ $producto->precio }}€</p>
                            <form action="{{ route('productos.reservar', $producto->id_producto) }}" method="POST">
                                @csrf
                                <label for="cantidad_{{ $producto->id_producto }}"></label>
                                <input type="number" name="cantidad" id="cantidad_{{ $producto->id_producto }}" min="1" max="{{ $producto->cantidad }}">
                                <button type="submit">Reservar</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>


    @endif

    <script>
        // Obtener todos los checkboxes de tipo producto
        const checkboxes = document.querySelectorAll('input[name="producto"]');

        // Agregar un event listener a cada checkbox
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                // Array para almacenar los tipos seleccionados
                const tiposSeleccionados = [];

                // Iterar sobre todos los checkboxes y agregar los tipos seleccionados al array
                checkboxes.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        tiposSeleccionados.push(checkbox.value);
                    }
                });

                // Obtener todos los productos
                const productos = document.querySelectorAll('.producto');

                // Iterar sobre todos los productos y mostrar/ocultar según los tipos seleccionados
                productos.forEach(function(producto) {
                    const tipoProducto = producto.dataset.tipo;

                    if (tiposSeleccionados.length === 0 || tiposSeleccionados.includes(tipoProducto)) {
                        producto.style.display = 'block'; // Mostrar el producto
                    } else {
                        producto.style.display = 'none'; // Ocultar el producto
                    }
                });
            });
        });


        document.addEventListener('DOMContentLoaded', function () {
            @if(session('info'))
            Swal.fire({
                icon: "success",
                html: "<h2 style='text-align: center; color: black'>¡Producto reservado correctamente!</h2>",
                showConfirmButton: false,
                timer: 2000
            });

            @endif
        });
    </script>

@endsection


