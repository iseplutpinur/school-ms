<?php

namespace App\Http\Controllers\Admin\Address;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address\Province;
use Yajra\Datatables\Datatables;
use Laravel\Fortify\Rules\Password;
use League\Config\Exception\ValidationException;


class ProvinceController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {

            return Datatables::of(Province::query())
                ->addIndexColumn()
                ->make(true);
        }

        $page_attr = [
            'title' => 'Manage Address Provinces',
            'breadcrumbs' => [
                ['name' => 'Address'],
            ]
        ];
        return view('admin.address.province', compact('page_attr'));
    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'id' => ['required', 'string', 'max:2'],
            ]);

            Province::create([
                'name' => $request->name,
                'id' => $request->id,
            ]);
            return response()->json();
        } catch (ValidationException $error) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $address = Province::find($request->id);
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
            ]);

            $address->name = $request->name;
            $address->save();
            return response()->json();
        } catch (ValidationException $error) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 500);
        }
    }

    public function delete(Request $address)
    {
        try {
            $address = Province::find($address->id);
            $address->delete();
            return response()->json();
        } catch (ValidationException $error) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 500);
        }
    }
}
