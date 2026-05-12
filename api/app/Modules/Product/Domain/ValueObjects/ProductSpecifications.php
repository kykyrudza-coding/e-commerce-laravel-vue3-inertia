<?php

declare(strict_types=1);

namespace App\Modules\Product\Domain\ValueObjects;

final readonly class ProductSpecifications
{
    public const array FILTERS = [
        'screenSize' => 'screen_size',
        'screenType' => 'screen_type',
        'os' => 'os',
        'processor' => 'processor',
        'ram' => 'ram',
        'storage' => 'storage',
        'cameraResolution' => 'camera_resolution',
        'batteryCapacity' => 'battery_capacity',
        'color' => 'color',
        'condition' => 'condition',
    ];

    public const array LABELS = [
        'screen_size' => 'Screen Size',
        'screen_type' => 'Screen Type',
        'os' => 'OS',
        'processor' => 'Processor',
        'ram' => 'RAM',
        'storage' => 'Storage',
        'camera_resolution' => 'Camera Resolution',
        'battery_capacity' => 'Battery Capacity',
        'color' => 'Color',
        'condition' => 'Condition',
    ];

    public function __construct(
        public array $values,
    ) {}

    public function normalized(): array
    {
        return collect($this->values)
            ->only(array_values(self::FILTERS))
            ->filter(fn ($value): bool => $value !== null && $value !== '')
            ->map(fn ($value): string => (string) $value)
            ->all();
    }
}
