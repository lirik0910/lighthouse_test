<?php

namespace App\GraphQL\Mutations;

use App\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CreateUser
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
        $phone = $args['input']['country_code'] . $args['input']['phone_number'];

        if($args['input']['password'] === $args['input']['confirmation_password']){
            $id = User::create([
                'phone' => $phone,
                'password' => Hash::make($args['input']['password'])
            ])['id'];

            $user = User::find($id);
            $user->attributes()->create();

            return $user;
        }
    }
}
