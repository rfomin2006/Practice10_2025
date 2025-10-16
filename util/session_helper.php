<?php

/**
 * Checks if a user is authenticated.
 *
 * This function determines whether a user is currently logged in by
 * checking if the 'uid' key exists in the $_SESSION superglobal and
 * has a truthy value.
 *
 * @return bool Returns `true` if the user is logged in (i.e., $_SESSION['uid'] exists and is truthy),
 *              or `false` if the user is not logged in.
 */
function check_auth(): bool
{
    return !!($_SESSION['uid'] ?? false);
}
