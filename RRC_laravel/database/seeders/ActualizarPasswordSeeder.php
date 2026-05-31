<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ActualizarPasswordSeeder extends Seeder
{
    public function run(): void
    {
        $usuario = DB::table('usuarios')->where('correo', 'alvaro@reporta.pe')->first();

        if (!$usuario) {
            $this->command->error('❌ No se encontró el usuario alvaro@reporta.pe');
            return;
        }

        $this->command->info('Password actual: ' . $usuario->password);

        // Actualizar siempre para garantizar que el hash sea el correcto
        DB::table('usuarios')
            ->where('correo', 'alvaro@reporta.pe')
            ->update(['password' => Hash::make('Alvaro123#')]);

        $this->command->info('✅ Contraseña actualizada al hash de "Alvaro123#" correctamente.');
    }
}
