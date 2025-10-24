<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAlumniRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nim' => 'required|string|max:20|unique:alumni,nim',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:alumni,email',
            'password' => 'required|string|min:8',
            'no_telepon' => 'nullable|string|max:20',
            'tahun_masuk' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'tahun_lulus' => 'required|integer|min:1900|max:' . (date('Y') + 1) . '|gte:tahun_masuk',
            'jurusan' => 'required|string|max:255',
            'program_studi' => 'required|string|max:255',
            'ipk' => 'required|numeric|min:0|max:4',
            'status_pekerjaan' => 'required|in:bekerja,wirausaha,melanjutkan_studi,mencari_kerja,lainnya',
            'nama_perusahaan' => 'nullable|string|max:255',
            'posisi_pekerjaan' => 'nullable|string|max:255',
            'bidang_pekerjaan' => 'nullable|string|max:255',
            'gaji_range' => 'nullable|numeric|min:0',
            'alamat_lengkap' => 'nullable|string',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'instagram_username' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'nim.required' => 'NIM wajib diisi',
            'nim.unique' => 'NIM sudah terdaftar',
            'email.unique' => 'Email sudah terdaftar',
            'tahun_lulus.gte' => 'Tahun lulus harus sama atau setelah tahun masuk',
            'ipk.max' => 'IPK maksimal 4.00',
            'status_pekerjaan.in' => 'Status pekerjaan tidak valid',
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
