<?php

namespace Tymeshift\PhpTest\Traits;

trait ArrayTrait
{
    /**
     * @param array $array
     * @param array $search_list
     * @return array
     */
    public function search(array $array, array $search_list): array
    {
        $result = [];

        foreach ($array as $value) {
            foreach ($search_list as $k => $v) {
                if (!isset($value[$k]) || $value[$k] != $v)
                {
                    continue 2;
                }
            }
            $result[] = $value;
        }

        return $result;
    }
}
