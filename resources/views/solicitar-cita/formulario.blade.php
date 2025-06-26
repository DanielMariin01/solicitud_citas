<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 
  <title>Formulario de Cita</title>
  <style>
    * {
      box-sizing: border-box;
    }
body {
  font-family: Arial, sans-serif;
  background: #f3f7fa;
  margin: 0;
  padding: 40px 20px;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  min-height: 100vh;
}
.form-container {
        background: #FFFFFF;
  padding: 30px;
  border-radius: 10px;
 box-shadow: 0 2px 16px rgba(0,0,0,0.08);
  max-width: 620px;
  width: 100%;
}

h2 {
  margin-bottom: 20px;
  font-size: 22px;
  border-bottom: 1px solid #ccc;
  padding-bottom: 10px;
  text-align: center;
}

form {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  width: 100%;
}

.form-group.half {
  width: 100%; /* Por defecto para móviles */
}

label {
  font-weight: bold;
  margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
input[type="number"],
select {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 16px;
}

.error {
  color: red;
  font-size: 0.85em;
  margin-top: 5px;
}

.form-check {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-top: 10px;
}

.form-check label {
  font-weight: normal;
}

.btn-submit {
  background-color: #8DA3E9; /* Color azul-violeta claro del botón */
  color: #fff; /* El color del texto sigue siendo blanco */
  border: none;
  padding: 12px 20px;
  border-radius: 6px;
  cursor: pointer;
  font-size: 16px;
  margin-top: 10px;
  width: 100%;
  transition: background-color 0.3s ease; /* Añadido para una transición suave al pasar el ratón */
}

.btn-submit:hover {
  background-color: #748FE0; /* Un tono ligeramente más oscuro para el hover */
}

/* --- SECCIÓN CRÍTICA: ESTILOS PARA LA SUBIDA DE ARCHIVOS --- */

.upload-area {
    border: 2px dashed #ccc;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    background-color: #f8f9fa;
    transition: background-color 0.3s ease;
    /* --- ¡IMPORTANTE! PARA POSICIONAR EL INPUT INTERNO --- */
    position: relative; /* Permite que los elementos con position: absolute; dentro de él se posicionen correctamente */
    overflow: hidden; /* Oculta cualquier parte que se salga del contenedor */
}

.upload-area:hover {
    background-color: #e9ecef;
}

.custom-file-label {
    display: inline-block; /* Para que parezca un botón */
    margin-top: 10px;
    padding: 8px 16px;
    background-color: #8DA3E9; /* Color azul-violeta claro del botón "Ingresar" */
    color: white; /* El color del texto sigue siendo blanco */
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease; /* Añadido para una transición suave al pasar el ratón */
    /* --- ¡IMPORTANTE! PARA POSICIONAR EL INPUT INTERNO --- */
    position: relative; /* Permite que el input type="file" (que va DENTRO) se posicione absolutamente */
    overflow: hidden;    /* Oculta el input si se desborda (aunque lo haremos 100%) */
    z-index: 0;          /* Asegura que el label esté "debajo" del input invisible */
}

.custom-file-label:hover {
    background-color: #748FE0; /* Un tono ligeramente más oscuro para el hover, igual que el botón principal */
}


/* --- ¡ESTO ES LO MÁS CRÍTICO! OCULTA Y POSICIONA EL INPUT NATIVO --- */
/* Esta regla aplica solo al input type="file" que está ANIDADO dentro de un .custom-file-label */
.custom-file-label input[type="file"] {
    position: absolute; /* Saca el input del flujo normal del documento */
    top: 0;             /* Lo pega al borde superior de su padre (.custom-file-label) */
    left: 0;            /* Lo pega al borde izquierdo de su padre */
    width: 100%;        /* Lo expande para cubrir todo el ancho del .custom-file-label */
    height: 100%;       /* Lo expande para cubrir toda la altura del .custom-file-label */
    opacity: 0;         /* ¡LO HACE COMPLETAMENTE INVISIBLE! */
    cursor: pointer;    /* Mantiene el cursor de puntero, indicando que es clicable */
    z-index: 1;         /* ¡Lo coloca POR ENCIMA del contenido visible del .custom-file-label!
                           Así, el clic en tu botón visible golpea el input invisible. */
}

/* Estilo para el span que mostrará el nombre del archivo seleccionado */
.file-name-display {
    display: block;      /* Hace que el span ocupe su propia línea */
    margin-top: 10px;    /* Espacio encima del nombre del archivo */
    font-size: 0.9em;    /* Tamaño de fuente más pequeño */
    color: #555;         /* Color de texto gris */
    word-break: break-all; /* Rompe palabras largas para que quepan */
}

/* --- RESPONSIVE DESIGN --- */
@media (min-width: 768px) {
  .form-group.half {
    width: calc(50% - 10px);
  }
}
/* --- FIN DE CORRECCIONES PARA EL ÁREA DE SUBIDA DE ARCHIVOS --- */

/* ... Tus estilos para media queries, etc. ... */
@media (min-width: 768px) {
  .form-group.half {
    width: calc(50% - 10px);
  }
}
  </style>
</head>
<body>
  <div class="form-container">
        <img src="{{ asset('imagenes/logo.png') }}" alt="Logo" style="display:block; margin:0 auto 20px auto; max-width:160px;">
    <h2>Solicitar Cita</h2>
    <form action="{{ route('solicitar-cita.guardar') }}" method="POST" enctype="multipart/form-data">   
    @csrf
   <div class="form-group half">
    <label for="nombre" class="form-label">Nombre</label>
    <input 
        type="text" 
        name="nombre" 
        id="nombre" 
        placeholder="Ingrese su nombre"
        class="form-control @error('nombre') is-invalid @else @if(old('nombre')) is-valid @endif @enderror" 
        value="{{ old('nombre') }}" 
        required
    >
    @error('nombre')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
        @if(old('nombre'))
            <div class="valid-feedback"></div>
        @endif
    @enderror
</div>

         <div class="form-group half">
    <label for="apellido" class="form-label">Apellido</label>
    <input 
        type="text" 
        name="apellido" 
        id="apellido" 
        placeholder="Ingrese su apellido"
        class="form-control @error('apellido') is-invalid @else @if(old('apellido')) is-valid @endif @enderror" 
        value="{{ old('apellido') }}" 
        required
    >
    @error('apellido')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
        @if(old('apellido'))
            <div class="valid-feedback"></div>
        @endif
    @enderror
</div>

      <div class="form-group half">
        <label for="documentType">Tipo de documento</label>
        <select id="tipo_identificacion" name="tipo_identificacion" class="form-control @error('tipo_identificacion') is-invalid @else @if(old('tipo_identificacion')) is-valid @endif @enderror" required>
          <option value="">Seleccione</option>
          <option value="cc">Cédula</option>
          <option value="ce">Cédula Extranjera</option>
          <option value="ti">Tarjeta de Identidad</option>
        </select>
      </div>

  <div class="form-group half">
    <label for="" class="form-label">Número de documento</label>
    <input 
        type="text" 
        name="numero_identificacion" 
        id="numero_identificacion" 
        placeholder="Ingrese su numero de documento"
        class="form-control @error('numero_identificacion') is-invalid @else @if(old('numero_identificacion')) is-valid @endif @enderror" 
        value="{{ old('numero_identificacion') }}" 
        required
    >
    @error('numero_identificacion')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
        @if(old('numero_identificacion'))
            <div class="valid-feedback"></div>
        @endif
    @enderror
</div>


  <div class="form-group half">
    <label for="" class="form-label">Celular</label>
    <input 
        type="text" 
        name="celular" 
        id="celular" 
        placeholder="Ingrese su numero de celular"
        class="form-control @error('celular') is-invalid @else @if(old('celular')) is-valid @endif @enderror" 
        value="{{ old('celular') }}" 
        required
    >
    @error('celular')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
        @if(old('celular'))
            <div class="valid-feedback"></div>
        @endif
    @enderror
</div>

      <div class="form-group half">
    <label for="correo" class="form-label">Correo</label>
    <input 
        type="text" 
        name="correo" 
        id="correo" 
        placeholder="Ingrese su correo electrónico"
        class="form-control @error('correo') is-invalid @else @if(old('correo')) is-valid @endif @enderror" 
        value="{{ old('correo') }}" 
        required
    >
    @error('correo')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
        @if(old('correo'))
            <div class="valid-feedback"></div>
        @endif
    @enderror
</div>

<div class="form-group half">
    <label for="id_ciudad" class="form-label">Seleccione su ciudad</label>
    <select 
        name="id_ciudad" 
        id="id_ciudad" 
        class="form-select @error('id_ciudad') is-invalid @else @if(old('id_ciudad')) is-valid @endif @enderror" 
        required
    >
        <option value="">-- Seleccione --</option>
        @foreach($ciudades as $ciudad)
            <option value="{{ $ciudad->id_ciudad}}" {{ old('id_ciudad') == $ciudad->id_ciudad ? 'selected' : '' }}>
                {{ $ciudad->nombre }}
            </option>
        @endforeach
    </select>
    @error('id_ciudad')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
       
    @enderror
</div>
 

<div class="form-group half">
    <label for="id_eps" class="form-label">Seleccione su EPS</label>
    <select 
        name="id_eps" 
        id="id_eps" 
        class="form-select @error('id_eps') is-invalid @else @if(old('id_eps')) is-valid @endif @enderror" 
        required
    >
        <option value="">-- Seleccione --</option>
        @foreach($eps as $eps)
            <option value="{{ $eps->id_eps}}" {{ old('id_eps') == $ciudad->id_ciudad ? 'selected' : '' }}>
                {{ $eps->nombre }}
            </option>
        @endforeach
    </select>
    @error('id_eps')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
      
    @enderror
</div>

<div class="form-group">
    <label for="id_procedimiento" class="form-label">Procedimiento</label>
    {{-- Asegúrate de que el `id` y `name` sean correctos --}}
    <select 
        name="id_procedimiento" 
        id="id_procedimiento" 
        class="form-select @error('id_procedimiento') is-invalid @else @if(old('id_procedimiento')) is-valid @endif @enderror"
        required
    >
        <option value="">Busque un procedimiento</option>
        {{-- Esta parte es opcional pero útil si hay errores de validación. --}}
        @if(old('id_procedimiento'))
            @php
                // Debes obtener el procedimiento de la base de datos para mostrarlo aquí.
                $procedimientoOld = App\Models\Procedimiento::find(old('id_procedimiento'));
            @endphp
            @if($procedimientoOld)
                <option value="{{ $procedimientoOld->id_procedimiento }}" selected>
                    {{ $procedimientoOld->nombre }}
                </option>
            @endif
        @endif
    </select>
    @error('id_procedimiento')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<div class="form-group">
    <label for="observacion" class="form-label">Observación</label>
    <textarea 
        name="observacion" 
        id="observacion" 
        rows="4"
        placeholder="Ingrese aquí comentarios adicionales"
        class="form-control @error('observacion') is-invalid @else @if(old('observacion')) is-valid @endif @enderror"
    >{{ old('observacion') }}</textarea>
    @error('observacion')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
        @if(old('observacion'))
            <div class="valid-feedback"></div>
        @endif
    @enderror
</div>
@php
    // Define los tipos de archivo aceptados para todos los campos si son los mismos
    $acceptedFileTypes = '.pdf,.jpg';
@endphp

{{-- Campo para HISTORIA CLÍNICA --}}
{{-- Aquí le pasamos 'historia_clinica' como $id y $name --}}
@include('components.component-archivo', [
    'id' => 'historia_clinica', // Se asignará como ID del input y en el 'for' del label
    'name' => 'historia_clinica', // Se asignará como nombre del input (Laravel lo usará para $request->historia_clinica)
    'label' => 'Historia Clínica',
    'helpText' => 'Suba aquí la historia clínica',
    'multiple' => false, // O true, según necesites
    'required' => true,
    'accept' => $acceptedFileTypes,
])

@include('components.component-archivo', [
    'id' => 'autorizacion', // Se asignará como ID del input y en el 'for' del label
    'name' => 'autorizacion', // Se asignará como nombre del input (Laravel lo usará para $request->historia_clinica)
    'label' => 'Autorización',
    'helpText' => 'Suba aquí la autorización',
    'multiple' => false, // O true, según necesites
    'required' => true,
    'accept' => $acceptedFileTypes,
])


@include('components.component-archivo', [
    'id' => 'orden_medica', // Se asignará como ID del input y en el 'for' del label
    'name' => 'orden_medica', // Se asignará como nombre del input (Laravel lo usará para $request->historia_clinica)
    'label' => 'Orden Médica',
    'helpText' => 'Suba aquí la orden médica',
    'multiple' => false, // O true, según necesites
    'required' => true,
    'accept' => $acceptedFileTypes,
])
      <!--<div class="form-group">
        <!--<div class="form-check">
          <!--<input type="checkbox" id="terms" />
          <!--<label for="terms">Acepto términos y condiciones</label>
        <!--</div>
        <!--<div class="error">Debes aceptar antes de continuar.</div>
      <!--</div>--->

      <button type="submit" class="btn-submit">Solicitar Cita</button>
    </form>
  </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
        const URL_BUSCAR_PROCEDIMIENTOS = "{{ route('api.procedimientos.buscar') }}";
    // Este es un ÚNICO bloque que se ejecuta cuando el DOM está listo.
    document.addEventListener('DOMContentLoaded', function() {
        
        // ================================================================
        // 1. Inicialización de Select2 para selectores sin búsqueda AJAX
        // ================================================================
        // Asegúrate de que los IDs coincidan con tu HTML
        $('#id_ciudad').select2();
        $('#id_eps').select2();
        $('#tipo_identificacion').select2(); // Si lo tienes

        // ================================================================
        // 2. Inicialización de Select2 con búsqueda remota (AJAX) para PROCEDIMIENTOS
        // ================================================================
        $('#id_procedimiento').select2({
            placeholder: 'Busque el procedimiento a realizar',
            minimumInputLength: 3, // Comienza a buscar después de 3 caracteres
            language: {
                inputTooShort: function(args) {
                    var remainingChars = args.minimum - args.input.length;
                    return 'Por favor, ingrese ' + remainingChars + ' o más caracteres para buscar.';
                },
                noResults: function() {
                    return 'No se encontraron resultados.';
                },
                searching: function() {
                    return 'Buscando...';
                }
            },
            // ¡Esta es la configuración AJAX que llama a tu controlador!
            ajax: {
                url: URL_BUSCAR_PROCEDIMIENTOS,
                dataType: 'json',
                delay: 250, // Espera 250ms después de que el usuario deja de escribir
                data: function(params) {
                    // Parámetros que se envían al backend
                    return {
                        term: params.term, // El texto que el usuario ha escrito
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    // La respuesta del servidor (la que viste en la imagen) es 'data'.
                    // Select2 espera que el array de resultados esté en una clave llamada 'results'.
                    // Tu servidor devuelve la clave 'procedimientos'.
                    // Aquí hacemos el mapeo.
                    
                    // console.log(data); // Puedes descomentar esto para ver la respuesta en la consola del navegador
                    
                    return {
                        results: data.procedimientos, // Mapea tu array 'procedimientos' a 'results'
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            }
        });
        
        // ================================================================
        // 3. Lógica para mostrar el nombre de los archivos subidos
        // ================================================================
        document.querySelectorAll('.custom-file-label input[type="file"]').forEach(inputElement => {
            inputElement.addEventListener('change', function(event) {
                const inputId = this.id;
                const fileNameDisplay = document.getElementById(`${inputId}-file-name`);

                if (this.files.length > 0) {
                    if (this.multiple) {
                        fileNameDisplay.textContent = Array.from(this.files).map(file => file.name).join(', ');
                    } else {
                        fileNameDisplay.textContent = this.files[0].name;
                    }
                } else {
                    fileNameDisplay.textContent = 'Ningún archivo seleccionado';
                }
            });
        });
    }); // Cierre del ÚNICO listener DOMContentLoaded
</script>
</body>
</html>
