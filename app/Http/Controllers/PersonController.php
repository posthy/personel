<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use Illuminate\Support\Facades\Validator;

class PersonController extends Controller
{
    public function index()
    {
        $persons = Person::all();
        return $persons;
    }

    public function store(Request $request)
    {
        $valid = $this->validator($request);
        if ($valid === true)
        {
            $person = Person::create($request->all());
            return response($person);
        }
        else
        {
            return $valid;
        }
    }

    public function show($id)
    {
        $person = Person::find($id);
        if (is_null($person)) 
        {
            return response("Not found", 404);
        }
        return $person;
    }

    public function update(Request $request, $id)
    {
        $person = Person::find($id);
        if (is_null($person)) 
        {
            return response("Not found", 404);
        }
        $valid = $this->validator($request);
        if ($valid === true)
        {        
            $person->update($request->all());
            return response($person);
        }
        else
        {
            return $valid;
        }
    }

    public function delete($id)
    {
        $person = Person::find($id);
        if (is_null($person)) 
        {
            return response("Not found", status: 404);
        }
        $person->delete();
        return response("Deleted");
    }

    protected function validator($request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ["required"],
            "last_name"=> ["required"]
        ]);
        if ($validator->fails())
        {
            $errors = $validator->errors();
            return response(implode("\n", $errors->all()), status: 400);
        }
        return true;
    }
}
