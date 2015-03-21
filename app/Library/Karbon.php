<?php namespace App\Library;

use Carbon\Carbon;

/**
 * Karbon is a dutch wrapper around the original Carbon class.
 *
 * Class Karbon
 * @package App\Library
 */
class Karbon extends Carbon
{
    public function format($format)
    {
        return $this->translate(parent::format($format));
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

    private static function getDaysDifference(\DateTime $dt)
    {
        $diff = (new self($dt))->setTime(0, 0, 0)->format('U') - (new self('today'))->format('U');

        return $diff / 86400;
    }

    protected function translate($string)
    {
        $string = $this->replaceDays($string);
        $string = $this->replaceMonths($string);

        return $string;
    }

    protected function replaceDays($string)
    {
        $english = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $dutch = ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'];

        return str_replace($english, $dutch, $string);
    }

    protected function replaceMonths($string)
    {
        $english = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'December'];
        $dutch = ['januari', 'februari', 'maart', 'april', 'mei', 'juni', 'juli', 'augustus', 'september', 'oktober', 'december'];

        return str_replace($english, $dutch, $string);
    }
}