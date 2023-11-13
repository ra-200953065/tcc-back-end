<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inspection>
 */
class InspectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateStr  = "02-01-2022";
        $dateObj  = strtotime($dateStr);
        static $weekCount = 0;
        $dateObj = date("Y-m-d", strtotime("+$weekCount week", $dateObj));
        $weekCount = $weekCount + 2;

        $time = date('H:i:s', rand(28800, 61200)); // 8:00 - 17:00

        $userIds = DB::table('users')->select('id')->get();
        $userId = fake()->randomElement($userIds)->id;

        static $lightningRodCount = 0;
        $lightningRodCount = $lightningRodCount + (rand(3, 6));

        static $dj302Count = 0;
        $dj302Count = $dj302Count + (rand(0, 2));

        static $qdcaEnergyCount = 100;
        $qdcaEnergyCount = $qdcaEnergyCount + (rand(50, 300));

        $enum1 = ['Ensolarado', 'Nublado', 'Chuvoso'];
        $enum2 = ['Baixo', 'Normal', 'Alto'];
        $enum3 = ['Saturada', 'Normal', 'Ausente'];
        $enum4 = ['Normal', 'Possui vazamentos', 'Fora de operação'];

        return [
            // 'user_id' => rand(1, 5),
            // 'user_id' => rand(DB::table('users')->min('id'), DB::table('users')->max('id')),
            'user_id' => $userId,
            'weather_condition' => $enum1[rand(0, 2)],
            'ambient_temperature' => fake()->randomFloat(2, 10, 38),
            // 'date' => fake()->dateTimeBetween('-2 mounth', now(), null),
            // 'date' => fake()->dateTimeBetween('2023-01-01', '2023-06-30'),
            'date' => $dateObj,
            'time' => $time,
            // 'ss_tl_lightning_rod_count_phase_a' => fake()->numberBetween(20, 500),
            'ss_tl_lightning_rod_count_phase_a' => $lightningRodCount + (rand(0, 3)),
            'ss_tl_lightning_rod_count_phase_b' => $lightningRodCount + (rand(0, 3)),
            'ss_tl_lightning_rod_count_phase_c' => $lightningRodCount + (rand(0, 3)),
            'ss_tr_lightning_rod_count_phase_a' => $lightningRodCount + (rand(0, 3)),
            'ss_tr_lightning_rod_count_phase_b' => $lightningRodCount + (rand(0, 3)),
            'ss_tr_lightning_rod_count_phase_c' => $lightningRodCount + (rand(0, 3)),
            'ss_dj302_gas_pressure' => fake()->randomFloat(2, 1, 7),
            // 'ss_dj302_count_operations' => fake()->numberBetween(20, 500),
            'ss_dj302_count_operations' => $dj302Count,
            'tr_oil_temperature' => fake()->randomFloat(2, 10, 38),
            'tr_coil_hv_temperature' => fake()->randomFloat(2, 10, 38),
            'tr_coil_lv_temperature' => fake()->randomFloat(2, 10, 38),
            'tr_oil_level' => $enum2[rand(0, 2)],
            'tr_silica_gel' => $enum3[rand(0, 2)],
            'eg_engine_temperature' => fake()->randomFloat(2, 10, 38),
            'eg_oil_level' => $enum2[rand(0, 2)],
            'eg_battery_voltage' => fake()->randomFloat(2, 9, 14),
            'eg_water_level_radiator' => $enum2[rand(0, 2)],
            'as_battery_room_temperature' => fake()->randomFloat(2, 10, 38),
            'as_battery_room_humidity' => fake()->randomFloat(2, 40, 100),
            // 'as_qdca_consumed_energy' => fake()->randomFloat(2, 900, 10000),
            'as_qdca_consumed_energy' => $qdcaEnergyCount,
            'bc_charger_1_input_voltage' => fake()->randomFloat(2, 127, 135),
            'bc_charger_1_input_current' => fake()->randomFloat(2, 1, 10),
            'bc_charger_1_output_voltage' => fake()->randomFloat(2, 127, 135),
            'bc_charger_1_battery_current' => fake()->randomFloat(2, 1, 10),
            'bc_charger_2_input_voltage' => fake()->randomFloat(2, 127, 135),
            'bc_charger_2_input_current' => fake()->randomFloat(2, 1, 10),
            'bc_charger_2_output_voltage' => fake()->randomFloat(2, 127, 135),
            'bc_charger_2_battery_current' => fake()->randomFloat(2, 1, 10),
            'ws_grid_amount_level' => fake()->randomFloat(2, 193, 196),
            'ws_grid_downstream_level' => fake()->randomFloat(2, 193, 196),
            'ws_watergate_downstream_level' => fake()->randomFloat(2, 193, 196),
            'ws_ug_1_power' => fake()->randomFloat(2, 0, 7.6),
            'ws_ug_2_power' => fake()->randomFloat(2, 0, 7.6),
            'hs_uhlm_1' => $enum4[rand(0, 2)],
            'hs_uhrv_1' => $enum4[rand(0, 2)],
            'hs_uhlm_2' => $enum4[rand(0, 2)],
            'hs_uhrv_2' => $enum4[rand(0, 2)],
            'hs_compressor_1_oil_level' => $enum2[rand(0, 2)],
            'hs_compressor_2_oil_level' => $enum2[rand(0, 2)],
            'ts_ug_1_seal_water_pressure' => fake()->randomFloat(2, 0, 6.5),
            'ts_ug_1_auxiliary_water_pressure' => fake()->randomFloat(2, 0, 6.5),
            'ts_ug_1_seal_water_flow' => fake()->randomFloat(2, 0, 5.3),
            'ts_ug_2_seal_water_pressure' => fake()->randomFloat(2, 0, 6.5),
            'ts_ug_2_auxiliary_water_pressure' => fake()->randomFloat(2, 0, 6.5),
            'ts_ug_2_seal_water_flow' => fake()->randomFloat(2, 0, 5.3),
            // 'created_at' => now(),
            'created_at' => $dateObj . ' ' . $time,
            // 'updated_at' => now(),
            'updated_at' => $dateObj . ' ' . $time,
        ];
    }
}
