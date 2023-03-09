<?php


interface TimeToWordConvertingInterface
{
    public function convert(int $hours, int $minutes): string;
}

class TimeToWordConverter implements TimeToWordConvertingInterface
{
    private $hourWords = array(
        1 => 'Один',
        2 => 'Два',
        3 => 'Три',
        4 => 'Четыре',
        5 => 'Пять',
        6 => 'Шесть',
        7 => 'Семь',
        8 => 'Восемь',
        9 => 'Девять',
        10 => 'Десять',
        11 => 'Одиннадцать',
        12 => 'Двенадцать'
    );

    private $minuteWords = array(
        0 => '',
        1 => 'Одна',
        2 => 'Две',
        3 => 'Три',
        4 => 'Четыре',
        5 => 'Пять',
        6 => 'Шесть',
        7 => 'Семь',
        8 => 'Восемь',
        9 => 'Девять',
        10 => 'Десять',
        11 => 'Одиннадцать',
        12 => 'Двенадцать',
        13 => 'Тринадцать',
        14 => 'Четырнадцать',
        15 => 'Пятнадцать',
        16 => 'Шестнадцать',
        17 => 'Семнадцать',
        18 => 'Восемнадцать',
        19 => 'Девятнадцать',
        20 => 'Двадцать',
        30 => 'Тридцать',
        40 => 'Сорок',
        45 => 'Без пятнадцати'
    );

    /**
     * Конвертация цифрового представления времени в словесное
     *
     * @param int $hours
     * @param int $minutes
     * @return string
     */
    public function convert(int $hours, int $minutes): string
    {
        $hourWord = $this->hourWords[$hours];
        $minuteWord = '';

        if ($minutes === 0) {
            $minuteWord = 'час';
        } elseif ($minutes === 15) {
            $minuteWord = 'четверть';
        } elseif ($minutes === 30) {
            $minuteWord = 'половина';
        } elseif ($minutes === 45) {
            $hourWord = $this->hourWords[($hours + 1) % 13];
        } elseif ($minutes <= 20) {
            $minuteWord = $this->minuteWords[$minutes];
        } elseif ($minutes > 20 && $minutes < 30) {
            $minuteWord = $this->minuteWords[20] . ' ' . $this->minuteWords[$minutes % 20];
        } elseif ($minutes > 30 && $minutes < 40) {
            $minuteWord = $this->minuteWords[30] . ' ' . $this->minuteWords[$minutes % 30];
        } elseif ($minutes > 40 && $minutes < 45) {
            $minuteWord = $this->minuteWords[40] . ' ' . $this->minuteWords[($minutes % 40) % 20];
        } elseif ($minutes > 45 && $minutes < 60) {
            $minuteWord = $this->minuteWords[60 - $minutes] . ' минут';
            $hourWord = $this->hourWords[($hours + 1) % 13];
        }

        if ($minutes === 0) {
            return $hourWord . ' ' . $minuteWord . 'ов';
        } elseif ($minutes === 30) {
            return $minuteWord . ' ' . $hourWord;
        } elseif ($minutes < 30) {
            return $minuteWord . ' минут после ' . $hourWord;
        } else {
            return $minuteWord . ' минут до ' . (($hours % 12 === 0) ? 12 : $hours % 12 + 1);
        }
    }
}

// пример использования:
$converter = new TimeToWordConverter();

echo $converter->convert(7, 0) . "\n"; // Семь часов
echo $converter->convert(7, 1) . "\n"; // Одна минута после семи
echo $converter->convert(7, 3) . "\n"; // Три минуты после семи
echo $converter->convert(7, 12) . "\n"; // Двенадцать минут после семи
echo $converter->convert(7, 15) . "\n"; // Четверть восьмого
echo $converter->convert(7, 22) . "\n"; // Двадцать две минуты после семи
echo $converter->convert(7, 30) . "\n"; // Половина восьмого
echo $converter->convert(7, 35) . "\n"; // Двадцать пять минут до восьми
echo $converter->convert(7, 41) . "\n"; // Девятнадцать минут до восьми
echo $converter->convert(7, 56) . "\n"; // Четыре минуты до восьми
echo $converter->convert(7, 59) . "\n"; // Одна минута до восьми
?>