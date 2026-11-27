<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Domain\Auth\Models\User;
use Domain\Product\Models\Product;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('profile.index', [
            'user' => $user,
        ]);
    }

    public function update(User $user, ProfileRequest $request)
    {
        $dataToUpdate = [];

        if ($request->filled('name')) {
            $dataToUpdate['name'] = $request->input('name');
        }

        if ($request->filled('email')) {
            $dataToUpdate['email'] = $request->input('email');
        }

        if ($request->filled('password')) {
            $dataToUpdate['password'] = bcrypt($request->input('password'));
        }

        $user->update($dataToUpdate);

        flash()->info('Профиль обновлен успешно!');

        return redirect()->back()->with('success', 'User updated successfully');
    }

    public function like(Product $product)
    {
        if(auth()->user() == null) {
            return redirect(route('login'));
        }

        $user = auth()->user();
        $likes = json_decode($user->likes, true) ?? [];

        if (in_array($product->id, $likes)) {
            $likes = array_diff($likes, [$product->id]);
            $message = 'Товар удален из избранного!';
        } else {
            $likes[] = $product->id;
            $message = 'Товар добавлен в избранное!';
        }

        $user->likes = json_encode($likes);
        $user->save();

        return redirect()->back()->with('success', $message);
    }
}
