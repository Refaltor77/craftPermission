<?php

namespace refaltor\CraftPermission;

use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;

class CraftPermission extends PluginBase implements Listener
{
    public function onEnable()
    {
        $this->saveResource("config.yml");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCraft(CraftItemEvent $event)
    {
        $player = $event->getPlayer();
        foreach ($event->getOutputs() as $craft){
            foreach ($this->getConfig()->get("craft") as $id => $perm){
                if ($craft->getId() === $id){
                    if (!$player->hasPermission($perm)){
                        $event->setCancelled();
                        $player->sendMessage($this->getConfig()->get("message"));
                    }
                }
            }
        }
    }
}