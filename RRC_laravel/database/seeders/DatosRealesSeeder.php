<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatosRealesSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('comentarios')->delete();
        DB::table('evidencias')->delete();
        DB::table('notificaciones')->delete();
        DB::table('reportes')->delete();
        DB::table('usuarios')->delete();

        DB::statement('ALTER TABLE usuarios AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE reportes AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE comentarios AUTO_INCREMENT = 1');

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        DB::table('usuarios')->insert([
            'nombre' => 'Alvaro Abril',
            'correo' => 'alvaro@reporta.pe',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uJa/5Bq/.',
            'telefono' => '984000001',
            'rol' => 'ciudadano',
            'estado' => 'activo',
        ]);

        DB::table('reportes')->insert([
            [
                'usuario_id' => 1,
                'titulo' => 'Acumulación crítica en Mercado Vinocanchón',
                'descripcion' => 'Residuos sólidos acumulados en los exteriores del mercado mayorista. Bolsas, cartones y restos orgánicos bloqueando la vía peatonal y generando malos olores.',
                'categoria' => 'residuos',
                'gravedad' => 'grave',
                'estado' => 'pendiente',
                'direccion' => 'Mercado Vinocanchón, San Jerónimo',
                'latitud' => -13.5437,
                'longitud' => -71.8879,
                'distrito' => 'San Jerónimo',
            ],
            [
                'usuario_id' => 1,
                'titulo' => 'Residuos en Av. La Cultura tramo San Jerónimo',
                'descripcion' => 'Acumulación de desmonte y basura doméstica en la berma de la avenida. Zona de alta circulación vehicular y peatonal afectada.',
                'categoria' => 'desmonte',
                'gravedad' => 'grave',
                'estado' => 'en_revision',
                'direccion' => 'Av. La Cultura, San Jerónimo',
                'latitud' => -13.5450,
                'longitud' => -71.8810,
                'distrito' => 'San Jerónimo',
            ],
            [
                'usuario_id' => 1,
                'titulo' => 'Basura en Plaza San Jerónimo',
                'descripcion' => 'Residuos dispersos alrededor de la plaza principal. Bolsas y envases acumulados cerca de las bancas y jardines.',
                'categoria' => 'residuos',
                'gravedad' => 'moderado',
                'estado' => 'en_proceso',
                'direccion' => 'Plaza Mayor San Jerónimo, C. Lima 410',
                'latitud' => -13.5445,
                'longitud' => -71.8840,
                'distrito' => 'San Jerónimo',
            ],
            [
                'usuario_id' => 1,
                'titulo' => 'Zona limpia - Parque Vecinal San Jerónimo',
                'descripcion' => 'Sector en buen estado de limpieza. Vecinos mantienen el área libre de residuos.',
                'categoria' => 'residuos',
                'gravedad' => 'leve',
                'estado' => 'resuelto',
                'direccion' => 'Zona residencial, San Jerónimo',
                'latitud' => -13.5440,
                'longitud' => -71.8855,
                'distrito' => 'San Jerónimo',
            ],
            [
                'usuario_id' => 1,
                'titulo' => 'Vecino bota basura fuera de horario en Jr. Principal',
                'descripcion' => 'Ciudadano deja bolsas de basura en la vía pública fuera del horario de recolección establecido por la municipalidad.',
                'categoria' => 'basura_fuera_horario',
                'gravedad' => 'leve',
                'estado' => 'pendiente',
                'direccion' => 'Jr. Principal 88, San Jerónimo',
                'latitud' => -13.5448,
                'longitud' => -71.8835,
                'distrito' => 'San Jerónimo',
            ],
        ]);

        DB::table('comentarios')->insert([
            ['reporte_id' => 1, 'usuario_id' => 1, 'comentario' => 'Lo reporté esta mañana, el olor es insoportable desde hace días.'],
            ['reporte_id' => 2, 'usuario_id' => 1, 'comentario' => 'El desmonte lleva más de una semana sin ser recogido.'],
            ['reporte_id' => 3, 'usuario_id' => 1, 'comentario' => 'Acumulación visible desde el domingo pasado.'],
            ['reporte_id' => 4, 'usuario_id' => 1, 'comentario' => 'Zona en buen estado, los vecinos están organizados.'],
            ['reporte_id' => 5, 'usuario_id' => 1, 'comentario' => 'El vecino del Jr. Principal repite esto cada semana.'],
        ]);
    }
}
