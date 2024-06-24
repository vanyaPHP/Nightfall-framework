<?php

namespace Nightfall\Fallen\Collection;

/**
 * @template T
 */
interface CollectionInterface
{
    public static function createEmpty(): static;

    public static function fromMap(array $items, callable $fn): static;

    public function reduce(callable $fn, mixed $initial): mixed;

    public function map(callable $fn): array;

    public function each(callable $fn): void;

    public function some(callable $fn): bool;

    public function filter(callable $fn): static;

    /**
     * @return T
     */
    public function first(): mixed;

    /**
     * @return T
     */
    public function last(): mixed;

    public function count(): int;

    public function isEmpty(): bool;

    /**
     * @param T $element
     */
    public function add(mixed $element): void;

    /**
     * @return T[]
     */
    public function values(): array;

    public function items(): array;
}