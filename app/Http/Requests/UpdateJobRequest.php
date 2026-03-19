<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('job'));
    }

    public function rules(): array
    {
        return [
            'event_artist' => ['required', 'string', 'max:255'],
            'location'     => ['required', 'string', 'max:255'],
            'van'          => ['required', 'string', 'max:255'],
            'date'         => ['required', 'date'],
            'entry_time'   => ['required', 'date_format:H:i'],
            'exit_time'    => ['required', 'date_format:H:i', 'after:entry_time'],
            
            // Expenses files (only to add new ones if empty before, or replace)
            'expense_fuel'     => ['nullable', 'file', 'extensions:jpg,jpeg,png,pdf', 'max:10000'],
            'expense_food'     => ['nullable', 'file', 'extensions:jpg,jpeg,png,pdf', 'max:10000'],
            'expense_promoter' => ['nullable', 'file', 'extensions:jpg,jpeg,png,pdf', 'max:10000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'event_artist' => 'Evento / Artista',
            'location'     => 'Lugar',
            'van'          => 'Furgoneta',
            'date'         => 'Fecha',
            'entry_time'   => 'Hora de entrada',
            'exit_time'    => 'Hora de salida',
            'expense_fuel' => 'Gasoil',
            'expense_food' => 'Comida',
            'expense_promoter' => 'Promotora',
        ];
    }
}
