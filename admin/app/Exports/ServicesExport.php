<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Service;

use Maatwebsite\Excel\Concerns\WithMapping;
class ServicesExport implements FromArray, WithHeadings,WithMapping
{
    protected $service;

    public function __construct(array $service)
    {
        $this->service = $service;
    }

    public function headings(): array
    {
        return [
            'Servicio',
            'Fecha Inicio',
            'Fecha Fin',
            'Cliente',
            'Monto Total (S/)',
            'Monto Pagado (S/)',
            'Tareas',
            'Estado',
        ];
    }

    public function array(): array
    {

        return $this->service;
    }

    public function map($service): array
    {
        return [
            $service->document,
            $service->start,
            $service->end,
            $service->customer->name,
            $service->total,
            $service->payment,
            $service->tasks->total,
            $service->statusName,
        ];
    }
}