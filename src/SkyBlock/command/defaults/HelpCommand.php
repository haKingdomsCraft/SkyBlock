<?php
/**
 *  _____    ____    ____   __  __  __  ______
 * |  __ \  / __ \  / __ \ |  \/  |/_ ||____  |
 * | |__) || |  | || |  | || \  / | | |    / /
 * |  _  / | |  | || |  | || |\/| | | |   / /
 * | | \ \ | |__| || |__| || |  | | | |  / /
 * |_|  \_\ \____/  \____/ |_|  |_| |_| /_/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 */

namespace SkyBlock\command\defaults;


use SkyBlock\command\IsleCommand;
use SkyBlock\command\IsleCommandMap;
use SkyBlock\session\Session;

class HelpCommand extends IsleCommand {
    
    /** @var IsleCommandMap */
    private $map;
    
    /**
     * HelpCommand constructor.
     * @param IsleCommandMap $map
     */
    public function __construct(IsleCommandMap $map) {
        $this->map = $map;
        parent::__construct([], "HELP_USAGE", "HELP_DESCRIPTION");
    }
    
    /**
     * @param Session $session
     * @param array $args
     */
    public function onCommand(Session $session, array $args): void {
        $session->sendTranslatedMessage("HELP_HEADER", ["amount" => count($this->map->getCommands())]);
        foreach($this->map->getCommands() as $command) {
            $session->sendTranslatedMessage("HELP_COMMAND_TEMPLATE", [
                "name" => array_shift($command->getAliases()),
                "description" => $session->translate($command->getDescriptionMessageId()),
                "usage" => $session->translate($command->getUsageMessageId())
            ]);
            $session->getPlayer()->sendMessage(array_shift($command->getAliases()) . ": " . $session->translate($command->getDescriptionMessageId()));
        }
    }
    
}