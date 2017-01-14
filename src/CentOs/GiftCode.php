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
		$testingcode = array(1234567,1234596,1234569);                                                                                                                                                                                                                                                     
		$this->code = new Config($this->getDataFolder() . "code.yml", Config::YAML);
		if ($this->code->get("Code")==null) {
			$this->code->set("Code", $testingcode);
		}
		$this->language = new Config($this->getDataFolder() . "language.yml", Config::YAML, array(
			"succeed.code" => "Mã code nhập đã thành công !!",
			"wrong.code" => "Sai code, code phân biệt chữ Hoa và chữ thường",
			"fail.code" => "Code thất bại, nếu đây là do lỗi của server vui lòng liên hệ với admin hoặc OP",
			"defaultlang" => "vie",
		));
		if ($this->language->get("defaultlang") === "vie") {
			$this->getLogger()->warning("Selected Defaultlang: Vietnamese");
		} else {
			$this->getLogger()->error("Cannot find Defaultlang...");
			$this->getLogger()->warning("Creating a language file... (en)");
			$this->language = new Config($this->getDataFolder() . "language.yml", Config::YAML, array(
			"succeed.code" => "Succeed Code, You Will Get The Prize",
			"wrong.code" => "Wrong Code (A) and (a) will be distinguished",
			"fail.code" => "Failed code",
			"defaultlang" => $this->language->get("defaultlang"),
		));
			$this->language->save();
		}
		$this->players = new Config($this->getDataFolder() . "players.yml", Config::YAML);
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
				} else {
					if($sender->hasPermission("giftcode.members")){
						if($this->code->get("Code") === $args[0]){
							$sender->sendMessage($this->language->get("succeed.code"));
							
						}
						else {
							$sender->sendMessage($this->language->get("wrong.code"));
						 	$sender->sendMessage($this->language->get("fail.code"));
						}
						return true;
					}
				}
				break;	   
			return true;
		    }
		}
}			
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
