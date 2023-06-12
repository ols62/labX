<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
final class User
{
  #[ORM\Id]
  #[ORM\Column(type: Types::BIGINT)]
  #[ORM\GeneratedValue(strategy: 'IDENTITY')]
  private int|null $id = null;
  #[ORM\Column(type: Types::STRING, length: 20)]
  private $username;
  #[ORM\Column(type: Types::STRING, length: 40)]
  private $password;
  #[ORM\Column(type: Types::STRING, length: 100)]
  private $email;
  #[ORM\Column(type: Types::BOOLEAN)]
  private $banned;
  #[ORM\Column(name: 'ban_reason', type: Types::STRING, length: 255)]
  private $banRreason;
  #[ORM\Column(type: Types::STRING, length: 34)]
  private $newpass;
  #[ORM\Column(name: 'newpass_key', type: Types::STRING, length: 32)]
  private $newpassKey;
  #[ORM\Column(name: 'newpass_time', type: Types::DATETIME_MUTABLE)]
  private $newpassTime;
  #[ORM\Column(name: 'last_ip', type: Types::STRING, length: 40)]
  private $lastIp;
  #[ORM\Column(name: 'last_login', type: Types::DATETIME_MUTABLE)]
  private $lastLogin;
  #[ORM\Column(type: Types::DATETIME_MUTABLE)]
  private $created;
  #[ORM\Column(type: Types::DATETIME_MUTABLE)]
  private $modified;

  public function toArray()
  {
    $array = array();
    foreach ($this as $key => $value) {
      if ($key != 'password') {
        $array += array("$key" => $value);
      }
    }
    return $array;
  }

  /**
   * @param mixed $username 
   * @return self
   */
  public function setUsername($username): self
  {
    $this->username = $username;
    return $this;
  }

  /**
   * @param mixed $password 
   * @return self
   */
  public function setPassword($password): self
  {
    $this->password = $password;
    return $this;
  }

  /**
   * @param mixed $email 
   * @return self
   */
  public function setEmail($email): self
  {
    $this->email = $email;
    return $this;
  }

  /**
   * @param mixed $banned 
   * @return self
   */
  public function setBanned($banned): self
  {
    $this->banned = $banned;
    return $this;
  }

  /**
   * @param mixed $banRreason 
   * @return self
   */
  public function setBanRreason($banRreason): self
  {
    $this->banRreason = $banRreason;
    return $this;
  }

  /**
   * @param mixed $newpass 
   * @return self
   */
  public function setNewpass($newpass): self
  {
    $this->newpass = $newpass;
    return $this;
  }

  /**
   * @param mixed $newpassKey 
   * @return self
   */
  public function setNewpassKey($newpassKey): self
  {
    $this->newpassKey = $newpassKey;
    return $this;
  }

  /**
   * @param mixed $newpassTime 
   * @return self
   */
  public function setNewpassTime($newpassTime): self
  {
    $this->newpassTime = $newpassTime;
    return $this;
  }

  /**
   * @param mixed $lastIp 
   * @return self
   */
  public function setLastIp($lastIp): self
  {
    $this->lastIp = $lastIp;
    return $this;
  }


  /**
   * @return |null
   */
  public function getId(): int|null
  {
    return $this->id;
  }

  /**
   * @return mixed
   */
  public function getUsername()
  {
    return $this->username;
  }

  /**
   * @return mixed
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * @param mixed $created 
   * @return self
   */
  public function setCreated($created): self
  {
    $this->created = $created;
    return $this;
  }
}