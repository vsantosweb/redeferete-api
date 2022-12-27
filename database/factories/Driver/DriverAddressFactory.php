<?php

namespace Database\Factories\Driver;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver\DriverAddress>
 */
class DriverAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public $ceps = [
        '71741605',
        '35931011',
        '17039170',
        '73350106',
        '88360009',
        '33113115',
        '90160110',
        '83190000',
        '32145290',
        '28970605',
        '88308030',
        '13058440',
        '18117677',
        '32920000',
        '05801050',
        '03172010',
        '05842070',
        '18190000',
        '15503205',
        '27240560',
        '57246070',
        '76410000',
        '76410000',
        '89075605',
        '13050055',
        '08391509',
        '71681990',
        '81810190',
        '02169190',
        '32185090',
        '42803790',
        '42803790',
        '33170010',
        '18078643',
        '16012500',
        '74303220',
        '04930240',
        '24465620',
        '37716230',
        '72250525',
        '27257825',
        '33145200',
        '82930040',
        '62650000',
        '22733020',
        '57014490',
        '89095400',
        '33200148',
        '60764840',
        '32920000',
        '21240815',
        '11030101',
        '81460365',
        '91340240',
        '38600272',
        '40750380',
        '33170560',
        '75365788',
        '60347365',
        '31630260',
        '88345593',
        '34800000',
        '08490000',
        '07242230',
        '29115625',
        '60744040',
        '61652390',
        '08380012',
        '15025320',
        '35700272',
        '61652390',
        '13059663',
        '86050492',
        '09931493',
        '72025040',
        '18145620',
        '72152112',
        '57072064',
        '25565040',
        '21931615',
        '13158351',
        '57015240',
        '33937130',
        '18540970',
        '18540970',
        '32677698',
        '81490030',
        '13308510',
        '50110643',
        '88200000',
        '13051251',
        '28880000',
        '75534170',
        '11025020',
        '18601772',
        '41253190',
        '14091500',
        '07718140',
        '23064550',
        '06730000',
        '60821130',
        '16013377',
        '88303171',
        '23067552',
        '33880190',
        '38425582',
        '88309052',
        '13050055',
        '32450000',
        '32450000',
        '89266486',
        '05360120',
        '75060150',
        '35701187',
        '08225410',
        '58240344',
        '72650570',
        '54762845',
        '88303171',
        '86709774',
        '86709774',
        '35920000',
        '60320105',
        '05030000',
        '60190120',
        '88058020',
        '85110000',
        '22770360',
        '13067540',
        '42722020',
        '14090092',
        '72542412',
        '23042130',
        '31070022',
        '31360430',
        '31360430',
        '04803130',
        '60865330',
        '57260000',
        '89260740',
        '83409740',
        '86084020',
        '13187110',
        '23028713',
        '06835380',
        '71593622',
        '60763806',
        '14090270',
        '11347620',
        '74959208',
        '72001135',
        '83035250',
        '72746007',
        '32806455',
        '31070380',
        '25545310',
        '23075247',
        '25545310',
        '25545310',
        '72305507',
        '27966620',
        '86360000',
        '72630320',
        '22021010',
        '60326300',
        '08143215',
        '08143215',
        '13344010',
        '17014040',
        '60870120',
        '86073159',
        '09061620',
        '07178350',
        '09061620',
        '89056470',
        '04863200',
        '02982180',
        '60763095',
        '13058433',
        '42803169',
        '06730000',
        '06730000',
        '06774280',
        '61650370',
        '27935320',
        '23587410',
        '61650370',
        '74313670',
        '61650370',
        '81020235',
        '05782370',
        '87053336',
        '60734480',
        '86081542',
        '05846130',
        '09855220',
        '27931027',
        '04476415',
        '18210730',
        '23064260',
        '15042055',
        '57360000',
        '18210730',
        '57073163',
        '75620000',
        '13232570',
        '88340233',
        '60841280',
        '94475500',
        '09971270',
        '09971270',
        '18214715',
        '13322370',
    ];

    public function definition()
    {
        return [
             'address_1'         => fake()->address(),
             'address_2'         => fake()->address(),
             'number'            => mt_rand(1, 9999),
             'zipcode'           => $this->ceps[array_rand($this->ceps)],
             'city'              => fake()->city(),
             'state'             => fake()->state(),
             'formatted_address' => fake()->address(),
             'geolocation'       => fake()->locale(),
         ];
    }
}