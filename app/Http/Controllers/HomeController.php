<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Member;
use App\Models\Organization;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $organizations = Organization::paginate(20);
        return view('welcome', compact('organizations'));
    }

    public function viewVerification()
    {
        return view('verification');
    }

    public function search(Request $request)
    {
        $search = $request->query('search');

        // Query with search filter
        $organizations = Organization::whereHas('district', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
            ->orWhere('address', 'like', '%' . $search . '%')
            ->orWhere('name', 'like', '%' . $search . '%')
            ->paginate(20);

        return view('welcome', compact('organizations'));
    }

    public function verifyMember(Request $request)
    {
        $query = trim($request->input('cardNumber'));

        // Prevent empty or null searches
        if (empty($query)) {
            return view('verification', ['cards' => [], 'message' => 'Please enter a card number.']);
        }

        $cards = Card::with('member')
            ->where('number', 'like', "%{$query}%")
            ->get();

        if ($cards->isEmpty()) {
            return view('verification', ['cards' => [], 'message' => 'No card found.']);
        }

        return view('verification', compact('cards'));
    }

}
