<?php

declare(strict_types=1);

namespace kingofturkey38\performancetests;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use pocketmine\scheduler\CancelTaskException;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskHandler;
use pocketmine\Server;
use pocketmine\utils\Utils;

class PerformanceTestCommand extends Command implements PluginOwned {
	
	private ?TaskHandler $taskHandler;
	
	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!isset($args[0])){
			$sender->sendMessage("/performance server|main");
			return;
		}
		
		if(!in_array($args[0], ["server", "main"])){
			return;
		}

		$main = Main::getInstance();
		$server = Server::getInstance();
		$onlinePlayers = $server->getOnlinePlayers();
		shuffle($onlinePlayers);

		$serverFunction = function() use($onlinePlayers, $server): void {
			foreach($onlinePlayers as $p){
				$find = $server->getPlayerExact($p->getName());
			}
		};

		$mainFunction = function() use($onlinePlayers, $main): void {
			foreach($onlinePlayers as $p){
				$find = $main->getPlayer($p->getName());
			}
		};

		$using = $args[0] === "server" ? $serverFunction : $mainFunction;

		$sender->getServer()->dispatchCommand($sender, "timings on");
		$this->taskHandler = Main::getInstance()->getScheduler()->scheduleRepeatingTask(new ClosureTask($using), 1);
		$sender->sendMessage("Started task {$args[0]}");

		Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function() use($sender) : void{
			$this->taskHandler->cancel();
			$sender->getServer()->dispatchCommand($sender, "timings paste");
			$sender->sendMessage("Ended timings");
		}), 600);

	}

	public function getOwningPlugin() : Plugin{
		return Main::getInstance();
	}
}