<?php
class VerifyDate
{
    private $dateStart;
    private $dateEnd;
    private $bornDate;

    function __construct($dateStart, $dateEnd, $bornDate)
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->bornDate = $bornDate;
    }

    public function formatDates()
    {
        $this->bornYear = explode("-", $this->bornDate)[0];
        $this->dateStart = explode("/", $this->dateStart);
        $this->dateEnd = explode("/", $this->dateEnd);

        return $this;
    }

    public function preparingDates()
    {
        $this->bornDate = new DateTime($this->bornDate);

        $dayStart = $this->dateStart[0];
        $monthStart = $this->dateStart[1];

        $dayEnd = $this->dateEnd[0];
        $monthEnd = $this->dateEnd[1];


        $this->dateStart = new DateTime("{$this->bornYear}-{$monthStart}-{$dayStart}");
        $this->dateEnd = new DateTime("{$this->bornYear}-{$monthEnd}-{$dayEnd}");

        return $this;
    }

    public function dateIsInBetween()
    {
        $dateStartTimeStamp = $this->dateStart->getTimestamp();
        $bornDateTimeStamp = $this->bornDate->getTimestamp();
        $dateEndTimeStamp = $this->dateEnd->getTimestamp();

        if ($dateStartTimeStamp <= $bornDateTimeStamp && $dateEndTimeStamp >= $bornDateTimeStamp) {
            return true;
        }

        return false;
    }
}

date_default_timezone_set('America/Sao_Paulo');
session_start();
$bornDate = $_POST['bornDate'];

if (is_string($bornDate) && !empty($bornDate)) {
    $xml = simplexml_load_file("signos.xml");
    $xmlToJson = json_decode(json_encode($xml), TRUE);
    $signos = $xmlToJson['signo'];

    foreach ($signos as $signo) {
        $dateStart = $signo['dataInicio'];
        $dateEnd = $signo['dataFim'];

        $verifyDate = new VerifyDate($dateStart, $dateEnd, $bornDate);

        $isDateBetween = $verifyDate
            ->formatDates()
            ->preparingDates()
            ->dateIsInBetween();

        if ($isDateBetween) {
            var_dump($signo);
            $_SESSION['signo'] = $signo;
        }
    }
} else {
    $_SESSION['signo'] = "";
}

header("Location: index.php");
exit;
