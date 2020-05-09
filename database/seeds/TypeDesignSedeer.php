<?php

use App\DesignType;
use Illuminate\Database\Seeder;

class TypeDesignSedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DesignType::create([
            'design_name' => 'Поліграфічний дизайн'
        ]);

        DesignType::create([
            'design_name' => 'Веб дизайн'
        ]);
    }
}
