<?php

declare(strict_types=1);

use NjoguAmos\Turnstile\Rules\TurnstileRule;

beforeEach(closure: function () {
    $this->rule = new TurnstileRule();
});

it(description: 'passes with a valid token', closure: function () {
    // Set a key that always passes
    setSecretKey(type: 'valid');

    expect(value:$this->rule)->toPassWith('DUMMY.TOKEN');
});

it(description: 'fails with an valid token', closure: function () {
    // Set a key that always passes
    setSecretKey(type: 'invalid');

    expect(value:$this->rule)->not->toPassWith('DUMMY.TOKEN');
});

it(description: 'fails with a spent valid token', closure: function () {
    // Set a key that always passes
    setSecretKey(type: 'spent');

    expect(value:$this->rule)->not->toPassWith('DUMMY.TOKEN');
});

it(description: 'passes when turnstile is disable', closure: function () {
    config()->set('turnstile.secretkey', null);
    config()->set('turnstile.enabled', false);

    expect(value:$this->rule)->toPassWith('');
});
