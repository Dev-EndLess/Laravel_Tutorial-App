<?php

namespace App\Http\Controllers;

use App\Models\Band;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BandController extends Controller
{
  // Show all bands
  public function index()
  {
    return view('bands.index', [
      'bands' => Band::latest()->filter(request(['tag', 'search']))->paginate(3)
    ]);
  }

  // Show single band
  public function show(Band $band)
  {
    return view('bands.show', [
      'band' => $band,
    ]);
  }

  // Create event
  public function create()
  {
    return view('bands.create');
  }

  // Store band data
  public function store(Request $request)
  {
    $formFields = $request->validate([
      'name' => ['required', Rule::unique('bands', 'ticket')],
      'ticket' => 'required',
      'location' => 'required',
      'email' => ['required', 'email'],
      'website' => 'required',
      'tags' => 'required',
      'description' => '',
      'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);


    if ($request->filled('description')) {
      $formFields['description'] = $request->input('description');
    } else {
      $formFields['description'] = '';
    }

    if ($request->hasFile('logo')) {
      $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }

    $formFields['user_id'] = auth()->id();

    Band::create($formFields);

    return redirect("/")->with('success', 'Event Created Successfully!');
  }

  // Show Edit Form

  public function edit(Band $band)
  {
    return view('bands.edit', ['band' => $band]);
  }

  // Update band data
  public function update(Request $request, Band $band)
  {

    // Make sure login user is owner of the band
    if ($band->user_id != auth()->id()) {
      abort(403, 'Unauthorized Action');
    }

    $formFields = $request->validate([
      'name' => 'required',
      'ticket' => 'required',
      'location' => 'required',
      'email' => ['required', 'email'],
      'website' => 'required',
      'tags' => 'required',
      'description' => '',
      'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($request->filled('description')) {
      $formFields['description'] = $request->input('description');
    } else {
      $formFields['description'] = '';
    }

    if ($request->hasFile('logo')) {
      $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }

    $band->update($formFields);

    return redirect("/bands/{$band->id}")->with('success', 'Event Updated Successfully!');
  }

  // Delete Listing
  public function destroy(Band $band) {
    // Make sure login user is owner of the band
    if ($band->user_id != auth()->id()) { 
      abort(403, 'Unauthorized Action');
    }
    $band->delete();
    return redirect('/')->with('success', 'Event Deleted Successfully!');
  }

  // Manage Bands
  public function manage() {
    return view('bands.manage', ['bands' => auth()->user()->bands()->get()]);
  }
}