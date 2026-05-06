<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->only(['name', 'email', 'tel', 'content']);

        return view('confirm', compact('contact'));
    }

    public function store(ContactRequest $request)
    {
        $contact = $request->only(['name', 'email', 'tel', 'content']);

        // データの保存やメールの送信などの処理をここに追加
        Contact::create($contact);
        
        return view('thanks');
    }
}
