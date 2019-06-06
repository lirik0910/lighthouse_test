<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\CodeSenderException;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Cookie;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class SendCode extends BaseCodeResolver
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
        $this->phone = implode('', $args['input']);

        $checkingPhone = $this->setOnCheckingPhone();

        if($checkingPhone){
            if(!$this->writeToFile($checkingPhone)){
                Cookie::queue('token', $checkingPhone->token, 60);

                return $checkingPhone;
            }
            throw new CodeSenderException(
                'Code was not sent. Please try again later!',
                'Operation error'
            );
        }
    }
}
