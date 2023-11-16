<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Person;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index($id)
    {
        $contacts = Contact::where("person_id",  $id)->get();
        return $contacts;
    }

    public function store(Request $request)
    {
        $personId = $request->id;
        $person = Person::find($personId);
        if (is_null($person))
            return response('Person not found', status: 400);

        $valid = $this->validator($request);
        if ($valid === true)
        {
            $contact = Contact::create([
                "person_id" => $personId,
                "contact_type" => $request->contact_type,
                "contact_info" => $request->contact_info
            ]);
            return response($contact);
        }
        else
            return $valid;
    }

    public function show($id, $contactId)
    {
        $contact = Contact::where("person_id",  $id)->where("id", $contactId)->first();
        if (is_null($contact)) {
            return response("Not found", 404);
        }
        return $contact;
    }

    public function update(Request $request)
    {
        $personId = $request->id;
        $contactId = $request->contact_id;
        $contact = Contact::where("person_id",  $personId)->where("id", $contactId)->first();
        if (is_null($contact)) {
            return response("Not found", 404);
        }
        $valid = $this->validator($request);
        if ($valid === true)
        {
            $contact->update([
                "contact_type" => $request->contact_type,
                "contact_info" => $request->contact_info
            ]);
            return response($contact);
        }
        else
        {
            return $valid;
        }
    }

    public function delete($id, $contactId)
    {
        $contact = Contact::where("person_id",  $id)->where("id", $contactId)->first();
        if (is_null($contact)) {
            return response("Not found", 404);
        }
        $contact->delete();
        return response("Deleted");
    }

    
    protected function validator($request)
    {
        $validator = Validator::make($request->all(), [
            'contact_type' => ["required"],
            "contact_info"=> ["required"]
        ]);
        if ($validator->fails())
        {
            $errors = $validator->errors();
            return response(implode("\n", $errors->all()), status: 400);
        }
        return true;
    }
}
