<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'job_function_id',
        'hierarchy_id',
        'apellido',
        'nombre',
        'dni',
        'legajo',
        'cuil_cuit',
        'fecha_nacimiento',
        'grupo_sanguineo',
        'domicilio_actual',
        'telefono',
        'correo_electronico',
        'workplace_id',
        'numero_despacho',
        'fecha_ingreso',
        'situacion_revista',
        'marca_arma',
        'numero_arma',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_ingreso' => 'date',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the job function of the agent.
     */
    public function jobFunction(): BelongsTo
    {
        return $this->belongsTo(JobFunction::class);
    }

    /**
     * Get the hierarchy of the agent.
     */
    public function hierarchy(): BelongsTo
    {
        return $this->belongsTo(Hierarchy::class);
    }

    /**
     * Get the workplace of the agent.
     */
    public function workplace(): BelongsTo
    {
        return $this->belongsTo(Workplace::class);
    }

    /**
     * Scope para filtrar agentes activos.
     */
    public function scopeActive($query)
    {
        return $query->where('situacion_revista', 'Activo');
    }

    /**
     * Scope para buscar por DNI.
     */
    public function scopeByDni($query, $dni)
    {
        return $query->where('dni', $dni);
    }

    /**
     * Scope para buscar por apellido.
     */
    public function scopeByLastName($query, $apellido)
    {
        return $query->where('apellido', 'LIKE', "%{$apellido}%");
    }

    /**
     * Accessor para nombre completo.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->apellido}, {$this->nombre}";
    }
}
