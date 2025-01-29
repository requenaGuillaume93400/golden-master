<?php

declare(strict_types=1);

namespace Tests;

use ApprovalTests\Approvals;
use ApprovalTests\CombinationApprovals;
use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testFoo(): void
    {
        // Test sur une valeur
        // $items = [new Item('foo', 1000, 1000)];
        // $gildedRose = new GildedRose($items);
        // $gildedRose->updateQuality();
        // Approvals::verifyString($items[0]->__toString());

        // Tester tous les cas en se basant sur les valeurs qu'on a repéré dans les if
        $names = ['Aged Brie', 'Backstage passes to a TAFKAL80ETC concert', 'Sulfuras, Hand of Ragnaros', 'foo'];
        $sellIns = [5, 12, -1, 7];
        $qualities = [45, 51, -1];

        CombinationApprovals::verifyAllCombinations3(
            function (string $name, int $sell_in, int $quality){
                $items = [new Item($name, $sell_in, $quality)];
                $gildedRose = new GildedRose($items);
                $gildedRose->updateQuality();        
                return $items[0]->__toString(); // return au lieu de approval verifyString ici
            },
            $names,
            $sellIns,
            $qualities
        );
    }

    // Principes
    /**
     * 1) On observe ce que le code renvoit en jouant un 1er test,
     * le resultat sera ecrit dans le .received.txt
     * on copie colle ce resultat dans .approved.txt
     * 
     * 2) On fait bien attention a tester tous les cas grace au code coverage
     * qui doit atteindre les 100%
     * 
     * 3) A chaque test lancé, la librairie comparera les resultats dans
     * received et approved (received est généré a chaque test, approved ne bouge pas)
     * et si on a un echec, c'est qu'on a modifier le comportement du code, on a fait une erreur
     */
}