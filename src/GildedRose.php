<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    /**
     * @param Item[] $items
     */
    public function __construct(
        private array $items
    ) {
    }

    // public function updateQuality(): void
    // {
    //     foreach ($this->items as $item) {
    //         if ($item->name != 'Aged Brie' and $item->name != 'Backstage passes to a TAFKAL80ETC concert') {
    //             if ($item->quality > 0) {
    //                 if ($item->name != 'Sulfuras, Hand of Ragnaros') {
    //                     $item->quality = $item->quality - 1;
    //                 }
    //             }
    //         } else {
    //             if ($item->quality < 50) {
    //                 $item->quality = $item->quality + 1;
    //                 if ($item->name == 'Backstage passes to a TAFKAL80ETC concert') {
    //                     if ($item->sellIn < 11) {
    //                         if ($item->quality < 50) {
    //                             $item->quality = $item->quality + 1;
    //                         }
    //                     }
    //                     if ($item->sellIn < 6) {
    //                         if ($item->quality < 50) {
    //                             $item->quality = $item->quality + 1;
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         if ($item->name != 'Sulfuras, Hand of Ragnaros') {
    //             $item->sellIn = $item->sellIn - 1;
    //         }

    //         if ($item->sellIn < 0) {
    //             if ($item->name != 'Aged Brie') {
    //                 if ($item->name != 'Backstage passes to a TAFKAL80ETC concert') {
    //                     if ($item->quality > 0) {
    //                         if ($item->name != 'Sulfuras, Hand of Ragnaros') {
    //                             $item->quality = $item->quality - 1;
    //                         }
    //                     }
    //                 } else {
    //                     $item->quality = $item->quality - $item->quality;
    //                 }
    //             } else {
    //                 if ($item->quality < 50) {
    //                     $item->quality = $item->quality + 1;
    //                 }
    //             }
    //         }
    //     }
    // }

    const AGED_BRIE = 'Aged Brie';
    const BACKSTAGE = 'Backstage passes to a TAFKAL80ETC concert';
    const SULFURAS = 'Sulfuras, Hand of Ragnaros';


    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            /** @var Item $item */
            if (!in_array($item->name, [self::AGED_BRIE, self::BACKSTAGE])) {
                if ($item->quality > 0) {
                    if ($item->name != self::SULFURAS) {
                        $item->quality--;
                    }
                }
            } else {
                if ($item->quality < 50) {
                    $item->quality++;
                    if ($item->name == self::BACKSTAGE) {
                        if ($item->sellIn < 11) {
                            $this->incrementQualityIfInferiorToFifty($item);
                        }
                        if ($item->sellIn < 6) {
                            $this->incrementQualityIfInferiorToFifty($item);
                        }
                    }
                }
            }

            if ($item->name != self::SULFURAS) {
                $item->sellIn--;
            }

            // finir ici
            if ($item->sellIn < 0) {
                if ($item->name != self::AGED_BRIE) {
                    if ($item->name != self::BACKSTAGE) {
                        if ($item->quality > 0) {
                            if ($item->name != self::SULFURAS) {
                                $item->quality--;
                            }
                        }
                    } else {
                        $item->quality = 0;
                    }
                } else {
                    $this->incrementQualityIfInferiorToFifty($item);
                }
            }
        }
    }

    private function updateQualityAgedBrie(Item $item): void
    {
        $this->incrementQualityIfInferiorToFifty($item);
        $item->sellIn--;

        if($item->sellIn < 0){
            $this->incrementQualityIfInferiorToFifty($item);
        }
    }

    private function updateQualityBackstage(Item $item): void
    {
        $this->incrementQualityIfInferiorToFifty($item);

        if ($item->sellIn < 11) {
            $this->incrementQualityIfInferiorToFifty($item);
        }

        if ($item->sellIn < 6) {
            $this->incrementQualityIfInferiorToFifty($item);
        }

        $item->sellIn--;
        $item->quality = 0;
    }

    private function updateQualitySulfuras(Item $item): void
    {
        
    }

    private function updateQualityOther(Item $item): void
    {
        if ($item->quality > 0) {
            $item->quality--;
        }

        $item->sellIn--;

        if ($item->sellIn < 0 && $item->quality > 0) {
            $item->quality--;
        }
    }

    private function incrementQualityIfInferiorToFifty(Item $item): void
    {
        if ($item->quality < 50) {
            $item->quality++;
        }
    }

}