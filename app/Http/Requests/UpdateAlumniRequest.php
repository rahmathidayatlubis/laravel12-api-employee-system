<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAlumniRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $alumniId = $this->route('alumni');

        return [
            'nim' => 'sometimes|required|string|max:20|unique:alumni,nim,' . $alumniId,
            'nama_lengkap' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:alumni,email,' . $alumniId,
            'no_telepon' => 'nullable|string|max:20',
            'tahun_masuk' => 'sometimes|required|integer|min:1900|max:' . (date('Y') + 1),
            'tahun_lulus' => 'sometimes|required|integer|min:1900|max:' . (date('Y') + 1),
            'jurusan' => 'sometimes|required|string|max:255',
            'program_studi' => 'sometimes|required|string|max:255',
            'ipk' => 'sometimes|required|numeric|min:0|max:4',
            'status_pekerjaan' => 'sometimes|required|in:bekerja,wirausaha,melanjutkan_studi,mencari_kerja,lainnya',
            'nama_perusahaan' => 'nullable|string|max:255',
            'posisi_pekerjaan' => 'nullable|string|max:255',
            'bidang_pekerjaan' => 'nullable|string|max:255',
            'gaji_range' => 'nullable|numeric|min:0',
            'alamat_lengkap' => 'nullable|string',
            'kota' => 'sometimes|required|string|max:255',
            'provinsi' => 'sometimes|required|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'instagram_username' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422));
    }
}