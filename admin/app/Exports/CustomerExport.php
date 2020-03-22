<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Customer;

use Maatwebsite\Excel\Concerns\WithMapping;
class CustomerExport implements FromArray, WithHeadings,WithMapping
{
    protected $customer;

    public function __construct(array $customer)
    {
        $this->customer = $customer;
    }

    public function headings(): array
    {
        return [
            'Nombre y Apellido',
            'Tipo Doc',
            'Nro Doc',
            'Email',
            'Estado',
        ];
    }

    public function array(): array
    {

        return $this->customer;
    }

    public function map($customer): array
    {
        return [
            $customer->name. " " . $customer->lastname,
            $customer->typeDocument,
            $customer->document,
            $customer->email,
            $customer->status
        ];
    }
}
