<?php

namespace App\Console\Commands;

use App\Models\FederalEntity;
use App\Models\Municipality;
use App\Models\Settlement;
use App\Models\SettlementType;
use App\Models\ZipCode;
use App\Utilities\CustomTransliterator;
use Illuminate\Console\Command;

class zip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $f = \fopen(storage_path('app/public/CPdescarga.txt'), 'r');
        $array = [];

        $i = 0;
        $transliterator = app()->make(CustomTransliterator::class);

        while ($data = \fgetcsv($f, 0, '|')) {

            $array = $data;

            $i++;

            $zipCode = $array[0];
            $lo = $array[5] == '' ? $array[3]: $array[5];
            $locality =  $transliterator->transliterate($lo);
            $municipio =  $transliterator->transliterate($array[3]);
            $asenta =  $transliterator->transliterate($array[1]);
            $zona =  $transliterator->transliterate($array[13]);
            $tipoAsenta = $array[2];
            $estado =  $transliterator->transliterate($array[4]);
            $keyMunicipio = $array[11];
            $keyFederalEntity = $array[7];
            $keySettle = $array[12];

            print_r("{$i}-{$locality}");
            print_r("\n");

            $municipio = Municipality::firstOrCreate([
                'key' => $keyMunicipio,
                'name' => $municipio,
            ]);

            $federalEntity = FederalEntity::firstOrCreate([
                'key' => $keyFederalEntity,
                'name' => $estado,
            ]);

            $zipCode = ZipCode::updateOrCreate([
                'zip_code' => $zipCode,
                'municipality_id' => $municipio->id,
                'federal_entity_id' => $federalEntity->id,
            ],[
                'locality' => $locality,
            ]);

            $settlementType = SettlementType::firstOrCreate([
                'key' => $i,
                'name' => $tipoAsenta,
            ]);

            Settlement::firstOrCreate([
                'key' => $keySettle,
                'name' => $asenta,
                'zone_type' => $zona,
                'zip_code_id' => $zipCode->id,
                'settlement_type_id' => $settlementType->id
            ]);
        }

        $sc = Settlement::count();
        $stc = SettlementType::count();
        $zc = ZipCode::count();
        $fc = FederalEntity::count();
        $mc = Municipality::count();

        print_r("asentas: {$sc}");
        print_r("tipo asentas: {$stc}");
        print_r("municipios: {$mc}");
        print_r("federal_entities: {$fc}");
        print_r("zcode: {$zc}");
    }
}
