<?php

namespace App\Grid;

use App\Entity\Voyage;
use Zenstruck\Collection\Grid\GridBuilder;
use Zenstruck\Collection\Grid\GridDefinition;
use Zenstruck\Collection\Grid\PerPage\FixedPerPage;
use Zenstruck\Collection\Specification\OrderBy;
use Zenstruck\Collection\Symfony\Attributes\ForObject;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
#[ForObject(Voyage::class)]
final class VoyageGridDefinition implements GridDefinition
{
    public function configure(GridBuilder $builder): void
    {
        $builder
            ->addColumn('purpose', searchable: true, sortable: true)
            ->addColumn('leaveAt', sortable: true, defaultSort: OrderBy::ASC)
            ->addColumn('planet', autofilter: true)
        ;

        $builder->perPage = new FixedPerPage(10);
    }
}
