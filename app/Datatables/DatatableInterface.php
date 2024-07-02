<?php

namespace App\Datatables;

use App\DatatablePresenters\DatatablePresenterInterface;
use Illuminate\Support\Collection;

interface DatatableInterface
{
    public function data(DatatablePresenterInterface $presenter): array;
    public function get(): Collection;
    public function filter(): Collection;
    public function query(): self;
    public function count(): int;
    public function totalCount(): int;
    public function filtering(): self;
    public function queryColumnMapping(string $column): string;
    public function ordering(): self;
    public function paging(): self;
    public static function tableName(): string;
    public static function configs(): array;
    public static function columns(): array;
    public static function includeActionButtons(): bool;
}
