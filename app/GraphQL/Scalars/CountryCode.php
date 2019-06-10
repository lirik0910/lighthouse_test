<?php

namespace App\GraphQL\Scalars;

use App\CountryCode as Codes;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ScalarType;

class CountryCode extends ScalarType
{
    /**
     * Serializes an internal value to include in a response.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function serialize($value)
    {
        // Assuming the internal representation of the value is always correct
        return $value;

        // TODO validate if it might be incorrect
    }

    /**
     * Parses an externally provided value (query variable) to use as an input
     *
     * @param  mixed  $value
     * @return mixed
     * @throws mixed
     */
    public function parseValue($value)
    {

        $codes = Codes::all();

        foreach ($codes as $code){
            if($value == $code->code){
                return $value;
            }
        }

        throw new Error(
            'Query error: Incorrect value for CountryCode scalar type'
        );
    }

    /**
     * Parses an externally provided literal value (hardcoded in GraphQL query) to use as an input.
     *
     * E.g.
     * {
     *   user(email: "user@example.com")
     * }
     *
     * @param  \GraphQL\Language\AST\Node  $valueNode
     * @param  mixed[]|null  $variables
     * @return mixed
     */
    public function parseLiteral($valueNode, ?array $variables = null)
    {
        // TODO implement validation

        return $valueNode->value;
    }
}
