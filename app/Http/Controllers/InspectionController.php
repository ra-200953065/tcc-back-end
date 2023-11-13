<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    public function index()
    {
        $inspections = Inspection::all();

        $response = [];

        foreach ($inspections as $inspection) {
            $inspection['user'] = $inspection->user;
            array_push($response, $inspection);
        }

        return response()->json(['inspections' => $response]);
    }

    public function filter(string $userId, string $startDate, string $endDate)
    {
        if ($userId) {
            $inspections = Inspection::where('user_id', $userId)->whereBetween('date', [$startDate, $endDate])->get();
        } else {
            $inspections = Inspection::whereBetween('date', [$startDate, $endDate])->get();
        }

        $response = [];

        foreach ($inspections as $inspection) {
            $inspection['user'] = $inspection->user;
            array_push($response, $inspection);
        }

        return  response()->json(['inspections' => $response]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'weather_condition' => 'required|in:Ensolarado,Nublado,Chuvoso',
            'ambient_temperature' => 'required|numeric|min:-20|max:45',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'ss_tl_lightning_rod_count_phase_a' => 'required|integer|min:0',
            'ss_tl_lightning_rod_count_phase_b' => 'required|integer|min:0',
            'ss_tl_lightning_rod_count_phase_c' => 'required|integer|min:0',
            'ss_tr_lightning_rod_count_phase_a' => 'required|integer|min:0',
            'ss_tr_lightning_rod_count_phase_b' => 'required|integer|min:0',
            'ss_tr_lightning_rod_count_phase_c' => 'required|integer|min:0',
            'ss_dj302_gas_pressure' => 'required|numeric|min:0|max:20',
            'ss_dj302_count_operations' => 'required|integer|min:0',
            'tr_oil_temperature' => 'required|numeric|Min:0|max:80',
            'tr_coil_hv_temperature' => 'required|numeric|Min:0|max:120',
            'tr_coil_lv_temperature' => 'required|numeric|Min:0|max:120',
            'tr_oil_level' => 'required|in:Baixo,Normal,Alto',
            'tr_silica_gel' => 'required|in:Saturada,Normal,Ausente',
            'eg_engine_temperature' => 'required|numeric|min:-20|max:120',
            'eg_oil_level' => 'required|in:Baixo,Normal,Alto',
            'eg_battery_voltage' => 'required|numeric|min:0|max:15',
            'eg_water_level_radiator' => 'required|in:Baixo,Normal,Alto',
            'as_battery_room_temperature' => 'required|numeric|min:0|max:40',
            'as_battery_room_humidity' => 'required|numeric|min:0|max:100',
            'as_qdca_consumed_energy' => 'required|numeric|min:0',
            'bc_charger_1_input_voltage' => 'required|numeric|min:0|max:400',
            'bc_charger_1_input_current' => 'required|numeric|min:0|max:20',
            'bc_charger_1_output_voltage' => 'required|numeric|min:0|max:150',
            'bc_charger_1_battery_current' => 'required|numeric|min:0|max:20',
            'bc_charger_2_input_voltage' => 'required|numeric|min:0|max:400',
            'bc_charger_2_input_current' => 'required|numeric|min:0|max:20',
            'bc_charger_2_output_voltage' => 'required|numeric|min:0|max:150',
            'bc_charger_2_battery_current' => 'required|numeric|min:0|max:20',
            'ws_grid_amount_level' => 'required|numeric|min:190|max:200',
            'ws_grid_downstream_level' => 'required|',
            'ws_watergate_downstream_level' => 'required|numeric|min:190|max:200',
            'ws_ug_1_power' => 'required|numeric|min:0|max:8',
            'ws_ug_2_power' => 'required|numeric|min:0|max:8',
            'hs_uhlm_1' => 'required|in:Normal,Possui vazamentos,Fora de operação',
            'hs_uhrv_1' => 'required|in:Normal,Possui vazamentos,Fora de operação',
            'hs_uhlm_2' => 'required|in:Normal,Possui vazamentos,Fora de operação',
            'hs_uhrv_2' => 'required|in:Normal,Possui vazamentos,Fora de operação',
            'hs_compressor_1_oil_level' => 'required|in:Baixo,Normal,Alto',
            'hs_compressor_2_oil_level' => 'required|in:Baixo,Normal,Alto',
            'ts_ug_1_seal_water_pressure' => 'required|numeric|min:0|max:8',
            'ts_ug_1_auxiliary_water_pressure' => 'required|numeric|min:0|max:8',
            'ts_ug_1_seal_water_flow' => 'required|numeric|min:0|max:50',
            'ts_ug_2_seal_water_pressure' => 'required|numeric|min:0|max:8',
            'ts_ug_2_auxiliary_water_pressure' => 'required|numeric|min:0|max:8',
            'ts_ug_2_seal_water_flow' => 'required|numeric|min:0|max:50',
        ]);

        $inspection = Inspection::create($request->all());

        return response()->json(['inspection' => $inspection], HTTP_CODE_CREATED);
    }

    public function show(string $id)
    {
        $inspection = Inspection::find($id);

        if ($inspection) {
            $response = [
                'inspection' => $inspection,
                'user' => $inspection->user
            ];

            return response()->json($response);
        }

        return response()->json([
            'message' => 'Registro não encontrado.'
        ], HTTP_CODE_NOT_FOUND);
    }

    public function destroy(string $id)
    {
        $inspection = Inspection::find($id);

        if (!$inspection) {
            return response()->json([
                'message' => 'Registro não encontrado.'
            ], HTTP_CODE_NOT_FOUND);
        }

        Inspection::destroy($id);

        return response()->json([
            'message' => 'Registro excluído com sucesso.'
        ], HTTP_CODE_OK);
    }

    public function webView()
    {
        $inspectionsRaw = Inspection::all();

        $inspections = [];

        foreach ($inspectionsRaw as $inspection) {
            $inspection['user'] = $inspection->user;
            array_push($inspections, $inspection);
        }

        return view('inspections', ['inspections' => $inspections]);
    }
}
