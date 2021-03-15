<?php

namespace Sql;

class Condition implements Protocol\Sequel
{
    public const LIKE_BOTH = 'both';
    public const LIKE_LEFT = 'left';
    public const LIKE_NONE = 'none';
    public const LIKE_RIGHT = 'right';

    protected $leftHand;

    protected $operator;

    protected $option;

    protected $rightHand;

    public function __construct($leftHandValue)
    {
        $this->leftHand = $leftHandValue;
    }

    public function isEqualTo($rightHandValue)
    {
        $this->operator = '=';
        $this->option = null;
        $this->rightHand = $rightHandValue;
        return $this;
    }

    public function isGreaterThan($rightHandValue)
    {
        $this->operator = '>';
        $this->option = null;
        $this->rightHand = $rightHandValue;
        return $this;
    }

    public function isGreaterThanOrEqualTo($rightHandValue)
    {
        $this->operator = '>=';
        $this->option = null;
        $this->rightHand = $rightHandValue;
        return $this;
    }

    public function isLessThan($rightHandValue)
    {
        $this->operator = '<';
        $this->option = null;
        $this->rightHand = $rightHandValue;
        return $this;
    }

    public function isLessThanOrEqualTo($rightHandValue)
    {   
        $this->operator = '<=';
        $this->option = null;
        $this->rightHand = $rightHandValue;
        return $this;
    }

    public function isLike($rightHandValue, $option = self::LIKE_BOTH)
    {
        $this->operator = 'LIKE';
        $this->option = $option;
        $this->rightHand = $rightHandValue;
        return $this;
    }

    public function isNotEqualTo($rightHandValue)
    {
        $this->operator = '<>';
        $this->option = null;
        $this->rightHand = $rightHandValue;
        return $this;
    }

    public function isNotLike($rightHandValue, $option = self::LIKE_BOTH)
    {
        $this->operator = 'NOT LIKE';
        $this->option = $option;
        $this->rightHand = $rightHandValue;
        return $this;
    }

    public function toSql()
    {
        $rightHand = $this->rightHand;
        if (
            in_array($this->operator, ['LIKE', 'NOT LIKE']) &&
            $this->option != self::LIKE_NONE
        ) {
            switch ($this->option) {
                case self::LIKE_BOTH:
                    $rightHand = "%{$this->rightHand}%";
                    break;
                case self::LIKE_LEFT:
                    $rightHand = "%{$this->rightHand}";
                    break;
                case self::LIKE_RIGHT:
                    $rightHand = "{$this->rightHand}%";
                    break;
                default:
                    break;
            }
        }
        return "{$this->leftHand} {$this->operator} {$rightHand}";
    }
}
