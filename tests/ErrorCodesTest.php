<?php

use NjoguAmos\Turnstile\ErrorCodes;

it(description: 'returns the correct descriptions for each error code', closure: function () {
    expect(value: ErrorCodes::MISSING_INPUT_SECRET->description())
        ->toBe(expected: 'The secret parameter was not passed.')
        ->and(value: ErrorCodes::INVALID_INPUT_SECRET->description())
        ->toBe(expected: 'The secret parameter was invalid or did not exist.')
        ->and(value: ErrorCodes::MISSING_INPUT_RESPONSE->description())
        ->toBe(expected: 'The response parameter (token) was not passed.')
        ->and(value: ErrorCodes::INVALID_INPUT_RESPONSE->description())
        ->toBe(expected: 'The response parameter (token) is invalid or has expired. Most of the time, this means a fake token has been used. If the error persists, contact customer support.')
        ->and(value: ErrorCodes::BAD_REQUEST->description())
        ->toBe(expected: 'The request was rejected because it was malformed.')
        ->and(value: ErrorCodes::TIMEOUT_OR_DUPLICATE->description())
        ->toBe(expected: 'The response parameter (token) has already been validated before. This means that the token was issued five minutes ago and is no longer valid, or it was already redeemed.')
        ->and(value: ErrorCodes::INTERNAL_ERROR->description())
        ->toBe(expected: 'An internal error happened while validating the response. The request can be retried.');

});

it(description: 'has the correct number of error codes', closure: function () {
    $cases = (new ReflectionEnum(objectOrClass: ErrorCodes::class))->getCases();
    expect(value: $cases)->toHaveCount(count: 7);
});

it(description: 'returns the correct string value for each error code', closure: function () {
    expect(value: ErrorCodes::MISSING_INPUT_SECRET->value)->toBe(expected: 'missing-input-secret');
    expect(value: ErrorCodes::INVALID_INPUT_SECRET->value)->toBe(expected: 'invalid-input-secret');
    expect(value: ErrorCodes::MISSING_INPUT_RESPONSE->value)->toBe(expected: 'missing-input-response');
    expect(value: ErrorCodes::INVALID_INPUT_RESPONSE->value)->toBe(expected: 'invalid-input-response');
    expect(value: ErrorCodes::BAD_REQUEST->value)->toBe(expected: 'bad-request');
    expect(value: ErrorCodes::TIMEOUT_OR_DUPLICATE->value)->toBe(expected: 'timeout-or-duplicate');
    expect(value: ErrorCodes::INTERNAL_ERROR->value)->toBe(expected: 'internal-error');
});
