
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $addresses = UserAddress::where('user_id', $user->id)
            ->orderBy('is_default', 'desc')
            ->get();

        return view('profile.index', compact('user', 'addresses'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'full_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female'
        ]);

        $user = Auth::user();
        $user->update($request->only([
            'username', 'email', 'full_name', 'phone', 'birth_date', 'gender'
        ]));

        return redirect()->route('profile.index')
            ->with('success', 'Profil berhasil diperbarui');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return redirect()->back()->with('error', 'Password lama tidak sesuai');
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Password berhasil diubah');
    }

    public function addAddress(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'is_default' => 'boolean'
        ]);

        if ($request->is_default) {
            UserAddress::where('user_id', Auth::id())
                ->update(['is_default' => false]);
        }

        UserAddress::create([
            'user_id' => Auth::id(),
            'label' => $request->label,
            'recipient_name' => $request->recipient_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'is_default' => $request->is_default ?? false
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Alamat berhasil ditambahkan');
    }

    public function deleteAddress($id)
    {
        $address = UserAddress::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $address->delete();

        return redirect()->route('profile.index')
            ->with('success', 'Alamat berhasil dihapus');
    }
}
