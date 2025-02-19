<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Structure;
use App\Models\StructureField;
use App\Models\StructurePosition;
use Exception;
use Illuminate\Http\Request;

class UserStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data['structure_ketua_umum'] = Structure::with(['structure_images', 'structure_positions'])->whereHas('structure_positions', function ($query) {
                $query->where('name', 'Ketua Umum');
            })->get();

            $data['structure_ketua_harian'] = Structure::with(['structure_images', 'structure_positions'])->whereHas('structure_positions', function ($query) {
                $query->where('name', 'Ketua Harian');
            })->get();

            $data['structure_sekretaris_and_bendahara'] = Structure::with(['structure_images', 'structure_positions'])
                ->whereHas('structure_positions', function ($query) {
                $query->whereIn('name', ['Sekretaris Umum', 'Wakil Sekretaris', 'Bendahara Umum']);
            })->get();

            $data['structure_ketua_kompartemen'] = Structure::with(['structure_images', 'structure_positions'])
                ->whereHas('structure_positions', function ($query) {
                $query->whereIn('name', ['Ketua I Kompartemen Pembinaan Prestasi', 'Ketua II Kompartemen Organisasi', 'Ketua III Kompartemen Umum']);
            })->get();

            // $data['structure_kepala_bidang'] = Structure::with(['structure_images', 'structure_positions'])->whereHas('structure_positions', function ($query) {
            //     $query->whereIn('name', ['Kepala Bidang Teknis dan Kepelatihan', 'Kepala Bidang Pertandingan dan Perwasitan', 'Kepala Bidang Hukum dan Disiplin', 'Kepala Bidang Hubungan Kelembagaan', 'Kepala Bidang Perencanaan Anggaran dan Sarana', 'Kepala Bidang Humas dan Promosi']);
            // })->get();

            $data['structure_fields'] = StructureField::whereNot('name', 'Pengurus Utama')->get();

            return view('user.structures', $data);
        } catch (Exception $error) {
            dd($error);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function memberFieldStructures(StructureField $structureField)
    {
        try {
            $data['structure_field'] = $structureField->name;
            $data['structure_kepala_bidang'] = Structure::with(['structure_images', 'structure_positions'])->whereHas('structure_positions', function ($query) use ($structureField) {
                $query->where('name', 'Kepala ' . $structureField->name );
            })->get();
            $data['structure_anggota_bidang'] = Structure::with(['structure_images', 'structure_positions'])->whereHas('structure_positions', function ($query) use ($structureField) {
                $query->where('name', 'Anggota ' . $structureField->name );
            })->get();

            return view('user.field_structures', $data);
        } catch (Exception $error) {
            dd($error);
        }
    }
}
