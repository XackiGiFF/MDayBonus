<?php
declare(strict_types=1);

namespace XackiGiFF\MDayBonus\Utils;

use XackiGiFF\MDayBonus\Main;
use XackiGiFF\MDayBonus\Utils\TimeConvertor;

use pocketmine\player\Player;

class ToolBox{
    
    /** Добавление своего небольшого API */

    public static function check($group) :bool{
        if(array_key_exists($group, Main::$groups)){
			return true;
        }
		return false;
    }

    public static function give($sender, $bonus){
        $name = self::getNick($sender);
        Main::$eco->addMoney($sender, $bonus);
        $newtime = time();
        Main::$UserData->set($name, [  //Make this structure for add new lines in future
            "Time" => $newtime
            ]);
        Main::$UserData->save();
    }

	public static function checkGived(Player $player) :bool{
        $name = self::getNick($player);
		$timelist = Main::$UserData->get($name);
		if(is_array($timelist)){
			$lasttime = $timelist['Time'];
			$nowtime = time();
			if ($lasttime + ( Main::$time * 60 * 60 ) < $nowtime) {
				return true;
			} else {
				$sec = $lasttime + ( Main::$time * 60 * 60 ) - $nowtime;
				$time = TimeConvertor::ConvertSecToWord($sec);
				return false;
			}
		} else {
			return true;
		}
	}

    public static function getTime(Player $player) {
        $name = self::getNick($player);
		$timelist = Main::$UserData->get($name);
		if(is_array($timelist)){
			$lasttime = $timelist['Time'];
			$nowtime = time();
			if ($lasttime + ( Main::$time * 60 * 60 ) >= $nowtime) {
				$sec = $lasttime + ( Main::$time * 60 * 60 ) - $nowtime;
				$time = TimeConvertor::ConvertSecToWord($sec);
				return $time;
			}
        }
    }

    public static function getNick(Player $player){
        return $name = strtolower($player->getName());
    }

	public static function getPlayerGroup(Player $player): string{
        $group = Main::$purePerms->getUserDataMgr()->getData($player)["group"];
        return $group ?? "No Group";
    }
    
	public static function getPlayerGroupNoStatic(Player $player): string{
        $group = $this->pp->getUserDataMgr()->getData($player)["group"];
        return $group ?? "No Group";
    }

}