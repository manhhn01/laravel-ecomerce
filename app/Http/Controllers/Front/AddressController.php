<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\AddressDestroyRequest;
use App\Http\Requests\Front\AddressStoreRequest;
use App\Http\Requests\Front\AddressUpdateRequest;
use App\Http\Resources\Front\AddressResource;
use App\Models\Address;
use App\Models\District;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return AddressResource::collection($user->addresses->load('ward.district.province'));
    }

    public function store(AddressStoreRequest $request)
    {
        $user = $request->user();

        $user->addresses()->create($request->only(['phone', 'lat', 'lon', 'ward_id', 'address']));

        return AddressResource::collection($user->addresses->load('ward.district.province'));
    }

    public function update(AddressUpdateRequest $request, $id)
    {
        $user = $request->user();

        $user
            ->addresses()
            ->findOrFail($id)
            ->update($request->only(['address', 'phone', 'ward_id', 'lat', 'lon']));

        return AddressResource::collection($user->addresses->load('ward.district.province'));
    }

    public function destroy(AddressDestroyRequest $request, $id)
    {
        $user = $request->user();

        $user->addresses()->findOrFail($id)->delete();


        return AddressResource::collection($user->addresses->load('ward.district.province'));
    }

    public function childDivisionsList(Request $request)
    {
        $name = $request->query('division_name');
        $id = $request->query('division_id');
        if (empty($name) || empty($id)) {
            return Province::all();
        } else {
            switch ($name) {
                case 'province':
                    return Province::findOrFail($id)->districts;
                case 'district':
                    return District::findOrFail($id)->wards;
                default:
                    throw ValidationException::withMessages(
                        [
                            'division_name' => 'Invalid division name. Expected \'province\', \'district\''
                        ]
                    );
            }
        }
    }
}
