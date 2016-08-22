<?php
namespace WPLIB_Box;

use Psr\Http\Message\ResponseInterface as Response;

class WPLIB_Box_CLI_Interface {

    function process_command( $command, Response $response )
    {
        $response = $response->withJson(['message' => 'Command not found', 'command' => $command], 500);

        // add check for existent command
        if (file_exists("/vagrant/scripts/guest/cli/commands/{$command}")) {
            ob_start();
            passthru("box {$command}");
            $message = ob_get_clean();

            $response = $response->withJson(['message' => $message, 'command' => $command], 200);
        }

        return $response;

    }

}
