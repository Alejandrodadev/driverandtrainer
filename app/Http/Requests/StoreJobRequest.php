<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
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
            
            // Expenses files (arrays for multiple upload)
            'expense_fuel'       => ['nullable', 'array', 'max:10'], // Max 10 files per category
            'expense_fuel.*'     => ['file', 'extensions:jpg,jpeg,png,pdf', 'max:10000'],
            'expense_food'       => ['nullable', 'array', 'max:10'],
            'expense_food.*'     => ['file', 'extensions:jpg,jpeg,png,pdf', 'max:10000'],
            'expense_promoter'   => ['nullable', 'array', 'max:10'],
            'expense_promoter.*' => ['file', 'extensions:jpg,jpeg,png,pdf', 'max:10000'],
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
            'expense_fuel.*' => 'Gasoil',
            'expense_food' => 'Comida',
            'expense_food.*' => 'Comida',
            'expense_promoter' => 'Promotora',
            'expense_promoter.*' => 'Promotora',
        ];
    }
}
