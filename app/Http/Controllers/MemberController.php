<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index() {
        return response()->json(Member::latest()->get());
    }

    public function store(Request $request) {
        $request->validate([
            'fullName' => 'required|string',
            'phoneNumber' => 'required|string',
            'photo' => 'nullable|image|max:2048'
        ]);

        $path = $request->hasFile('photo') 
            ? $request->file('photo')->store('members', 'public') 
            : null;

        $member = Member::create(array_merge($request->all(), ['photo' => $path]));

        return response()->json(['message' => 'Anggota berhasil ditambahkan', 'data' => $member], 201);
    }

    public function update(Request $request, Member $member) {
        $data = $request->only(['fullName', 'phoneNumber', 'status']);

        if ($request->hasFile('photo')) {
            if ($member->photo) Storage::disk('public')->delete($member->photo);
            $data['photo'] = $request->file('photo')->store('members', 'public');
        }

        $member->update($data);
        return response()->json(['message' => 'Data anggota diperbarui']);
    }

    public function destroy(Member $member) {
        if ($member->photo) Storage::disk('public')->delete($member->photo);
        $member->delete();
        return response()->json(['message' => 'Anggota berhasil dihapus']);
    }
}