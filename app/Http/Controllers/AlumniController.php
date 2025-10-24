<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlumniRequest;
use App\Http\Requests\UpdateAlumniRequest;
use App\Http\Resources\AlumniResource;
use App\Models\Alumni;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;

class AlumniController extends Controller
{

    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Alumni::query();

        // Filter by tahun lulus
        if ($request->has('tahun_lulus')) {
            $query->filterByTahunLulus($request->tahun_lulus);
        }

        // Filter by status pekerjaan
        if ($request->has('status_pekerjaan')) {
            $query->filterByStatusPekerjaan($request->status_pekerjaan);
        }

        // Search keyword
        if ($request->has('search')) {
            $query->search($request->search);
        }

        // Filter by jurusan
        if ($request->has('jurusan')) {
            $query->where('jurusan', 'like', '%' . $request->jurusan . '%');
        }

        // Filter active only
        if ($request->boolean('active_only')) {
            $query->active();
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = $request->get('per_page', 15);
        $alumni = $query->paginate($perPage);

        return AlumniResource::collection($alumni);
    }


    public function store(StoreAlumniRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);

            $alumni = Alumni::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Alumni created successfully. Password has been set.',
                'data' => new AlumniResource($alumni)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create alumni',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function show(string $id): JsonResponse
    {
        try {
            $alumni = Alumni::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => new AlumniResource($alumni)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Alumni not found'
            ], 404);
        }
    }


    public function update(UpdateAlumniRequest $request, string $id): JsonResponse
    {
        try {
            $alumni = Alumni::findOrFail($id);
            $alumni->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Alumni updated successfully',
                'data' => new AlumniResource($alumni)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update alumni',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy(string $id): JsonResponse
    {
        try {
            $alumni = Alumni::findOrFail($id);
            $alumni->delete();

            return response()->json([
                'success' => true,
                'message' => 'Alumni deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete alumni',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function statistics(): JsonResponse
    {
        $stats = [
            'total_alumni' => Alumni::count(),
            'by_status_pekerjaan' => Alumni::select('status_pekerjaan')
                ->selectRaw('count(*) as total')
                ->groupBy('status_pekerjaan')
                ->get(),
            'by_tahun_lulus' => Alumni::select('tahun_lulus')
                ->selectRaw('count(*) as total')
                ->groupBy('tahun_lulus')
                ->orderBy('tahun_lulus', 'desc')
                ->get(),
            'avg_ipk' => Alumni::avg('ipk'),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
