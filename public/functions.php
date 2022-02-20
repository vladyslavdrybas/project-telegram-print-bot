<?php

declare(strict_types=1);

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);

// Create a handler function
function assert_handler(string $file, int $line, int $code, string $message = 'AssertMessage'): void
{
        echo "<hr>Assertion Failed:
        File '$file'<br />
        Line '$line'<br />
        Code '$code'<br /><hr />
        Message '$message'<br /><hr />" ;
//    throw new \Exception($message, $code);
}

// Set up the callback
assert_options(ASSERT_CALLBACK, 'assert_handler');