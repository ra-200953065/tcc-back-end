<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->time('time');
            $table->enum('weather_condition', ['Ensolarado', 'Nublado', 'Chuvoso']);
            $table->decimal('ambient_temperature', 7, 2);

            // substation
            $table->integer('ss_tl_lightning_rod_count_phase_a');
            $table->integer('ss_tl_lightning_rod_count_phase_b');
            $table->integer('ss_tl_lightning_rod_count_phase_c');
            $table->integer('ss_tr_lightning_rod_count_phase_a');
            $table->integer('ss_tr_lightning_rod_count_phase_b');
            $table->integer('ss_tr_lightning_rod_count_phase_c');
            $table->decimal('ss_dj302_gas_pressure', 7, 2);
            $table->integer('ss_dj302_count_operations');
            // transformer
            $table->decimal('tr_oil_temperature', 7, 2);
            $table->decimal('tr_coil_hv_temperature', 7, 2);
            $table->decimal('tr_coil_lv_temperature', 7, 2);
            $table->enum('tr_oil_level', ['Baixo', 'Normal', 'Alto']);
            $table->enum('tr_silica_gel', ['Saturada', 'Normal', 'Ausente']);
            // # Emergency Generator
            $table->decimal('eg_engine_temperature', 7, 2);
            $table->enum('eg_oil_level', ['Baixo', 'Normal', 'Alto']);
            $table->decimal('eg_battery_voltage', 7, 2);
            $table->enum('eg_water_level_radiator', ['Baixo', 'Normal', 'Alto']);
            // Auxiliary Service
            $table->decimal('as_battery_room_temperature', 7, 2);
            $table->decimal('as_battery_room_humidity', 7, 2);
            $table->decimal('as_qdca_consumed_energy', 10, 2);
            // Battery Chargers
            $table->decimal('bc_charger_1_input_voltage', 7, 2);
            $table->decimal('bc_charger_1_input_current', 7, 2);
            $table->decimal('bc_charger_1_output_voltage', 7, 2);
            $table->decimal('bc_charger_1_battery_current', 7, 2);
            $table->decimal('bc_charger_2_input_voltage', 7, 2);
            $table->decimal('bc_charger_2_input_current', 7, 2);
            $table->decimal('bc_charger_2_output_voltage', 7, 2);
            $table->decimal('bc_charger_2_battery_current', 7, 2);
            // Water Supply
            $table->decimal('ws_grid_amount_level', 7, 2);
            $table->decimal('ws_grid_downstream_level', 7, 2);
            $table->decimal('ws_watergate_downstream_level', 7, 2);
            $table->decimal('ws_ug_1_power', 7, 2);
            $table->decimal('ws_ug_2_power', 7, 2);
            // Hydraulic Stations
            $table->enum('hs_uhlm_1', ['Normal', 'Possui vazamentos', 'Fora de operação']);
            $table->enum('hs_uhrv_1', ['Normal', 'Possui vazamentos', 'Fora de operação']);
            $table->enum('hs_uhlm_2', ['Normal', 'Possui vazamentos', 'Fora de operação']);
            $table->enum('hs_uhrv_2', ['Normal', 'Possui vazamentos', 'Fora de operação']);
            $table->enum('hs_compressor_1_oil_level', ['Baixo', 'Normal', 'Alto']);
            $table->enum('hs_compressor_2_oil_level', ['Baixo', 'Normal', 'Alto']);
            // Turbine Seal
            $table->decimal('ts_ug_1_seal_water_pressure', 7, 2);
            $table->decimal('ts_ug_1_auxiliary_water_pressure', 7, 2);
            $table->decimal('ts_ug_1_seal_water_flow', 7, 2);
            $table->decimal('ts_ug_2_seal_water_pressure', 7, 2);
            $table->decimal('ts_ug_2_auxiliary_water_pressure', 7, 2);
            $table->decimal('ts_ug_2_seal_water_flow', 7, 2);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
