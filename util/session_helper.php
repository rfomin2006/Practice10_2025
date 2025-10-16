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
    return (bool) ($_SESSION['uid'] ?? false);
}

/**
 * Checks if the current user has admin privileges.
 *
 * This function looks for the 'is_admin' key in the session.
 * If the key is not set or is falsy, it returns false.
 *
 * @return bool True if the user is an admin, false otherwise.
 */
function is_admin(): bool
{
    return (bool) ($_SESSION['is_admin'] ?? false);
}
