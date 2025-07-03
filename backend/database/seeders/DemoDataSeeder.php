<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facultad;
use App\Models\Carrera;
use App\Models\Estudiante;
use App\Models\Curso;
use App\Models\Matricula;
use App\Models\Nota;
use App\Models\Edificio;
use App\Models\Servicio;
use App\Models\ServicioItem;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Desactiva temporalmente las restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncar tablas relacionadas (añadido horarios)
        DB::table('horarios')->truncate();
        DB::table('notas')->truncate();
        DB::table('matriculas')->truncate();
        DB::table('estudiantes')->truncate();

        // Reactiva restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Facultades
        $facultades = [
            ['nombre' => 'Fia'],
            ['nombre' => 'Facied']
        ];
        foreach ($facultades as $facData) {
            Facultad::firstOrCreate(['nombre' => $facData['nombre']]);
        }

        // Carreras
        $carreras = [
            ['facultad_id' => 1, 'nombre' => 'Ing de sistemas', 'codigo_carrera' => 'Ing_sis', 'aula' => 'E201'],
            ['facultad_id' => 1, 'nombre' => 'Administración', 'codigo_carrera' => 'ADM005', 'aula' => 'Aula 202'],
            ['facultad_id' => 2, 'nombre' => 'Educación', 'codigo_carrera' => 'Edu', 'aula' => 'Ubicación GPS'],
            ['facultad_id' => 2, 'nombre' => 'Contabilidad', 'codigo_carrera' => 'CON006', 'aula' => 'Aula 203'],
            ['facultad_id' => 2, 'nombre' => 'Educación Inicial', 'codigo_carrera' => 'EDU007', 'aula' => 'Aula 304'],
            ['facultad_id' => 1, 'nombre' => 'Civil', 'codigo_carrera' => 'Civil', 'aula' => 'Ubicación GPS'],
        ];
        foreach ($carreras as $carData) {
            Carrera::firstOrCreate($carData);
        }

        // Cursos
        $cursos = [
            ['nombre' => 'Matemática 1', 'codigo' => 'MAT101'],
            ['nombre' => 'Programación', 'codigo' => 'PROG100'],
            ['nombre' => 'Contabilidad Básica', 'codigo' => 'CONT101'],
            ['nombre' => 'Gestión Empresarial', 'codigo' => 'GES101'],
            ['nombre' => 'Filosofía', 'codigo' => 'FIL101'],
            ['nombre' => 'Sociología', 'codigo' => 'SOC101'],
        ];
        foreach ($cursos as $curData) {
            Curso::firstOrCreate($curData);
        }

        // Edificios
        $edificios = [
            ['nombre' => 'Edificio A'],
            ['nombre' => 'Edificio B'],
            ['nombre' => 'Edifico C'],
        ];
        foreach ($edificios as $ediData) {
            Edificio::firstOrCreate($ediData);
        }

        // Servicios y sus items
        $servicios = [
            [
                'nombre' => 'Biblioteca',
                'horario' => '8am-8pm',
                'ubicacion_url' => 'https://maps.google.com/?q=-15.461237,-70.14378',
                'items' => ['Préstamo de libros', 'Zona de estudio', 'WiFi', 'Acceso a computadoras']
            ],
            [
                'nombre' => 'Comedor',
                'horario' => '12pm-3pm',
                'ubicacion_url' => 'https://maps.google.com/?q=-15.461389,-70.144639',
                'items' => ['Menú vegetariano', 'Snacks', 'Almuerzo completo']
            ],
            [
                'nombre' => 'Servicios Médicos',
                'horario' => '8am-5pm',
                'ubicacion_url' => 'https://maps.google.com/?q=-15.461233,-70.143799',
                'items' => ['Atención general', 'Primeros auxilios']
            ],
            [
                'nombre' => 'Bienestar Universitario',
                'horario' => '9am-5pm',
                'ubicacion_url' => 'https://maps.google.com/?q=-15.461252,-70.143788',
                'items' => ['Consejería', 'Talleres psicológicos', 'Deportes y recreación']
            ],
        ];

        foreach ($servicios as $srvData) {
            $srv = Servicio::firstOrCreate([
                'nombre' => $srvData['nombre'],
                'horario' => $srvData['horario'],
                'ubicacion_url' => $srvData['ubicacion_url']
            ]);

            foreach ($srvData['items'] as $item) {
                ServicioItem::firstOrCreate([
                    'servicio_id' => $srv->id,
                    'descripcion' => $item,
                ]);
            }
        }

        // Estudiantes
        $aulas = ['E201', 'Aula 202', 'Ubicación GPS', 'Aula 203', 'Aula 304', 'E22', 'E23', 'D183', 'E5e'];
        $edificiosNames = ['Edificio A', 'Edificio B', 'Edifico C'];

        for ($i = 1; $i <= 50; $i++) {
            $carrera = Carrera::inRandomOrder()->first();
            $edificioName = $faker->randomElement($edificiosNames);
            $aula = $faker->randomElement($aulas);

            $estudiante = Estudiante::create([
                'codigo_upeu' => $faker->unique()->numerify('2025####'),
                'dni' => $faker->unique()->numerify('7#######'),
                'nombre' => $faker->name,
                'email' => $faker->safeEmail,
                'telefono' => $faker->numerify('9########'),
                'carrera_id' => $carrera->id,
                'semestre' => $faker->numberBetween(1, 10),
                'aula' => $aula,
                'edificio' => $edificioName,
                'map_url' => 'https://maps.google.com/?q=' . $faker->latitude(-15.47, -15.45) . ',' . $faker->longitude(-70.15, -70.13),
            ]);

            // Matriculas y Notas
            $cursosTomados = Curso::inRandomOrder()->limit(rand(2, 3))->get();
            foreach ($cursosTomados as $curso) {
                Matricula::create([
                    'estudiante_id' => $estudiante->id,
                    'curso_id' => $curso->id,
                    'semestre' => $estudiante->semestre,
                ]);

                Nota::create([
                    'estudiante_id' => $estudiante->id,
                    'curso_id' => $curso->id,
                    'nota' => $faker->numberBetween(10, 20),
                    'creditos' => $faker->numberBetween(2, 5)
                ]);
            }
            // ... Código existente para matriculas y notas

// Horarios para cada estudiante matriculado
$estudiantes = Estudiante::all();
$dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
$horas = ['08:00 - 10:00', '10:00 - 12:00', '14:00 - 16:00', '16:00 - 18:00'];

foreach ($estudiantes as $estudiante) {
    $matriculas = Matricula::where('estudiante_id', $estudiante->id)->get();

    foreach ($matriculas as $matricula) {
        DB::table('horarios')->insert([
            'estudiante_id' => $estudiante->id,
            'curso_id' => $matricula->curso_id,
            'dia' => $faker->randomElement($dias),
            'hora' => $faker->randomElement($horas),
            'profesor' => $faker->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

        }
    }
}
