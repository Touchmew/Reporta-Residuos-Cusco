<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Evita duplicados: solo inserta si el correo no existe
        $existe = DB::table('usuarios')->where('correo', 'alvaro@reporta.pe')->exists();

        if (!$existe) {
            DB::table('usuarios')->insert([
                'nombre'   => 'Alvaro',
                'correo'   => 'alvaro@reporta.pe',
                'password' => Hash::make('Alvaro123#'),
                'rol'      => 'admin',
            ]);

            $this->command->info('✅ Usuario alvaro@reporta.pe creado correctamente.');
        } else {
            $this->command->warn('⚠️  El usuario alvaro@reporta.pe ya existe, no se insertó de nuevo.');
        }
    }
}
