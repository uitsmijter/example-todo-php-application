<?php

namespace App\Http\Helpers;

use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Providers\Auth\Illuminate as JWTAuthIlluminate;

class JWTAuthProvider extends JWTAuthIlluminate
{
    /**
     * @param mixed $id
     * @return bool
     */
    public function byId($id)
    {
        // Be compatible to other user loading methods
        if (parent::byId($id)) {
            return true;
        }

        /** @var  $user */
        $user = User::whereEmail($id)->first();
        if (!$user) {
            // Could also return false if user should not be created

            /** @var JWTAuth $auth */
            $auth = app('tymon.jwt.auth');

            // Load payload data
            $payload = $auth->getPayload();

            // Create user
            (new User([
                'email'    => $payload->get('sub'), // or $payload->get('profile')['email'] or ->get('user') when available
                'name'     => $payload->get('profile')['name'],
                'password' => ''
            ]))->save();

            // Load created users data
            $user = User::whereEmail($id)->first();
        }

        // Log in the user for the request
        $this->auth->setUser($user);

        // User is authorized
        return true;
    }
}
