<?php

/*
 * 1. To start or continue the active session, necessary to access the session data stored
 * 2. To delete all session variables, thus all temporary data
 * 3. Serves to terminate the active session and delete all session data from the server. With this step, the session is completly ended.
 * 4. After all, the user will be redirected to the index.php page using a header redirect.
 */

session_start();                // 1.               
session_unset();                // 2.
session_destroy();              // 3.
header("Location: index.php");  // 4.
exit();                         // EXIT. It ensures that script execution completely stops after the redirect process,
                                //       so no additional code is executed.

?>