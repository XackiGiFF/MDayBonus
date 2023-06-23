<?php

declare(strict_types=1);

namespace XackiGiFF\MDayBonus;

use XackiGiFF\MDayBonus\Main;
use XackiGiFF\MDayBonus\Utils\ToolBox;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class DayBonusListener implements Listener{
	private static $plugin;
	/**
	 * @param Main $plugin
	 */
	public function __construct(Main $plugin){
		self::$plugin = $plugin;
	}
	/**
	 * @param PlayerJoinEvent $e
	 * @priority LOWEST
	 * @return void
	 */

	public function onJoin(PlayerJoinEvent $e){
		$player = $e->getPlayer();
		if(ToolBox::checkGived($player)){
			$player->sendMessage("§eЗаберите ежедневный бонус! Введите /bonus");
		}
	}
}