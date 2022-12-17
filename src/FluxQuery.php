<?php

namespace CodingDelta\InfluxDB;

class FluxQuery
{
    private string $query;

    public function __construct()
    {
        $this->query = 'from(bucket: "BUCKET")';
    }

    public function bucket($bucket): self
    {
        $this->query = str_replace('BUCKET', $bucket, $this->query) . PHP_EOL;
        return $this;
    }

    public function filter($field, $filter): self
    {
        $this->query .= ' |> filter(fn: (r) => r.' . $field . ' == "' . $filter . '")' . PHP_EOL;
        return $this;
    }

    public function filterOr(array $array): self
    {
        $filters = array_map(function ($item) {
            return 'r.' . $item['field'] . ' == "' . $item['filter'] . '"';
        }, $array);

        $this->query .= ' |> filter(fn: (r) => ' . implode(" or ", $filters) . ')' . PHP_EOL;
        return $this;
    }

    public function filterN($field, $set): self
    {
        foreach ($set as $item) {
            $this->filter($field, $item);
        }
        return $this;
    }

    public function range($start, $stop): self
    {
        $this->query .= ' |> range(start: ' . $start . ', stop: ' . $stop . ')' . PHP_EOL;
        return $this;
    }

    public function aggregateWindow($every, $fn, $createEmpty = false): self
    {
        $this->query .= ' |> aggregateWindow(every: ' . $every . ', fn: ' . $fn . ', createEmpty: ' . ($createEmpty ? 'true' : 'false') . ')' . PHP_EOL;
        return $this;
    }

    public function yield($name): self
    {
        $this->query .= ' |> yield(name: "' . $name . '")' . PHP_EOL;
        return $this;
    }

    public function last(): self
    {
        $this->query .= ' |> last()' . PHP_EOL;
        return $this;
    }

    public function first(): self
    {
        $this->query .= ' |> first()' . PHP_EOL;
        return $this;
    }

    public function mean(): self
    {
        $this->query .= ' |> mean()' . PHP_EOL;
        return $this;
    }

    public function min(): self
    {
        $this->query .= ' |> min()' . PHP_EOL;
        return $this;
    }

    public function max(): self
    {
        $this->query .= ' |> max()' . PHP_EOL;
        return $this;
    }

    public function sum($column): self
    {
        $this->query .= ' |> sum(column: "' . $column . '")' . PHP_EOL;
        return $this;
    }

    public function count(): self
    {
        $this->query .= ' |> count()' . PHP_EOL;
        return $this;
    }

    public function group(array $columns, string $by): self
    {
        $this->query .= ' |> group(columns: ["' . implode(", ", $columns) . '"], mode: "' . $by . '")' . PHP_EOL;
        return $this;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function sort(array $columns, bool $desc = false): self
    {
        $this->query .= ' |> sort(columns: ["' . implode(", ", $columns) . '"], desc: ' . ($desc ? 'true' : 'false') . ')' . PHP_EOL;
        return $this;
    }

    public function __toString(): string
    {
        return preg_replace('/([\r\n\t])/', '', $this->query);
    }
}
