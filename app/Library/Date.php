<?php namespace App\Library;

class Date extends \DateTime
{
    private static $dateFormat = 'd-m-Y';
    private static $timeFormat = 'H:i';

    public function __construct($time = 'now', $timezone = null)
    {
        if (self::isTimestamp($time))
        {
            $time = '@'.$time;
        }

        parent::__construct($time, $timezone);
    }

    public static function isTimestamp($value)
    {
        if (!is_numeric($value))
        {
            return false;
        }

        if (8 === strlen((string) $value))
        {
            return false;
        }

        $stamp = strtotime($value);

        if (false === $stamp)
        {
            return true;
        }

        $month = date('m', $value);
        $day   = date('d', $value);
        $year  = date('Y', $value);

        return checkdate($month, $day, $year);
    }

    public static function getInstance($time = 'now', $timezone = null)
    {
        if (is_null($time) || in_array($time, array('0000-00-00 00:00:00', '0000-00-00', '00:00:00')))
        {
            return null;
        }

        return new DateTime($time, $timezone);
    }

    public function toHumanFormat()
    {
        $daysDifference = $this->getDaysDifference($this);

        if ($daysDifference == 0)
        {
            return 'Vandaag';
        }
        if ($daysDifference == 1)
        {
            return 'Morgen';
        }
        if ($daysDifference == 2)
        {
            return 'Overmorgen';
        }

        return $this->format('j F');
    }

    public static function fromFormat($time, $format)
    {
        $instance = self::createFromFormat($format, $time);

        return new static($instance->format('Y-m-d H:i:s'));
    }

    public static function datetime($time = 'now', $format = null, $timezone = null)
    {
        $dt = new self($time, $timezone);

        switch ($format)
        {
            case 'human':
                return __('$1 at $2', self::humanDate($dt), self::humanTime($dt));
            case 'human_date':
                return self::humanDate($dt);
            case 'human_time':
                return self::humanTime($dt);
            case 'date':
                return $dt->format(self::getDateFormat());
            case 'time':
                return $dt->format(self::getTimeFormat());
            case 'year':
                return $dt->format('Y');
            case 'iso':
                return $dt->format('c');
            default:
                return $dt->format(self::getDateTimeFormat());
        }
    }

    public static function humanDate(\DateTime $dt)
    {
        $days = self::getDaysDifference($dt);

        if ($days == 0)
        {
            $date = __('Today');
        }
        elseif ($days == 1)
        {
            $date = __('Yesterday');
        }
        elseif ($days < 7)
        {
            $date = __($dt->format('l'));
        }
        else
        {
            switch (substr(self::getDateFormat(), 0, 1))
            {
                case 'Y':
                    $date = $dt->format('Y').' '.__($dt->format('M')).' '.$dt->format('j');
                    break;
                case 'm':
                    $date = __($dt->format('M')).' '.$dt->format('j').', '.$dt->format('Y');
                    break;
                default:
                    $date = $dt->format('j').' '.__($dt->format('M')).' '.$dt->format('Y');
            }
        }

        return $date;
    }

    private static function getDaysDifference(\DateTime $dt)
    {
        $diff = (new self($dt))->setTime(0, 0, 0)->format('U') - (new self('today'))->format('U');

        return $diff / 86400;
    }

    public function format($format)
    {
        switch ($format)
        {
            case 'beginning_of_day':
                return parent::format('Y-m-d 00:00:00');
            case 'end_of_day':
                return parent::format('Y-m-d 23:59:59');
            case 'human_date':
                return self::humanDate($this);
            case 'human_time':
                return self::humanTime($this);
            case 'human':
                return self::humanDateTime($this);
            case 'datetime':
                return parent::format(self::getDateTimeFormat());
            case 'date':
                return parent::format(self::getDateFormat());
            case 'time':
                return parent::format(self::getTimeFormat());
            default:
                return parent::format($format);
        }
    }

    public static function humanTime(\DateTime $dt)
    {
        return $dt->format(self::getTimeFormat());
    }

    public static function getTimeFormat()
    {
        return self::$timeFormat;
    }

    public static function setTimeFormat($format)
    {
        self::$timeFormat = $format;
    }

    public static function humanDateTime(\DateTime $dt)
    {
        return __('$1 at $2', self::humanDate($dt), self::humanTime($dt));
    }

    public static function getDateTimeFormat()
    {
        return self::getDateFormat().' '.self::getTimeFormat();
    }

    public static function getDateFormat()
    {
        return self::$dateFormat;
    }

    public static function setDateFormat($format)
    {
        self::$dateFormat = $format;
    }

    public static function isDate($value)
    {
        if (strlen($value) == 10 && substr_count($value, '-') == 2)
        {
            list($year, $month, $day) = explode('-', $value);

            return checkdate($month, $day, $year);
        }

        return false;
    }

    private static function getYearsDifference(\DateTime $dt)
    {
        return (new self('today'))->format('Y') - (new self($dt))->setTime(0, 0, 0)->format('Y');
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function toString()
    {
        return $this->format('Y-m-d H:i:s');
    }
}
