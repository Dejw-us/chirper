<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate as FacadesGate;

class ChirpController extends Controller
{
  public function index()
  {
    return view('chirps.index', [
      'chirps' => Chirp::with('user')->latest()->get(),
    ]);
  }

  public function create()
  {
    //
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'message' => 'required|string|max:255'
    ]);

    $request->user()->chirps()->create($validated);

    return redirect(route('chirps.index'));
  }

  public function show(Chirp $chirp)
  {
    //
  }

  public function edit(Chirp $chirp)
  {
    FacadesGate::authorize('update', $chirp);
    return view('chirps.edit', ['chirp' => $chirp]);
  }

  public function update(Request $request, Chirp $chirp)
  {
    FacadesGate::authorize('update', $chirp);

    $validated = $request->validate([
      'message' => 'required|string|max:255',
    ]);

    $chirp->update($validated);

    return redirect(route('chirps.index'));
  }

  public function destroy(Chirp $chirp)
  {
    FacadesGate::authorize('delete', $chirp);
    $chirp->delete();
    return redirect(route('chirps.index'));
  }
}
