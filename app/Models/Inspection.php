<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'time',
        'weather_condition',
        'ambient_temperature',
        'ss_tl_lightning_rod_count_phase_a',
        'ss_tl_lightning_rod_count_phase_b',
        'ss_tl_lightning_rod_count_phase_c',
        'ss_tr_lightning_rod_count_phase_a',
        'ss_tr_lightning_rod_count_phase_b',
        'ss_tr_lightning_rod_count_phase_c',
        'ss_dj302_gas_pressure',
        'ss_dj302_count_operations',
        'tr_oil_temperature',
        'tr_coil_hv_temperature',
        'tr_coil_lv_temperature',
        'tr_oil_level',
        'tr_silica_gel',
        'eg_engine_temperature',
        'eg_oil_level',
        'eg_battery_voltage',
        'eg_water_level_radiator',
        'as_battery_room_temperature',
        'as_battery_room_humidity',
        'as_qdca_consumed_energy',
        'bc_charger_1_input_voltage',
        'bc_charger_1_input_current',
        'bc_charger_1_output_voltage',
        'bc_charger_1_battery_current',
        'bc_charger_2_input_voltage',
        'bc_charger_2_input_current',
        'bc_charger_2_output_voltage',
        'bc_charger_2_battery_current',
        'ws_grid_amount_level',
        'ws_grid_downstream_level',
        'ws_watergate_downstream_level',
        'ws_ug_1_power',
        'ws_ug_2_power',
        'hs_uhlm_1',
        'hs_uhrv_1',
        'hs_uhlm_2',
        'hs_uhrv_2',
        'hs_compressor_1_oil_level',
        'hs_compressor_2_oil_level',
        'ts_ug_1_seal_water_pressure',
        'ts_ug_1_auxiliary_water_pressure',
        'ts_ug_1_seal_water_flow',
        'ts_ug_2_seal_water_pressure',
        'ts_ug_2_auxiliary_water_pressure',
        'ts_ug_2_seal_water_flow',
    ];

    protected $casts = [
        // 'ambient_temperature' => 'float',
        // 'ss_dj302_gas_pressure' => 'float',
        // 'tr_oil_temperature' => 'float',
        // 'tr_coil_hv_temperature' => 'float',
        // 'tr_coil_lv_temperature' => 'float',
        // 'eg_engine_temperature' => 'float',
        // 'eg_battery_voltage' => 'float',
        // 'as_battery_room_temperature' => 'float',
        // 'as_battery_room_humidity' => 'float',
        // 'as_qdca_consumed_energy' => 'float',
        // 'bc_charger_1_input_voltage' => 'float',
        // 'bc_charger_1_input_current' => 'float',
        // 'bc_charger_1_output_voltage' => 'float',
        // 'bc_charger_1_battery_current' => 'float',
        // 'bc_charger_2_input_voltage' => 'float',
        // 'bc_charger_2_input_current' => 'float',
        // 'bc_charger_2_output_voltage' => 'float',
        // 'bc_charger_2_battery_current' => 'float',
        // 'ws_grid_amount_level' => 'float',
        // 'ws_grid_downstream_level' => 'float',
        // 'ws_watergate_downstream_level' => 'float',
        // 'ws_ug_1_power' => 'float',
        // 'ws_ug_2_power' => 'float',
        // 'ts_ug_1_seal_water_pressure' => 'float',
        // 'ts_ug_1_auxiliary_water_pressure' => 'float',
        // 'ts_ug_1_seal_water_flow' => 'float',
        // 'ts_ug_2_seal_water_pressure' => 'float',
        // 'ts_ug_2_auxiliary_water_pressure' => 'float',
        // 'ts_ug_2_seal_water_flow' => 'float',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Pega o usuário da inspeção
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
