<?php

namespace App\Utilities;

use Transliterator;

class CustomTransliterator{

    private $transliterator;

    public function __construct() {
        $this->transliterator = Transliterator::createFromRules(':: NFD; :: [:Nonspacing Mark:] Remove; :: NFC;', Transliterator::FORWARD);
    }

    public function transliterate(string $value): string
    {
        return $this->transliterator->transliterate($value);
    }
}
