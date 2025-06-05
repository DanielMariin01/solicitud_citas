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
background: #5396ED;
background: linear-gradient(270deg,rgba(83, 150, 237, 1) 0%, rgba(195, 221, 227, 1) 53%, rgba(83, 150, 237, 1) 100%);
      margin: 0;
      padding: 40px 20px;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
    }

    .form-container {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      max-width: 550px;
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
      width: 100%;
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
      background-color: #004e5f;
      color: #fff;
      border: none;
      padding: 12px 20px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 10px;
      width: 100%;
    }

    .btn-submit:hover {
      background-color: #00788a;
    }

    /* Responsive para pantallas mayores a 768px */
    @media (min-width: 768px) {
      .form-group.half {
        width: calc(50% - 10px);
      }
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Solicitar Cita</h2>
    <form>
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
    <label for="" class="form-label">Numero de documento</label>
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
        @if(old('id_ciudad'))
            <div class="valid-feedback">¡Se ve bien!</div>
        @endif
    @enderror
</div>
 
      


<div class="form-group">
    <label for="procedimiento" class="form-label">Procedimiento</label>
    <textarea 
        name="procedimiento" 
        id="procedimiento" 
        rows="4"
        placeholder="Ingrese aquí el codigo y el nombre del procedimiento"
        class="form-control @error('procedimiento') is-invalid @else @if(old('procedimiento')) is-valid @endif @enderror" required
    >{{ old('procedimiento') }}</textarea>
    @error('procedimiento')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
        @if(old('procedimiento'))
            <div class="valid-feedback"></div>
        @endif
    @enderror
</div>











      <div class="form-group">
        <div class="form-check">
          <input type="checkbox" id="terms" />
          <label for="terms">Acepto términos y condiciones</label>
        </div>
        <div class="error">Debes aceptar antes de continuar.</div>
      </div>

      <button type="submit" class="btn-submit">Agendar Cita</button>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>
</html>
