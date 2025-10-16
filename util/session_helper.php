<?php function check_auth(): bool
{
    return !!($_SESSION['uid'] ?? false);
}
