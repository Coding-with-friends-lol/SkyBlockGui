<?php

namespace TheBlast\SkyBlockGui;

use jojoe77777\FormApi\CustomForm;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\InvMenuHandler;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use room17\SkyBlock\SkyBlock;
use room17\SkyBlock\island\IslandFactory;
use room17\SkyBlock\session\Session;
use room17\SkyBlock\session\SessionLocator;
use room17\SkyBlock\utils\Invitation;
use room17\SkyBlock\utils\message\MessageContainer;

class Main extends PluginBase{

   public function onEnable(){
      @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->saveDefaultConfig();
      $this->getLogger()->info("enabled");
      $api = SkyBlock::getInstance();
      if(!InvMenuHandler::isRegistered()){
         InvMenuHandler::register($this);
      }
      $command = new PluginCommand("sb1", $this);
      $command->setDescription("Skyblock Menu");
      $this->getServer()->getCommandMap()->register("sb1", $command);
   }

   public function onDisable(){
      $this->getLogger()->info("disabled");
   }

   public function onCommand(CommandSender $player, Command $cmd, string $label, array $args) : bool{
        switch($cmd->getName()){
            case "sb1":
                if(!$player instanceof Player){
                    $player->sendMessage("SkyBlockGui");
                    return true;
                }
      $session = SessionLocator::getSession($player);
                if (!$session->hasIsland()) {
                        $this->islandCreation($player, $session);
                    } else {
                        $this->islandManagement($player, $session);
                }
                    break;
        }
        return true;
    }
