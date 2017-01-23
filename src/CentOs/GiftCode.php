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
use onebone\economyapi\EconomyAPI;
use MassiveEconomy\MassiveEconomyAPI;
use pocketmine\utils\TextFormat as C;

class GiftCode extends PluginBase implements Listener{
	public $mtp;
	public function onEnable(){
		@mkdir($this->getDataFolder());                                                                                                                                                                                                                                            
		$this->code = new Config($this->getDataFolder() . "code.yml", Config::YAML, array(
			"Code" => "1",
			"money" => "1000",
			"xu" => "10",
		));
		$this->language = new Config($this->getDataFolder() . "language.yml", Config::YAML, array(
			"succeed.code" => "Mã code nhập đã thành công !!",
			"wrong.code" => "Sai code, code phân biệt chữ Hoa và chữ thường",
			"fail.code" => "Code thất bại, nếu đây là do lỗi của server vui lòng liên hệ với admin hoặc OP",
			"code.is.used" => "Code đã được dùng.",
			"error.code" => "Vui lòng nhập code",
			"defaultlang" => "vie",
		));
		///SQLite is recommended
		$this->db = new \SQLite3($this->getDataFolder() . "CodeIsUsed.db");
		$this->db->exec("CREATE TABLE IF NOT EXISTS playerusingcode (player TEXT PRIMARY KEY COLLATE NOCASE,code TEXT)");
		$this->db->exec("CREATE TABLE IF NOT EXISTS code (code TEXT)");
		///END OF SQLITE3
		$this->mecon = $this->getServer()->getPluginManager()->getPlugin("MassiveEconomy");
		$this->getLogger()->info(C::AQUA . "Checking for" . C::GREEN . "MassiveEconomy " . C::AQUA . "plugin...."); 
		if (!$this->mecon) {
			$this->getLogger()->info(C::RED . "Cannot find MassiveEconomy");
		} else {
			$this->getLogger()->info(C::GREEN . "MassiveEconomy found");
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
	public function playerUse($player, $code){
		$result = $this->db->query("SELECT * FROM playerusingcode WHERE player='$player' AND code='$code';");
		$array = $result->fetchArray(SQLITE3_ASSOC);
		return empty($array) == false;
	}
	public function playerUseToo($player){
		$result = $this->db->query("SELECT * FROM playerusingcode WHERE player='$player';");
		$array = $result->fetchArray(SQLITE3_ASSOC);
		return empty($array) == false;
	}
	public function codeisUsed($codes){
		$code = strtolower($codes);
		$and = $this->db->query("SELECT * FROM code WHERE code='$codes';");
		$andArr = $and->fetchArray(SQLITE3_ASSOC);
		return empty($andArr) == false;
	}
	public function setCode($codes){
		$code = $this->db->prepare("INSERT OR REPLACE INTO code (code) VALUES (:code);");
		$code->bindValue(":code", $codes);
		$result = $code->execute();
	}
	public function playerUseCode($player, $code){
		$result = $this->db->prepare("INSERT OR REPLACE INTO playerusingcode (player, code) VALUES (:player, :code);");
		$result->bindValue(":player", $player);
		$result->bindValue(":code", $code);
		$end = $result->execute();	
	}
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		  if(count($args) === 0){
			  return false;
		  }
		  $arg = array_shift($args);
		  switch($arg){
			  case "reload":
				  if($sender->hasPermission("giftcode.ops")){
					  if($args[0] === "") {
						  $sender->getMessage("/gift <reload>");
					  } else {
						  //TO-DO
					  }
					  return true;
				  }  
			break;
			case "get":
					if($sender->hasPermission("giftcode.members")){
						if ($args[0] === "") {
							$sender->sendMessage($this->language->get("error.code"));
						} else if(array_search($args[0] , $this->code->getAll()["Code"])){
							if (!$this->codeisUsed($args[0])) {
								if(!$this->playerUse($sender->getName(), $args[0]) and !$this->playerUseToo($sender->getName())){
									$sender->sendMessage($this->language->get("succeed.code"));
									$this->setCode($args[0]);
									$this->playerUseCode($sender->getName(), $args[0]);
									MassiveEconomyAPI::getInstance()->payPlayer($sender, $this->code->get("xu"));
									EconomyAPI::getInstance()->addMoney($sender, $this->code->get("money"));
								} else {
									$sender->sendMessage("You already have this prize !!!!");
								}
							} else {
								$sender->sendMessage($this->language->get("code.is.used"));
							}
						} else {
							$sender->sendMessage($this->language->get("wrong.code"));
						 	$sender->sendMessage($this->language->get("fail.code"));
						}
						return true;
					}
				break;				
			return true;
		    }
		}
}			
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
