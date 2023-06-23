<?php

declare(strict_types=1);

namespace XackiGiFF\MDayBonus;

use XackiGiFF\MDayBonus\cmd\Bonus;
use XackiGiFF\MDayBonus\Utils\TimeConvertor;
use XackiGiFF\MDayBonus\DayBonusListener;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase{
    private static Main $instance;
    public static $prefix;
    private static $depend;
    public static $purePerms;
    public static $eco;
    private static $cfg;
    public static $config;
    public static $UserData;
    public static $groups;
    public static $time;

    public static function getInstance() : Main {
		return self::$instance;
	}

    public function onEnable() :void{

        self::$purePerms = self::getInstance()->getServer()->getPluginManager()->getPlugin("PurePerms");
        self::$eco = self::getInstance()->getServer()->getPluginManager()->getPlugin("EconomyAPI");

        self::$depend = ["PurePerms", "EconomyAPI"];

        foreach(self::$depend as $plugin){
		    if (!self::getInstance()->getServer()->getPluginManager()->getPlugin($plugin) instanceof PluginBase) {
			    self::getInstance()->getLogger()->critical(self::$prefix." This plugin required ".$plugin." to use, please install them and restart your server");
			    self::getInstance()->getServer()->getPluginManager()->disablePlugin($this);
			    return;
		    }
        }

        self::getInstance()->getServer()->getCommandMap()->register($this->getName(), new Bonus($this, "bonus", "Ежедневный бонус"));
        self::getInstance()->getServer()->getPluginManager()->registerEvents(new DayBonusListener($this), $this);
        self::$time = self::$cfg->get('Time');
        self::$groups = self::$cfg->get('Privilegs');
        self::$prefix = self::$cfg->get('Prefix');
    }

    public function onLoad() :void{
        self::$instance = $this;
        self::getInstance()->saveResource("Config.yml");
		self::$cfg = new Config(self::getInstance()->getDataFolder() . "Config.yml", Config::YAML);
        self::$UserData = new Config($this->getDataFolder() . "UserData.yml", Config::YAML);
        self::$config = self::$cfg->getAll();
        if(empty(self::$config)){
            self::$groups = array(
                "Prefix"    => "§4>§eБонус§4<",
                "Privilegs" => array(
                        "Игрок"         => 500,
                        "Флай"          => 1000,
                        "Вип"           => 2500,
                        "Премиум"       => 5000,
                        "Ультра"        => 10000,
                        "Капитан"       => 25000,
                        "Ютуб"          => 50000
                ),
                "Time"  => 24
            );
			self::$cfg->setAll(self::$groups);
			self::$cfg->save();
		}

    }

}
