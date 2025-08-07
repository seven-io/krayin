<?php

namespace Seven\Krayin\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Seven\Krayin\Exceptions\UnprocessableEntityTypeException;
use Webkul\Contact\Models\Person;
use Webkul\Contact\Repositories\PersonRepository;

readonly class Personell {
    public function __construct(protected PersonRepository $personRepository) {
    }

    /**
     * @return Person[]
     */
    public function getPersons(Request $request): array {
        $entityType = $request->post('entityType');
        $id = $request->post('id');

        switch ($entityType) {
            case 'persons':
                if ($id) return [$this->personRepository->find($id)];

                /** @var Collection $collection */
                $collection = $this->personRepository->all();
                return $collection->all();
            case 'organizations':
                /** @var Collection $collection */
                $collection = $this->personRepository->findByField('organization_id', $id);
                return $collection->all();
            default:
                throw new UnprocessableEntityTypeException($entityType, $id);
        }
    }
}
