<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\AlumniResource;
use App\Models\Alumni;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AlumniAuthController extends Controller
{
    // Login
    public function login(LoginRequest $request): JsonResponse
    {
        $alumni = Alumni::where('email', $request->email)->first();

        if (!$alumni || !Hash::check($request->password, $alumni->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (!$alumni->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Your account is inactive. Please contact administrator.'
            ], 403);
        }

        $alumni->tokens()->delete();

        $token = $alumni->createToken('alumni_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'alumni' => new AlumniResource($alumni),
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]
        ]);
    }

    // Cek alumni login
    public function profile(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new AlumniResource($request->user())
        ]);
    }

    // Update data alumni yang login
    public function updateProfile(Request $request): JsonResponse
    {
        $alumni = $request->user();

        $validated = $request->validate([
            'no_telepon' => 'nullable|string|max:20',
            'nama_lengkap' => 'required|string',
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
        ]);

        try {
            $alumni->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => new AlumniResource($alumni->fresh())
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Update password alumni yang login
    public function changePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $alumni = $request->user();

        if (!Hash::check($request->current_password, $alumni->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Current password is incorrect.'],
            ]);
        }

        $alumni->update([
            'password' => Hash::make($request->new_password)
        ]);

        $alumni->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully. Please login again.'
        ]);
    }

    // Logout
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}
