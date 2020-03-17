<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @return JsonResponse
     * // returns all users with their Orders
     */
    public function index() {
        return response()->json(User::with(['orders'])->get());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * // authenticates the user and generates an access token for that user
     * // createToken method is the methods Laravel Passport adds to our User Model
     */
    public function login(Request $request) {
        $status = 401; // 401 is unauthorized status code/
        $response = ['error' => 'Unauthorized'];

        if(Auth::attempt($request->only('email', 'password'))) {
            $status = 200; // 200 is OK status code/
            $response = [
                'user' => Auth::user(),
                'token' => Auth::user()->createToken('bigstore')->accessToken,
            ];
        }
        return response()->json($response, $status);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * // creates a user account, authenticates and generates an access token for it.
     */
    public function register(Request $request) {
        // Laravel Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'cPassword' => 'required|same:password',
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401); // Unauthorized
        }

        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $user->isAdmin = 0;

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('bigStore')->accessToken,
        ]);
    }

    /**
     * @param User $user
     * @return JsonResponse
     * // gets the detail of a users and returns them
     */
    public function show(User $user) {
        return response()->json($user);
    }

    /**
     * @param User $user
     * @return JsonResponse
     * // gets all the orders of a user and return them
     */
    public function showOrders(User $user) {
        return response()->json($user->orders()->with(['product'])->get());
    }
}
