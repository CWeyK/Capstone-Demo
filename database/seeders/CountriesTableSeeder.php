<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $namesPath = storage_path() . '/data/country-names.json';
        $namesJson = json_decode(file_get_contents($namesPath), true);

        foreach ($namesJson as $key => $value) {

            DB::table('countries')->insert([
                'name'       => $value,
                'code'       => $key,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        $phonesPath = storage_path() . '/data/country-phone.json';
        $phonesJson = json_decode(file_get_contents($phonesPath), true);

        foreach ($phonesJson as $key => $value) {

            DB::table('countries')
                ->where('code', $key)
                ->update(['dial_code' => $value]);
        }

        //East Malaysia States
        $eastMyrStates = array(
            
            "SBH" => "Sabah",
            "SWK" => "Sarawak",
            
        );

        //West Malaysia States
        $westMyrStates = array(
            "JHR" => "Johor",
            "KDH" => "Kedah",
            "KUL" => "Kuala Lumpur",
            "KTN" => "Kelantan",
            "LBN" => "Labuan",
            "MLK" => "Melaka",
            "NSN" => "Negeri Sembilan",
            "PNG" => "Pulau Pinang",
            "PHG" => "Pahang",
            "PJY" => "Putrajaya",
            "PRK" => "Perak",
            "PLS" => "Perlis",
            "SGR" => "Selangor",
            "TRG" => "Terengganu"
        );

        $eastMalaysiaCountry                 = Country::whereCode('EMY')->firstOrFail();
        $eastMalaysiaCountry->currency       = 'MYR';
        $eastMalaysiaCountry->currency_label = 'RM';
        $eastMalaysiaCountry->conversion_rate = 1;
        $eastMalaysiaCountry->save();

        $westMalaysiaCountry                 = Country::whereCode('WMY')->firstOrFail();
        $westMalaysiaCountry->currency       = 'MYR';
        $westMalaysiaCountry->currency_label = 'RM';
        $westMalaysiaCountry->conversion_rate = 1;
        $westMalaysiaCountry->save();

        $singaporeCountry                  = Country::whereCode('SG')->firstOrFail();
        $singaporeCountry->currency        = 'SGD';
        $singaporeCountry->currency_label  = '$';
        $singaporeCountry->conversion_rate = 0.3;
        $singaporeCountry->save();

        $singaporeCountry                  = Country::whereCode('BN')->firstOrFail();
        $singaporeCountry->currency        = 'BND';
        $singaporeCountry->currency_label  = '$';
        $singaporeCountry->conversion_rate = 0.3;
        $singaporeCountry->save();

        foreach ($eastMyrStates as $key => $value) {

            DB::table("states")->insert([
                "code"       => $key,
                "name"       => $value,
                "country_id" => $eastMalaysiaCountry->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        foreach ($westMyrStates as $key => $value) {

            DB::table("states")->insert([
                "code"       => $key,
                "name"       => $value,
                "country_id" => $westMalaysiaCountry->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
