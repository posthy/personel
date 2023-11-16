<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Person;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function index($id)
    {
        $address = Address::where("person_id",  $id)->get();
        return $address;
    }

    public function store(Request $request)
    {
        $personId = $request->id;
        $addressType = $request->type;
        $person = Person::find($personId);
        if (is_null($person))
            return response('Person not found', status: 400);
            
        if (!in_array($request->address_type, Address::getAddressTypes()))
            return response('Invalid address type (permanent|temporary)', status: 400);

        $address = Address::where("person_id",  $personId)->where("address_type", $addressType)->first();
        if (!is_null($address))
            return response("Addreess type already exists", status: 400);

        $valid = $this->validator($request);
        if ($valid === true)
        {
            $address = Address::create([
                'person_id' => $personId,
                'address_type' => $request->address_type,
                'country' => $request->country,
                'city' => $request->city,
                'street' => $request->street,
                'number' => $request->number,
                'zip' => $request->zip
            ]);
            return response($address);
        }
        else
            return $valid;
    }

    public function show($id, $type)
    {
        $address = Address::where("person_id",  $id)->where("address_type", $type)->first();
        if (is_null($address)) {
            return response("Not found", 404);
        }
        return $address;
    }

    public function update(Request $request)
    {
        $personId = $request->id;
        $addressType = $request->type;
        $address = Address::where("person_id",  $personId)->where("address_type", $addressType)->first();
        if (is_null($address))
            return response("Not found", 404);

        $valid = $this->validator($request);
        if ($valid === true)
        {
            $address->update([
                'country' => $request->post("country"),
                'city' => $request->post("city"),
                'street' => $request->post("street"),
                'number' => $request->post("number"),
                'zip' => $request->post("zip")
            ]);
            return response($address);
        }
        else
            return $valid;
    }

    public function delete($id, $type)
    {
        $personId = $id;
        $addressType = $type;
        $address = Address::where("person_id",  $personId)->where("address_type", $addressType)->first();
        if (is_null($address))
            return response("Not found", 404);

        $address->delete();
        return response("Deleted");
    }

    protected function validator($request)
    {
        $validator = Validator::make($request->all(), [
            'country' => ["required"],
            "city"=> ["required"],
            'street' => ["required"],
            "number"=> ["required"],
            'zip' => ["required"]
        ]);
        if ($validator->fails())
        {
            $errors = $validator->errors();
            return response(implode("\n", $errors->all()), status: 400);
        }
        return true;
    }
}
