<?php
namespace App\Policy;

use Authorization\IdentityInterface;
use Authorization\Policy\RequestPolicyInterface;
use Cake\Http\ServerRequest;

class RequestPolicy implements RequestPolicyInterface
{
    // Define logic to allow or deny access based on request, identity, etc.
    public function canAccess(?IdentityInterface $identity, ServerRequest $request): bool
    {
        return true;
    }

    public function canDisplay(?IdentityInterface $identity, ServerRequest $request): bool
    {
        return true;
    }


}