<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd($authUser);
        return view('backend.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.users.modal');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            DB::beginTransaction();
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'user_type' => 'user',
                'status' => $request->status,
            ]);
            $user->assignRole('user');

            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'User created successfully.',
            ], JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('backend.users.modal', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
            'password' => 'nullable|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $user = User::findOrFail($id);
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'user_type' => 'user',
                'status' => $request->status,
            ]);
            if ($request->has('password')) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'User updated successfully.',
            ], JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'User deleted successfully'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function dataTable(Request $request)
    {
        $users = User::where('user_type', 'user')->orderBy('id', 'desc')->get();
        return Datatables::of($users)
            ->addColumn('actions', function ($record) {
                $actions = '';
                if (auth()->user()->hasPermissionTo('edit_user') || auth()->user()->hasPermissionTo('delete_user')) {
                    $actions = '<div class="btn-list">';
                    if (auth()->user()->hasPermissionTo('edit_user')) {
                        $actions .= '<a data-act="ajax-modal" data-action-url="' . route('users.edit', $record->id) . '" data-title="Edit User" class="btn btn-sm btn-primary">
                                        <span class="fe fe-edit"> </span>
                                    </a>';
                    }
                    if (auth()->user()->hasPermissionTo('delete_user')) {
                        $actions .= '<button type="button" class="btn btn-sm btn-danger delete" data-url="' . route('users.destroy', $record->id) . '" data-method="get" data-table="#users_datatable">
                                        <span class="fe fe-trash-2"> </span>
                                    </button>';
                    }
                    $actions .= '</div>';
                }
                return $actions;
            })
            ->addColumn('name', function ($record) {
                $route = auth()->user()->hasPermissionTo('edit_user') ? route('users.edit', $record->id) : '#';
                return '<a href="javascript:void(0)" data-act="ajax-modal" data-action-url="' . $route . '" class="link" data-toggle="tooltip" data-placement="top" data-title="Edit User">' . getFullName($record) . '</a>';
            })
            ->addColumn('email', function ($record) {
                return $record->email;
            })
            ->addColumn('phone', function ($record) {
                return isValue($record->phone);
            })
            ->addColumn('status', function ($record) {
                return '<span class="badge bg-' . statusClasses($record->status) . '">' . ucfirst($record->status) . '</span>';
            })
            ->rawColumns(['actions', 'email', 'name', 'status', 'phone'])
            ->addIndexColumn()->make(true);
    }
}