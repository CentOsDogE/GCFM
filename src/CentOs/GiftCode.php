<?php

namespace CentOs;


use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\Server;
use pocketmine\utils\TextFormat as C;

class GiftCode extends PluginBase implements Listener{
	public function onEnable(){
		@mkdir($this->getDataFolder());
		$this->code = new Config($this->getDataFolder() . "code.yml", Config::YAML);
		$this->players = new Config($this->getDataFolder() . "players.yml", Config::YAML);
		$this->allowedchars = new Config($this->getDataFolder() . "allowedchars.yml", Config::YAML);
		$this->purePerms = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
		$this->getLogger()->info(C::AQUA . "Checking for" . C::GREEN . "PurePerms " . C::AQUA . "plugin...."); 
		if (!$this->purePerms) {
			$this->getLogger()->info(C::RED . "Cannot find PurePerms");
		} else {
			$this->getLogger()->info(C::GREEN . "PurePerms found");
		}
		$this->economy = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
		$this->getLogger()->info(C::AQUA . "Checking for" . C::GREEN . "EconomyAPI " . C::AQUA . "plugin...."); 
		if (!$this->economy) {
			$this->getLogger()->info(C::RED . "Cannot find EconomyAPI");
		} else {
			$this->getLogger()->info(C::GREEN . "EconomyAPI found");
		}
		$this->getLogger()->info("§a" . $this->getDescription()->getFullName() . " enabled!");
		
    }
	public function getChars(){/// From ChatCensor plugin
		$config = $this->allowedchars->getAll();
		$chars = implode($config["char-check"]["allowed-chars"]);
		return $chars;
	}
	public function codeInFile(){
		$getcode = $this->code->getAll();
		$codes = implode($getcode["Code"]);
		return true;
	}
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		  if(count($args) === 0){
			  return false;
		  }
		  $arg = array_shift($args);
		  switch($arg){
		  	case "member":
		  	case "mems":
			case "normal":
				if(!$sender instanceof Player){
					$sender->sendMessage("[GFCM] Please run this command in game !!");
					return true;
				} else {
					if($sender->hasPermission("giftcode.members")){
						if($this->codeinFile($args[0])){
							$sender->sendMessage("Yes");
							return true;
						} else {
							$sender->sendMessage("No");
							return true;
						}
					return true;
					}
				}
				break;	   
			return true;
		    }
		}
}			
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
