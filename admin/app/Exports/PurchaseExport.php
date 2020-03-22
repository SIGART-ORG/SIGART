<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Purchase;

use Maatwebsite\Excel\Concerns\WithMapping;
class PurchaseExport implements FromArray, WithHeadings,WithMapping
{
    protected $purchase;

    public function __construct(array $purchase)
    {
        $this->purchase = $purchase;
    }

    public function headings(): array
    {
        return [
            'Tipo comprobanteo',
            'Comprobante',
            'Proveedor',
            'Nro Doc',
            'Fecha de compratado',
            'Fecha de pago',
            'Total',
            'Estado',
        ];
    }

    public function array(): array
    {

        return $this->purchase;
    }

    public function map($purchase): array
    {
        return [
            $purchase->typeVoucher,
            $purchase->document,
            $purchase->provider->name,
            $purchase->provider->document,
            $purchase->issue,
            '---',
            $purchase->subTotal,
            $purchase->statusName
        ];
    }
}