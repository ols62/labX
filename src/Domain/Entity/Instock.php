<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;


#[ORM\Entity]
#[ORM\Table(name: 'instock')]
final class Instock
{
  #[ORM\Id]
  #[ORM\Column(type: Types::BIGINT)]
  #[ORM\GeneratedValue]
  private int|null $id = null;
  #[ORM\Column(type: 'string')]
  private $model;
  #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
  private $price;
  #[ORM\Column(name: 'length_in', type: Types::SMALLINT)]
  private $lengthIn;
  #[ORM\Column(name: 'length_out', type: Types::SMALLINT)]
  private $lengthOut;
  #[ORM\Column(name: 'width_in', type: Types::SMALLINT)]
  private $widthIn;
  #[ORM\Column(name: 'width_out', type: Types::SMALLINT)]
  private $widthOut;
  #[ORM\Column(name: 'board_height', type: Types::SMALLINT)]
  private $boardHeight;
  #[ORM\Column(name: 'awning_height_tn', type: Types::SMALLINT)]
  private $awningHeightTn;
  #[ORM\Column(name: 'awning_height_fl', type: Types::SMALLINT)]
  private $awningHeightFl;
  #[ORM\Column(name: 'total_height', type: Types::SMALLINT)]
  private $totalHeight;
  #[ORM\Column(name: 'total_weight', type: Types::SMALLINT)]
  private $totalWeight;
  #[ORM\Column(name: 'self_weight', type: Types::SMALLINT)]
  private $selfWeight;
  #[ORM\Column(type: Types::BIGINT)]
  private $tires;
  #[ORM\Column(type: Types::STRING, length: 100)]
  private $image;
  #[ORM\Column(name: 'id_type', type: Types::BIGINT)]
  private $idType;
  #[ORM\Column(type: Types::BIGINT)]
  private $color;
  #[ORM\Column(type: 'datetime')]
  private $made;
  #[ORM\Column(type: Types::STRING, length: 17)]
  private $win;
  #[ORM\Column(type: Types::BOOLEAN)]
  private $visibility;
  #[ORM\Column(type: Types::INTEGER)]
  private $viewnum;
  #[ORM\Column(name: 'user_id', type: Types::BIGINT)]
  private $userId;
  #[ORM\Column(type: Types::DATETIME_MUTABLE)]
  private $modified;
  #[ORM\Column(type: 'string')]
  private $addinfo;

  public function toArray()
  {
    $array = array();
    foreach ($this as $key => $value) {
      $array += array("$key" => $value);
    }
    return $array;
  }



}