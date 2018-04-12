<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class CovertFormEntity
{
    private $from;
    private $to;

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     */
    private $value;

    public function getFrom()
    {
        return $this->from;
    }

    public function setFrom($from)
    {
        $this->from = $from;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function setTo($to)
    {
        $this->to = $to;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}