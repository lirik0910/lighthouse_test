<?php

namespace App\GraphQL\Queries;

use App\GraphQL\Mutations\BaseCodeResolver;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CheckCode extends BaseCodeResolver
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
        $this->phone_number = $args['input']['phone_number'];
        $this->country_code = $args['input']['country_code'];
        $code = $args['input']['code'];

        $checkingPhone = $this->getOnCheckingPhone();

        if($checkingPhone->code === $code && !$this->checkIfExpire()){
            return true;
        }

        return false;
    }
}
