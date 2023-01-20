<?php

namespace Database\Seeders;

use App\Models\Rango;
use Illuminate\Database\Seeder;

class RangoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rangos = [
            [
                'name' => 'Socio',
              /*  'ganancia' => '2000',
                'personal' => '10'*/
            ],
            [
                'name' => 'Diamante',
              /*  'ganancia' => '2000',
                'personal' => '10'*/
            ],
            [
                'name' => 'Diamante corona',
                /*  'ganancia' => '2000',
                  'personal' => '10'*/
            ],

            [
                'name' => 'Diamante embajador',
                /*  'ganancia' => '2000',
                  'personal' => '10'*/
  
            ],
            [
                'name' => 'Diamante Imperial',
                /*  'ganancia' => '2000',
                  'personal' => '10'*/
  
            ],


        ];

        foreach ($rangos as $rango) {
            $category = Rango::create($rango);

        }

    }
}
