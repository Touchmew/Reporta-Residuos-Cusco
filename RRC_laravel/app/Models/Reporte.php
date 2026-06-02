<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reporte extends Model
{
    protected $table = 'reportes';

    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'titulo',
        'descripcion',
        'categoria',
        'gravedad',
        'estado',
        'direccion',
        'latitud',
        'longitud',
        'distrito',
    ];

    protected $casts = [
        'latitud' => 'float',
        'longitud' => 'float',
        'fecha_reporte' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class, 'reporte_id');
    }

    public function nivelMapa(): string
    {
        if ($this->categoria === 'basura_fuera_horario') {
            return 'conducta';
        }

        return match ($this->gravedad) {
            'grave' => 'critico',
            'moderado' => 'moderado',
            'leve' => 'limpio',
            default => 'moderado',
        };
    }

    public function categoriaLabel(): string
    {
        return match ($this->categoria) {
            'residuos' => 'Residuos Sólidos',
            'desmonte' => 'Desmonte',
            'basura_fuera_horario' => 'Basura fuera de horario',
            'quema_basura' => 'Quema de basura',
            'contaminacion' => 'Contaminación',
            default => ucfirst(str_replace('_', ' ', $this->categoria)),
        };
    }

    public function estadoPerfil(): array
    {
        return match ($this->estado) {
            'pendiente' => ['key' => 'pending', 'label' => 'Pendiente'],
            'en_revision' => ['key' => 'review', 'label' => 'En revisión'],
            'en_proceso' => ['key' => 'review', 'label' => 'En proceso'],
            'resuelto' => ['key' => 'done', 'label' => 'Resuelto'],
            default => ['key' => 'pending', 'label' => ucfirst($this->estado)],
        };
    }

    public function indicadorPerfil(): string
    {
        if ($this->categoria === 'basura_fuera_horario') {
            return 'purple';
        }

        return match ($this->gravedad) {
            'grave' => 'red',
            'moderado' => 'amber',
            'leve' => 'green',
            default => 'amber',
        };
    }

    public function diasActivo(): int
    {
        if (! $this->fecha_reporte) {
            return 0;
        }

        return max(0, Carbon::parse($this->fecha_reporte)->diffInDays(now()));
    }

    public function urgenciaPorcentaje(): int
    {
        return match ($this->gravedad) {
            'grave' => 88,
            'moderado' => 55,
            'leve' => $this->categoria === 'basura_fuera_horario' ? 35 : 15,
            default => 40,
        };
    }

    public function toMapaArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->titulo,
            'direccion' => $this->direccion,
            'nivel' => $this->nivelMapa(),
            'lat' => (float) $this->latitud,
            'lng' => (float) $this->longitud,
            'distancia' => '—',
            'reportes' => ($this->comentarios_count ?? $this->comentarios()->count()) + 1,
        ];
    }

    public function toDetalleArray(): array
    {
        $this->loadMissing(['comentarios.usuario']);

        return [
            'id' => $this->id,
            'nombre' => $this->titulo,
            'sector' => $this->distrito,
            'direccion' => $this->direccion,
            'lat' => (float) $this->latitud,
            'lng' => (float) $this->longitud,
            'nivel' => $this->nivelMapa(),
            'tipo' => $this->categoriaLabel(),
            'reportes' => $this->comentarios->count(),
            'diasActivo' => $this->diasActivo(),
            'urgencia' => $this->urgenciaPorcentaje(),
            'descripcion' => $this->descripcion,
            'ultReportes' => $this->comentarios->map(fn (Comentario $c) => [
                'usuario' => $c->usuario?->nombre ?? 'Ciudadano',
                'tiempo' => Carbon::parse($c->fecha_comentario)->locale('es')->diffForHumans(),
                'texto' => $c->comentario,
                'emoji' => '👤',
            ])->values()->all(),
        ];
    }

    public function toHistorialArray(): array
    {
        $this->loadMissing('usuario');

        return [
            'id' => $this->id,
            'tipo' => $this->categoriaLabel(),
            'severidad' => $this->gravedad,
            'direccion' => $this->direccion,
            'descripcion' => $this->descripcion,
            'fecha_reporte' => $this->fecha_reporte,
            'nombre' => $this->usuario?->nombre ?? 'Anónimo',
            'latitud' => (float) $this->latitud,
            'longitud' => (float) $this->longitud,
            'foto' => null,
        ];
    }
}
