<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function editOwner()
    {
        abort_unless(auth()->check() && auth()->user()->role === 'owner', 403);

        return view('profiles.owner');
    }

    public function updateOwner(Request $request)
    {
        abort_unless(auth()->check() && auth()->user()->role === 'owner', 403);

        $user = $request->user();
        $data = $request->validate($this->profileRules($user->id) + [
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'documents' => 'nullable|array|max:10',
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:10240',
            'remove_documents' => 'nullable|array',
            'remove_documents.*' => 'string',
        ]);

        $documents = array_values(array_filter(
            $user->profile_documents ?? [],
            fn (string $path) => ! in_array($path, $data['remove_documents'] ?? [], true)
        ));

        if (count($documents) + count($data['documents'] ?? []) > 10) {
            return back()
                ->withErrors(['documents' => __('يمكن حفظ 10 مستندات كحد أقصى.')])
                ->withInput();
        }

        foreach ($data['documents'] ?? [] as $document) {
            $documents[] = $document->store('profiles/documents', 'local');
        }

        $oldImage = $user->profile_image;
        $removedDocuments = array_diff($user->profile_documents ?? [], $documents);
        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'location' => $data['location'] ?? null,
            'profile_documents' => $documents,
        ]);

        if ($request->hasFile('profile_image')) {
            $user->profile_image = $request->file('profile_image')->store('profiles/images', 'public');
        }

        $user->save();

        foreach ($removedDocuments as $path) {
            Storage::disk('local')->delete($path);
        }

        if ($request->hasFile('profile_image') && $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()->route('owner.profile.edit')->with('success', __('تم تحديث الملف الشخصي.'));
    }

    public function downloadOwnerDocument(Request $request)
    {
        abort_unless(auth()->check() && auth()->user()->role === 'owner', 403);

        $user = $request->user();
        $document = $request->query('document');
        abort_unless(
            is_string($document) && in_array($document, $user->profile_documents ?? [], true),
            404
        );
        abort_unless(Storage::disk('local')->exists($document), 404);

        return Storage::disk('local')->download($document, basename($document));
    }

    public function editRenter()
    {
        abort_unless(auth()->check() && in_array(auth()->user()->role, ['tenant', 'renter'], true), 403);

        return view('profiles.renter');
    }

    public function updateRenter(Request $request)
    {
        abort_unless(auth()->check() && in_array(auth()->user()->role, ['tenant', 'renter'], true), 403);

        $user = $request->user();
        $data = $request->validate($this->profileRules($user->id) + [
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $oldImage = $user->profile_image;
        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'location' => $data['location'] ?? null,
        ]);

        if ($request->hasFile('profile_image')) {
            $user->profile_image = $request->file('profile_image')->store('profiles/images', 'public');
        }

        $user->save();

        if ($request->hasFile('profile_image') && $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()->route('renter.profile.edit')->with('success', __('تم تحديث الملف الشخصي.'));
    }

    private function profileRules(int $userId): array
    {
        return [
            'name' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'phone' => ['required', 'string', 'min:8', 'max:30', Rule::unique('users', 'phone')->ignore($userId)],
            'location' => 'nullable|string|max:255',
        ];
    }
}
