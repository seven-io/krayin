<?php

namespace Seven\Krayin\Services;

use Webkul\Core\Models\CoreConfig;
use Webkul\Core\Repositories\CoreConfigRepository;

class Configuration {
    public const KEY = 'seven.settings';

    public function __construct(
        protected CoreConfigRepository $coreConfigRepository
    ) {}

    protected function findOneByField(string $key): mixed {
        $value = self::KEY . '.' . $key;
        $coreConfig = $this->coreConfigRepository->findOneByField('code', $value);

        if ($coreConfig) {
            /** @var CoreConfig $coreConfig */
            return $coreConfig->getAttribute('value');
        }

        return config('services.seven.' . $key);
    }

    public function getApiKey(): ?string {
        return $this->findOneByField('general.api_key');
    }
}
