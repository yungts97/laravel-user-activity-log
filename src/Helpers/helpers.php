<?php
if (! function_exists('is_year')) {
    /**
     * Validate the value of the given is whether a valid year.
     *
     * @param  mixed  $value
     * @return bool
     */
    function is_year($value = null)
    {
        return is_numeric($value) && (+$value >= 1950 && +$value <= 2200);
    }
}
if (! function_exists('is_month')) {
    /**
     * Validate the value of the given is whether a valid month.
     *
     * @param  mixed  $value
     * @return bool
     */
    function is_month($value = null)
    {
        return is_numeric($value) && (+$value >= 1 && +$value <= 12);
    }
}
if (! function_exists('is_month_year')) {
    /**
     * Validate the value of the given is whether a valid month year.
     *
     * @param  mixed  $value
     * @return bool
     */
    function is_month_year($value = null)
    {
        $month_year = explode('/', $value);
        if(count($month_year) !== 2) return false;

        [$month, $year] = $month_year;
        return is_month($month) && is_year($year);
    }
}
if (! function_exists('is_date')) {
    /**
     * Validate the value of the given is whether a valid date.
     *
     * @param  mixed  $value
     * @return bool
     */
    function is_date($value = null)
    {
        $date = explode('/', $value);
        if(count($date) !== 3) return false;

        [$day, $month, $year] = $date;
        return checkdate($month, $day, $year);
    }
}
if (! function_exists('toYmd')) {
    /**
     * Convert date to Y-m-d format
     *
     * @param  mixed  $value
     * @return bool
     */
    function toYmd($value = null)
    {
        if(!is_date($value)) return null;

        $date = explode('/', $value);
        [$day, $month, $year] = $date;
        return "$year-$month-$day";
    }
}
if (! function_exists('filter_empty')) {
    /**
     * Validate the value of the given is whether a valid date.
     *
     * @param  mixed  $value
     * @return array
     */
    function filter_empty($value = null)
    {
        return array_filter($value, fn($item) => !is_null($item) && $value !== '');
    }
}
if (! function_exists('get_key')) {
    /**
     * This only works for the array which only contains one item.
     *
     * @param  mixed  $value
     * @return string | null
     */
    function get_key($value = null)
    {
        return array_keys($value)[0] ?? null;
    }
}

