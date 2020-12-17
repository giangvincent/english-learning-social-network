<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Validator;

class ContactController extends Controller
{
    public function handleCreateContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:191',
            'subject' => 'required|max:255',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $contact = new Contact();
        $contact->email = $request->email;
        $contact->name = $request->name;
        $contact->subject = strip_tags($request->subject);
        $contact->content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->content);
        $contact->save();

        return response()->json(['status' => true]);
    }
}
