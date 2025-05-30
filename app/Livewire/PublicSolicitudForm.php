<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Paciente;
use App\Models\Procedimiento;
use App\Models\Solicitud_Admision;
use App\Enums\SolicitudEstado;
use App\Mail\SolicitudRecibidaMail; // Asegúrate de importar el Mailable

use Illuminate\Support\Facades\Mail;
use Filament\Forms\Concerns\InteractsWithForms; // Para usar los componentes de Filament
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Illuminate\Validation\Rule;

class PublicSolicitudForm extends Component implements HasForms
{
    use InteractsWithForms;

    // Propiedades del formulario (los datos que el usuario ingresa)
    public ?array $data = []; // Contenedor para los datos del formulario de Filament

    // Propiedades para el manejo del estado del formulario y mensajes
    public $formSubmitted = false; // Para mostrar mensaje de éxito
    public $submissionError = false; // Para mostrar mensaje de error

    // Define la estructura del formulario usando los componentes de Filament
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Sección de Datos del Paciente
                TextInput::make('nombre')
                    ->label('Nombre(s)')
                    ->required()
                    ->maxLength(255),
                TextInput::make('apellido')
                    ->label('Apellido(s)')
                    ->required()
                    ->maxLength(255),
                Select::make('tipo_identificacion')
                    ->label('Tipo de Identificación')
                    ->options([
                        'CC' => 'Cédula de Ciudadanía',
                        'TI' => 'Tarjeta de Identidad',
                        'CE' => 'Cédula de Extranjería',
                        'PA' => 'Pasaporte',
                    ])
                    ->required(),
                TextInput::make('numero_identificacion')
                    ->label('Número de Identificación')
                    ->required()
                    ->unique('pacientes', 'numero_identificacion') // Valida que sea único en la tabla 'pacientes'
                    ->maxLength(255),
                //hacer el campo de ciudad con un select que obtenga las ciudades de la base de datos
               Select::make('fk_ciudad')  // Campo para seleccionar la ciudad
                    ->relationship('ciudad', 'nombre')
                    ->required(),
                TextInput::make('correo')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->unique('pacientes', 'correo') // Valida que sea único en la tabla 'pacientes'
                    ->maxLength(255),
             
                
           

                // Sección de Datos de la Solicitud
                Select::make('procedimiento_id')
                    ->label('Procedimiento Solicitado')
                    ->options(Procedimiento::where('activo', true)->pluck('nombre', 'id')) // Obtiene solo procedimientos activos
                    ->required()
                    ->searchable(), // Permite buscar en la lista
                Textarea::make('comentarios_paciente')
                    ->label('Comentarios adicionales (síntomas, historial relevante, etc.)')
                    ->rows(4)
                    ->nullable()
                    ->maxLength(1000),
            ])
            ->statePath('data'); // Indica dónde se guardarán los datos del formulario (en $this->data)
    }

    // Inicializa el formulario al cargar el componente
    public function mount(): void
    {
        $this->form->fill();
    }

    // Método para procesar el envío del formulario
    public function submit()
    {
        try {
            // Validar los datos del formulario
            $validatedData = $this->form->getState();

            // Buscar si el paciente ya existe por identificación o email (manejar duplicados)
            $paciente = Paciente::where('numero_identificacion', $validatedData['numero_identificacion'])
                                ->orWhere('email', $validatedData['email'])
                                ->first();

            // Si el paciente no existe, créalo
            if (!$paciente) {
                $paciente = Paciente::create([
                    'nombre' => $validatedData['nombre'],
                    'apellido' => $validatedData['apellido'],
                    'tipo_identificacion' => $validatedData['tipo_identificacion'],
                    'numero_identificacion' => $validatedData['numero_identificacion'],
                    'email' => $validatedData['email'],
                    'telefono' => $validatedData['telefono'],
                    'fecha_nacimiento' => $validatedData['fecha_nacimiento'],
                    'genero' => $validatedData['genero'],
                    'direccion' => $validatedData['direccion'],
                    'ciudad' => $validatedData['ciudad'],
                    'pais' => $validatedData['pais'],
                ]);
            } else {
                // Si el paciente ya existe, actualiza sus datos (excepto identificación/email que son únicos)
                $paciente->update([
                    'nombre' => $validatedData['nombre'],
                    'apellido' => $validatedData['apellido'],
                    'telefono' => $validatedData['telefono'],
                    'fecha_nacimiento' => $validatedData['fecha_nacimiento'],
                    'genero' => $validatedData['genero'],
                    'direccion' => $validatedData['direccion'],
                    'ciudad' => $validatedData['ciudad'],
                    'pais' => $validatedData['pais'],
                ]);
            }


            // Crear la solicitud de admisión
            $solicitud = Solicitud_Admision::create([
                'paciente_id' => $paciente->id,
                'procedimiento_id' => $validatedData['procedimiento_id'],
                'fecha_solicitud' => now(), // La fecha actual
                'estado' => SolicitudEstado::PENDIENTE_ADMISIONES, // Estado inicial
                'comentarios_paciente' => $validatedData['comentarios_paciente'],
            ]);

            // Enviar correo de confirmación al paciente
            if ($paciente->email) {
                Mail::to($paciente->email)->send(new SolicitudRecibidaMail($solicitud));
                $solicitud->updateQuietly(['notificacion_paciente_enviada' => true]); // Marcar que se envió la notificación
            }

            $this->formSubmitted = true; // Indicar éxito
            $this->form->fill(); // Limpiar el formulario después del envío exitoso

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-throw the validation exception so Filament can display errors
            throw $e;
        } catch (\Exception $e) {
            // Manejar otros errores (conexión DB, correo, etc.)
            $this->submissionError = true;
            \Log::error('Error al enviar solicitud de cita: ' . $e->getMessage());
            // Puedes mostrar un mensaje genérico de error o redirigir
        }
    }

    // Método para renderizar la vista del componente
    public function render()
    {
        return view('livewire.public-solicitud-form');
    }
}