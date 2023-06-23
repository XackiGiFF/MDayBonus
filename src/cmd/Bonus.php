<?php

declare(strict_types=1);

namespace XackiGiFF\MDayBonus\cmd;

use XackiGiFF\MDayBonus\Main;
use XackiGiFF\MDayBonus\Utils\ToolBox;

use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Bonus extends Command{
	private static $plugin;
	private static $prefix;
	private static $groups;

    /**
	 * @param Main $plugin
	 * @param            $cmd
	 * @param            $description
	 */

    public function __construct(Main $plugin, $cmd, $description){
        self::$plugin = $plugin;

        parent::__construct($cmd, $description);

        $this->setPermission("mday.bonus");
    }

	/**
	 * @param CommandSender $sender
	 * @param               $label
	 * @param array         $args
	 *
	 * @return bool
	 */

    public function execute(CommandSender $sender, string $label, array $args){
		if($sender instanceof Player){

			$group = ToolBox::getPlayerGroup($sender);
			if($group == "No Group") {
				Main::getInstance()->getLogger()->critical("PurePerms not response correctly! PurePerms не отвечает корректно!");
				return false;
			}
			if(ToolBox::check($group)){
				$bonus = Main::$groups[$group];
				
				if (ToolBox::checkGived($sender)){
					ToolBox::give($sender, $bonus);
				} else {
					$time = ToolBox::getTime($sender);
					$sender->sendMessage(Main::$prefix." §сВы можете получить бонус только через: §e" . $time);
					return false;
				}
				$sender->sendMessage(Main::$prefix." §aВы получили бонус: ".$bonus);
				return true;
			} else {
				$sender->sendMessage(Main::$prefix." Для вашей привилегии нет бонуса!");
				return false;
			}
			return true;
		} else {
			$sender->sendMessage(Main::$prefix." §4Только в игре!");
			return false;
		}
    }

}