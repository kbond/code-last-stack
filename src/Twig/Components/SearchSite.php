<?php

namespace App\Twig\Components;

use App\Entity\Voyage;
use App\Repository\VoyageRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class SearchSite
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(private VoyageRepository $voyageRepository)
    {
    }

    /**
     * @return Voyage[]
     */
    public function voyages(): array
    {
        if (!$this->query) {
            return [];
        }

        return $this->voyageRepository->findBySearch($this->query, [], 10);
    }
}
