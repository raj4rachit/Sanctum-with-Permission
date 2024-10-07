<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    /**
     * Display a listing of users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        // Retrieve all users, return paginated
        $users = User::paginate(10);

        // Return user data using the UserResource
        return $this->sendResponse(new UserResource($users), 'Users retrieved successfully.');
    }

    /**
     * Show a specific user by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->sendError('User not found.');
        }

        return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->sendError('User not found.');
        }

        $user->update($request->all());

        return $this->sendResponse(new UserResource($user), 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->sendError('User not found.');
        }

        $user->delete();

        return $this->sendResponse([], 'User deleted successfully.');
    }

    /**
     * Display the logged-in user's profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(): JsonResponse
    {
        $user = Auth::user(); // Retrieve the authenticated user

        if (!$user) {
            return $this->sendError('User not authenticated.');
        }

        // Return the authenticated user's data using UserResource
        return $this->sendResponse(new UserResource($user), 'User profile retrieved successfully.');
    }

    /**
     * Assign a role to a user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function assignRole(Request $request, $id): JsonResponse
    {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->sendError('User not found.');
        }

        // Validate the role
        $request->validate([
            'role' => 'required|string',
        ]);

        $user->assignRole($request->role);

        return $this->sendResponse([], 'Role assigned successfully.');
    }

    /**
     * Get all roles for a user.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function getRoles($id): JsonResponse
    {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->sendError('User not found.');
        }

        return $this->sendResponse($user->getRoleNames(), 'User roles retrieved successfully.');
    }
}
