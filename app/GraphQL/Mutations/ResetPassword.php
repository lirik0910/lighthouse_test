<?php

namespace App\GraphQL\Mutations;

use App\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ResetPassword extends BaseCodeResolver
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $this->phone = $args['input']['country_code'] . $args['input']['phone_number'];

        if ($this->validateToken() && $args['input']['password'] === $args['input'] ['password_confirmation']){

            $user = User::where('phone', $this->phone)->first();

            if(!empty($user)){
                if($user->update([
                    'password' => Hash::make($args['input']['password'])
                ])){
                    return [
                        'status' => 'success',
                        'message' => 'Your password change was successful. Now you can use him to login!!'
                    ];
                }
            }

            return [
                'status' => 'fail',
                'message' => 'Cannot found user with this phone number!'
            ];
        }

        return [
            'status' => 'fail',
            'message' => 'Your token was expired or incorrect. Please retry code request!'
        ];
    }
}
