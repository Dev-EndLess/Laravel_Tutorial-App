<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
  // Show all listings
  public function index()
  {
    return view('listings.index', [
      'listings' => Listing::latest()->filter(request(['tag', 'search']))->get()
    ]);
  }

  // Show single listing
  public function show(Listing $listing)
  {
    return view('listings.show', [
      'listing' => $listing,
    ]);
  }

    // Store Listing Data
    public function store(Request $request) {
      $formFields = $request->validate([
          'title' => 'required',
          'company' => ['required', Rule::unique('listings', 'company')],
          'location' => 'required',
          'website' => 'required',
          'email' => ['required', 'email'],
          'tags' => 'required',
          'description' => 'required'
      ]);

      Listing::create($formFields);

      return redirect('/');
  }

  // Create event
  public function create()
  {
    return view('listings.create');
  }
}