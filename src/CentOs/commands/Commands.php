<?php

namespace CentOs\commands;

use pocketmine\plugin\PluginBase;
use pocketmine\permission\Permission;
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\item\Item
use pocketmine\utils\TextFormat as C;

class Commands extends PluginBase implements CommandExecutor{
	public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }
    
  public function onCommand(CommandSender $sender, Command $command, $label, array $args){
    $prefix = $this->prefix("§b[§aCODE§b]");
		  if(count($args) === 0){
			  return false;
		  }
		  $arg = array_shift($args);
		  switch($arg){
		  	case "member":
		  	case "mems":
			  case "normal":
       if($sender->hasPermission("chatcensor.commands.help"){
			  	if(!$sender instanceof Player){
			  		$sender->sendMessage("This Command Only Works for players! Please perform this command IN GAME!");
            return true;
			  	} else {
			  		if(!$args[0]){
			  			$sender->sendMessage($prefix . C::RED . " That's not a code!!");
              return true;
			  		} else { 
             if (
              return true;
              }
              return true;
            }
			  	}
          return true;
          }
		  	return true;
		  }
	  }
