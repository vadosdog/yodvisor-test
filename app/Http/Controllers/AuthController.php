<?php

namespace App\Http\Controllers;

use App\Exceptions\UnauthorizedException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
	/**
	 * Get a JWT via given credentials.
	 *
	 * @param Request $request
	 * @return JsonResponse
	 * @throws UnauthorizedException
	 */
	public function login(Request $request)
	{
		//TODO login request
		$request->validate([
			'email' => 'required',
		]);
		$credentials = $request->only(['email', 'password']);

		if (!$token = auth()->attempt($credentials)) {
			throw new UnauthorizedException();
		}

		return $this->respondWithToken($token);
	}

	/**
	 * Log the user out (Invalidate the token).
	 *
	 * @return JsonResponse
	 */
	public function logout()
	{
		auth()->logout();

		return \Response::success(['message' => 'Successfully logged out']);
	}

	/**
	 * Refresh a token.
	 *
	 * @return JsonResponse
	 */
	public function refresh()
	{
		return $this->respondWithToken(auth()->refresh());
	}

	/**
	 * Get the token array structure.
	 *
	 * @param string $token
	 *
	 * @return JsonResponse
	 */
	protected function respondWithToken($token)
	{
		return \Response::success([
			'token' => (string)$token
		]);
	}
}
