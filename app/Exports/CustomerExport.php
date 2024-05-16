<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Laravel\Scout\Builder as ScoutBuilder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;


class CustomerExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Email Verified At',
            'Phone',
            'Role',
            'Status',
            'Start Date',
            'Expiry Date',
            'Languages',
            'Download'
        ];
    }

    public function query()
    {
        // TODO: Implement query() method.

        return User::query();
    }
}
