<?php

namespace App\Services;

class Translation
{

    /**
     * @param string $key
     * @return string
     */
    public function get(string $key): string
    {
        $translation = \App\Models\Translation::where('key', $key)->where('locale', 'ru')->get();
        return $translation[0]->value ?: $key;
    }

    public function getMenuTypes(): array
    {
        $all = \App\Models\Translation::where('group', 'menu')->where('locale', 'ru')->get();
        $result = [];
        foreach ($all as $text) {
            if (strpos($text->key, '_title') === false) {
                $result[] = $text;
            }
        }

        return $result;
    }

}