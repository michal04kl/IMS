<?php
$sort_a = "";
$sort_c = "";
$sort_w = "";
$sort_d = "";
$offset = 0;
if (isset($_POST['offset_in'])) {
    $offset = $_POST['offset_in'];
}
if (isset($_POST['sort_in'])) {
    $sql = "SELECT * FROM interns WHERE `status`='" . $_POST['sort_in'] . "' LIMIT 5 OFFSET $offset;";
    if ($_POST['sort_in'] == "completed") {
        $sort_c = "checked='checked'";
    } else if ($_POST['sort_in'] == "waiting") {
        $sort_w = "checked='checked'";
    } else if ($_POST['sort_in'] == "declined") {
        $sort_d = "checked='checked'";
    } else {
        $sql = "SELECT * FROM interns LIMIT 5 OFFSET $offset;";
        $sort_a = "checked='checked'";
    }
} else {
    $sql = "SELECT * FROM interns LIMIT 5 OFFSET $offset;";
    $sort_a = "checked='checked'";
}

echo "<table id='interns'>
<tr>
    <th>check</th>
    <th>mail</th>
    <th>name</th>
    <th>surname</th>
    <th>deadline</th>
    <th>status:
    <br>
    <form id='sort_i'>
    <div><input type='radio' id='by_acc' class='sort_in' name='sort_in' value='completed' " . $sort_c . "><label for='by_acc'>Completed</label></div>
    <div><input type='radio' id='by_wait' class='sort_in' name='sort_in' value='waiting' " . $sort_w . "><label for='by_wait'>Waiting</label></div>
    <div><input type='radio' id='by_dec' class='sort_in' name='sort_in' value='declined' " . $sort_d . "><label for='by_dec'>Declined</label></div>
    <div><input type='radio' id='by_all' class='sort_in' name='sort_in' value='all' " . $sort_a . "><label for='by_all'>All</label></div>
    </form>
    </th>
    <th>recruitment task</th>
</tr>
";

include $_SERVER['DOCUMENT_ROOT'] . "/main/in/dbset/dbset.php";
$data = mysqli_connect($server, $user, $pass, $base) or die('connection error');
$res = $data->query($sql) or die('base error');

date_default_timezone_set('Europe/Warsaw');

while ($line = $res->fetch_assoc()) {
    $color = "";
    $text = "";
    $l = "<td><input type='checkbox' id='" . $line['ID'] . "' class='intern_box' value='" . $line['name'] . " " . $line['surn'] . "' ></td>";
    $l .= "<td><a href='mailto:" . $line['mail'] . "'>" . $line['mail'] . "</a></td>";
    $l .= "<td>" . $line['name'] . "</td>";
    $l .= "<td>" . $line['surn'] . "</td>";
    
    if ($line['deadline'] != NULL) {
        $l .= "<td>" . $line['deadline'] . "</td>";
    } else {
        $l .= "<td> - </td>";
    }
    
    if ($line['status'] == 'waiting' && !empty($line['quest'])) {
        $sql_update = "UPDATE interns SET status = 'completed' WHERE id = " . $line['ID'] . ";";
        $data->query($sql_update) or die('base error');
        $line['status'] = 'completed';
    }
    
    if ($line['deadline'] != NULL) {
        try {
            $dbdate = new DateTime($line['deadline']);
        } catch (Exception $e) {
            echo "Niepoprawny format daty: " . $e->getMessage();
            exit;
        }
        $now = new DateTime();
        
        if ($line['status'] == 'waiting' && $dbdate < $now) {
            $sql2 = "UPDATE interns SET status = 'declined' WHERE id = " . $line['ID'] . ";";
            $data->query($sql2) or die('base error');
            $l .= "<td>declined</td>";
            $color = "#ff0000";
            $text = "#ffffff";
            $l .= "<td> - </td>";
        } else {
            if ($line['status'] == 'waiting') {
                $color = "#FFFF00";
                $text = "#000000";
                $l .= "<td>waiting</td>";
                $l .= "<td> - </td>";
            } else if ($line['status'] == 'declined') {
                $color = "#ff0000";
                $text = "#ffffff";
                $l .= "<td>declined</td>";
                $l .= "<td> - </td>";
            } else {
                $color = "#00ff00";
                $text = "#000000";
                $l .= "<td>completed</td>";
                $path = $_SERVER['DOCUMENT_ROOT'] . "/main/in/api/data/interns/" . $line['ID'];
                if (!is_dir($path)) {
                    if (!mkdir($path, 0777, true)) {
                        die("can't create download folder for " . $line['ID']);
                    } else {
                        $link = $line['quest'];
                        $branches = ['master', 'main'];
                        $zip_path = $path . "/" . $line['ID'] . "_" . $line['surn'] . ".zip";
                        $success = false;
                        foreach ($branches as $branch) {
                            $zip_link = rtrim($link, '/') . '/archive/refs/heads/' . $branch . '.zip';
                            $result = download($zip_link, $zip_path);
                            $http = $result['httpCode'];
                            $size = file_exists($zip_path) ? filesize($zip_path) : 0;
                            if ($http === 200 && $size > 0) {
                                $success = true;
                                break;
                            } else {
                                if (file_exists($zip_path)) {
                                    unlink($zip_path);
                                }
                            }
                        }
                        if (!$success) {
                            die("can't download repository for " . $line['ID']);
                        }
                    }
                    $l .= "<td><a href='" . "/main/in/api/data/interns/".$line['ID']."/" . $line['ID'] . "_" . $line['surn'] . ".zip' download>download project</a></td>";
                } else {
                    $l .= "<td><a href='" . "/main/in/api/data/interns/" .$line['ID']."/". $line['ID'] . "_" . $line['surn'] . ".zip' download>download project</a></td>";
                }
            }
        }
    } else {
        if ($line['status'] == 'waiting') {
            $l .= "<td>waiting</td>";
            $l .= "<td> - </td>";
        } else if ($line['status'] == 'declined') {
            $l .= "<td>declined</td>";
            $l .= "<td> - </td>";
        } else {
            $color = "#00ff00";
            $text = "#000000";
            $l .= "<td>completed</td>";
            $path = $_SERVER['DOCUMENT_ROOT'] . "/main/in/api/data/interns/" . $line['ID'];
            if (!is_dir($path)) {
                if (!mkdir($path, 0777, true)) {
                    die("can't create download folder for " . $line['ID']);
                } else {
                    $link = $line['quest'];
                    $branches = ['master', 'main'];
                    $zip_path = $path . "/" . $line['ID'] . "_" . $line['surn'] . ".zip";
                    $success = false;
                    foreach ($branches as $branch) {
                        $zip_link = rtrim($link, '/') . '/archive/refs/heads/' . $branch . '.zip';
                        $result = download($zip_link, $zip_path);
                        $http = $result['httpCode'];
                        $size = file_exists($zip_path) ? filesize($zip_path) : 0;
                        if ($http === 200 && $size > 0) {
                            $success = true;
                            break;
                        } else {
                            if (file_exists($zip_path)) {
                                unlink($zip_path);
                            }
                        }
                    }
                    if (!$success) {
                        die("can't download repository for " . $line['ID']);
                    }
                }
                $l .= "<td><a href='" . "/main/in/api/data/interns/" .$line['ID']."/". $line['ID'] . "_" . $line['surn'] . ".zip' download>download project</a></td>";
            } else {
                $l .= "<td><a href='" . "/main/in/api/data/interns/" .$line['ID']."/". $line['ID'] . "_" . $line['surn'] . ".zip' download>download project</a></td>";
            }
        }
    }
    
    if ($color != "") {
        $all = "<tr style='background-color:" . $color . "; color:" . $text . ";'>" . $l . "</tr>";
    } else {
        $all = "<tr>" . $l . "</tr>";
    }
    echo $all;
}

$sql3 = "SELECT COUNT(*) AS lp FROM interns;";
$res = $data->query($sql3) or die('base error');
while ($line = $res->fetch_assoc()) {
    $max_nr = $line['lp'];
}
$data->close();

echo "<div id='intern_pagin' data-offset='$offset' data-off_max='$max_nr' style='width:100%; display: flex; flex-direction: row; justify-content: space-evenly'>
    <button id='down_pagin' value='5'><i class='fa-solid fa-arrow-left'></i></button>
    <button id='up_pagin' value='5'><i class='fa-solid fa-arrow-right'></i></button>
</div>";
echo "</table>";

function download($zip_link, $zip_path) {
    $ch = curl_init($zip_link);
    $fp = fopen($zip_path, 'wb');
    if (!$fp) {
        die('File error on: ' . $zip_path);
    }
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_exec($ch);
    $error = curl_error($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    fclose($fp);
    return ['httpCode' => $http, 'error' => $error];
}
?>
