<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ServiceRequestExport implements FromArray, WithHeadings,WithMapping
{
    protected $serviceRequest;

    public function __construct(array $serviceRequest)
    {
        $this->serviceRequest = $serviceRequest;
    }

    public function headings(): array
    {
        return [
            'Solicitud de servicio',
            'Nombre',
            'Envio',
            'Aprobado',
            'Cliente',
            'Nro Document',
            'Cotización',
            'Registro',
            'Aprobación Administración',
            'Aprobación Dirección General',
            'Aprobación Cliente',
            'Servicio',
            'Total',
            'Inicio',
            'Fin',
            'Estado',
        ];
    }

    public function array(): array
    {

        return $this->serviceRequest;
    }

    public function map($serviceRequest): array
    {
        return [
            $serviceRequest->serviceRequest->document,
            $serviceRequest->serviceRequest->name,
            $serviceRequest->serviceRequest->send,
            $serviceRequest->serviceRequest->approved,
            $serviceRequest->customer->name,
            $serviceRequest->customer->document,
            !empty( $serviceRequest->saleQuotation ) ? $serviceRequest->saleQuotation->document : '',
            !empty( $serviceRequest->saleQuotation ) ? $serviceRequest->saleQuotation->created : '',
            !empty( $serviceRequest->saleQuotation ) ? $serviceRequest->saleQuotation->approved_adm : '',
            !empty( $serviceRequest->saleQuotation ) ? $serviceRequest->saleQuotation->approved_dg : '',
            !empty( $serviceRequest->saleQuotation ) ? $serviceRequest->saleQuotation->approved_customer : '',
            !empty( $serviceRequest->service ) ? $serviceRequest->service->document : '',
            !empty( $serviceRequest->service ) ? $serviceRequest->service->total : '',
            !empty( $serviceRequest->service ) ? $serviceRequest->service->start : '',
            !empty( $serviceRequest->service ) ? $serviceRequest->service->end : '',
            !empty( $serviceRequest->service ) ? $serviceRequest->service->status : '',
        ];
    }
}
