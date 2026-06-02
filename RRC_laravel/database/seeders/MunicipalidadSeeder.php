<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MunicipalidadSeeder extends Seeder
{
    public function run(): void
    {
        // Crea usuario de municipalidad si no existe
        $existe = DB::table('usuarios')->where('correo', 'municipalidad@cusco.pe')->exists();

        if (!$existe) {
            DB::table('usuarios')->insert([
                'nombre'   => 'Municipalidad Cusco',
                'correo'   => 'municipalidad@cusco.pe',
                'password' => Hash::make('Municipalidad123#'),
                'rol'      => 'municipalidad',
            ]);

            $this->command->info('✅ Usuario municipalidad@cusco.pe creado correctamente.');
        } else {
            $this->command->warn('⚠️  El usuario municipalidad@cusco.pe ya existe, no se insertó de nuevo.');
        }
    }
}
