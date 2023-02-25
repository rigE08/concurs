<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="query">
        <?php
        function secondsToTime($seconds)
        {
            $hours = floor($seconds / (60 * 60));
            $divisor_for_minutes = $seconds % (60 * 60);
            $minutes = floor($divisor_for_minutes / 60);
            $divisor_for_seconds = $divisor_for_minutes % 60;
            $seconds = ceil($divisor_for_seconds);

            $obj = array(
                "h" => (int) $hours,
                "m" => (int) $minutes,
                "s" => (int) $seconds,
            );
            $time = $obj['h'] . " ore " . $obj['m'] . " min ";
            return $time;
        }

        $con = mysqli_connect("localhost", "root", "", "csgo");

        if ($con) {
        } else {
            die("Conexiune esuata. Eroare:" . mysqli_connect_error());
        }

        $steam1 = htmlspecialchars($_POST['steam1']);
        $steam2 = htmlspecialchars($_POST['steam2']);
        $steam3 = htmlspecialchars($_POST['steam3']);
        $steam4 = htmlspecialchars($_POST['steam4']);
        $steam5 = htmlspecialchars($_POST['steam5']);
        $steam6 = htmlspecialchars($_POST['steam6']);
        $steam7 = htmlspecialchars($_POST['steam7']);
        $steam8 = htmlspecialchars($_POST['steam8']);
        $steam9 = htmlspecialchars($_POST['steam9']);
        $steam10 = htmlspecialchars($_POST['steam10']);
        $steam11 = htmlspecialchars($_POST['steam11']);
        $selectedTop = $_POST['selectTop'];

        if ($selectedTop == 'score') {
            $showTitle = 'Top puncte';
        } elseif ($selectedTop == 'headshots') {
            $showTitle = 'Top headshots';
        } elseif ($selectedTop == 'knife') {
            $showTitle = 'Top cutite';
        } elseif ($selectedTop == 'connected') {
            $showTitle = 'Top ore';
        } elseif ($selectedTop == 'c4_exploded') {
            $showTitle = 'Top C4 Explodate';
        } elseif ($selectedTop == 'c4_defused') {
            $showTitle = 'Top C4 Dezamorsate';
        } else {
            $showTitle = 'EROARE TOP';
        }

        $filename = 'castigatoriConcurs.txt';
        $contents = file($filename);

        if (file_exists($filename)) {
            echo '
        <table>
        <thead>
        <tr>
        <th>Jucatori care au castigat</th>
        </tr>
        </thead>
        ';
            if ($selectedTop == 'score') {
                foreach ($contents as $line) {
                    $line = trim($line);
                    if (strpos($line, "PUNCTE") !== false) {
                        $data = str_replace('PUNCTE->', '', $line);
                        echo "<tbody>
                    <td>$data</td>
                    </tbody>";
                    }
                }
            } elseif ($selectedTop == 'headshots') {
                foreach ($contents as $line) {
                    $line = trim($line);
                    if (strpos($line, "HS") !== false) {
                        $data = str_replace(array('HS->', '='), '', $line);
                        echo "<tbody>
                    <td>$data</td>
                    </tbody>";
                    }
                }
            } elseif ($selectedTop == 'knife') {
                foreach ($contents as $line) {
                    $line = trim($line);
                    if (strpos($line, "CUTITE") !== false) {
                        $data = str_replace(array('CUTITE->', '='), '', $line);
                        echo "<tbody>
                    <td>$data</td>
                    </tbody>";
                    }
                }
            } elseif ($selectedTop == 'connected') {
                foreach ($contents as $line) {
                    $line = trim($line);
                    if (strpos($line, "ORE") !== false) {
                        $data = str_replace(array('ORE->', '='), '', $line);
                        echo "<tbody>
                    <td>$data</td>
                    </tbody>";
                    }
                }
            } elseif ($selectedTop == 'c4_exploded') {
                foreach ($contents as $line) {
                    $line = trim($line);
                    if (strpos($line, "C4EXP") !== false) {
                        $data = str_replace(array('C4EXP->', '='), '', $line);
                        echo "<tbody>
                    <td>$data</td>
                    </tbody>";
                    }
                }
            } elseif ($selectedTop == 'c4_defused') {
                foreach ($contents as $line) {
                    $line = trim($line);
                    if (strpos($line, "C4DEF") !== false) {
                        $data = str_replace(array('C4DEF->', '='), '', $line);
                        echo "<tbody>
                    <td>$data</td>
                    </tbody>";
                    }
                }
            }
            echo '</table>';
        }

        $query1 = "SELECT steam,name,score,headshots,knife,connected,c4_exploded,c4_defused
                FROM `rankme`
                WHERE steam !='" . $steam1 . "'
                AND steam !='" . $steam2 . "'
                AND steam !='" . $steam3 . "'
                AND steam !='" . $steam4 . "'
                AND steam !='" . $steam5 . "'
                AND steam !='" . $steam6 . "'
                AND steam !='" . $steam7 . "'
                AND steam !='" . $steam8 . "'
                AND steam !='" . $steam9 . "'
                AND steam !='" . $steam10 . "'
                AND steam !='" . $steam11 . "'
                ORDER BY " . $selectedTop . " DESC
                LIMIT 20";

        $result = mysqli_query($con, $query1);
        if (mysqli_num_rows($result) > 0) {
            $counter = 0; ?>
            <div class="tableInfo">
                <div class="title">
                    <h1><?= $showTitle ?></h1>
                    <a class="btn" href="index.php">Inapoi</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Steam</th>
                            <th>Nume</th>
                            <th>Puncte</th>
                            <th>Ore</th>
                            <th>HS</th>
                            <th>Cutite</th>
                            <th>C4EXP</th>
                            <th>C4DEF</th>
                        </tr>
                    </thead>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $counter++;
                    ?>

                        <tbody>
                            <tr>
                                <td><?= $counter ?></td>
                                <td><?= $row['steam'] ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['score'] ?></td>
                                <td><?= secondsToTime($row['connected']) ?></td>
                                <td><?= $row['headshots'] ?></td>
                                <td><?= $row['knife'] ?></td>
                                <td><?= $row['c4_exploded'] ?></td>
                                <td><?= $row['c4_defused'] ?></td>
                            </tr>

                        </tbody>



                <?php
                    }
                } ?>
                </table>

                <!-- STEAMIDS EXCLUSE -->
                <?php
                $query2 = "SELECT steam,name,score,headshots,knife,connected,c4_exploded,c4_defused
                FROM `rankme`
                WHERE steam ='" . $steam1 . "'
                OR steam ='" . $steam2 . "'
                OR steam ='" . $steam3 . "'
                OR steam ='" . $steam4 . "'
                OR steam ='" . $steam5 . "'
                OR steam ='" . $steam6 . "'
                OR steam ='" . $steam7 . "'
                OR steam ='" . $steam8 . "'
                OR steam ='" . $steam9 . "'
                OR steam ='" . $steam10 . "'
                OR steam ='" . $steam11 . "'
                ORDER BY " . $selectedTop . " DESC";

                $result2 = mysqli_query($con, $query2);
                if (mysqli_num_rows($result2) > 0) {
                    $counter2 = 0; ?>
                    <h1>STEAM ID EXCLUSE</h1>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Steam</th>
                                <th>Nume</th>
                                <th>Puncte</th>
                                <th>Ore</th>
                                <th>HS</th>
                                <th>Cutite</th>
                                <th>C4EXP</th>
                                <th>C4DEF</th>
                            </tr>
                        </thead>
                        <?php
                        while ($row = mysqli_fetch_assoc($result2)) {
                            $counter2++;
                        ?>

                            <tbody>
                                <tr>
                                    <td><?= $counter2 ?></td>
                                    <td><?= $row['steam'] ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['score'] ?></td>
                                    <td><?= secondsToTime($row['connected']) ?></td>
                                    <td><?= $row['headshots'] ?></td>
                                    <td><?= $row['knife'] ?></td>
                                    <td><?= $row['c4_exploded'] ?></td>
                                    <td><?= $row['c4_defused'] ?></td>
                                </tr>

                            </tbody>



                    <?php
                        }
                    } ?>
                    </table>
            </div>
    </div>
</body>

</html>