<?php

function currency($amount)
{
    $converted = (float) $amount / (float) config('currency.conversion');
    return config('currency.before') .''. number_format($converted, 2) . config('currency.after');
}

function currency_without_name($amount)
{
    $converted = (float) $amount / (float) config('currency.conversion');
    return  number_format($converted, 2);
}

function percentOf($percent, $number)
{
    return $number * ($percent / 100);
}

function recursive_directory_size($directory, $format = FALSE)
{
    $size = 0;

    // if the path has a slash at the end we remove it here
    if (substr($directory, -1) == '/') {
        $directory = substr($directory, 0, -1);
    }

    // if the path is not valid or is not a directory ...
    if (!file_exists($directory) || !is_dir($directory) || !is_readable($directory)) {
        // ... we return -1 and exit the function
        return -1;
    }
    // we open the directory
    if ($handle = opendir($directory)) {
        // and scan through the items inside
        while (($file = readdir($handle)) !== false) {
            // we build the new path
            $path = $directory . '/' . $file;

            // if the filepointer is not the current directory
            // or the parent directory
            if ($file != '.' && $file != '..') {
                // if the new path is a file
                if (is_file($path)) {
                    // we add the filesize to the total size
                    $size += filesize($path);

                    // if the new path is a directory
                } elseif (is_dir($path)) {
                    // we call this function with the new path
                    $handlesize = recursive_directory_size($path);

                    // if the function returns more than zero
                    if ($handlesize >= 0) {
                        // we add the result to the total size
                        $size += $handlesize;

                        // else we return -1 and exit the function
                    } else {
                        return -1;
                    }
                }
            }
        }
        // close the directory
        closedir($handle);
    }
    // if the format is set to human readable
    if ($format == TRUE) {
        // if the total size is bigger than 1 MB
        if ($size / 1048576 > 1) {
            return round($size / 1048576, 1) . ' MB';

            // if the total size is bigger than 1 KB
        } elseif ($size / 1024 > 1) {
            return round($size / 1024, 1) . ' KB';

            // else return the filesize in bytes
        } else {
            return round($size, 1) . ' bytes';
        }
    } else {
        // return the total filesize in bytes
        return $size;
    }
}

function monthsArray()
{
    return [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];
}


function byteFormat($bytes, $unit = "", $decimals = 0)
{
    $units = array('B' => 0, 'KB' => 1, 'MB' => 2, 'GB' => 3);
    $value = 0;
    if ($bytes > 0) {
        if (!array_key_exists($unit, $units)) {
            $pow = floor(log($bytes) / log(1024));
            $unit = array_search($pow, $units);
        }
        $value = ($bytes / pow(1024, floor($units[$unit])));
    }
    if (!is_numeric($decimals) || $decimals < 0) {
        $decimals = 2;
    }
    return sprintf('%.' . $decimals . 'f ' . $unit, $value);
}


function flyAway($url)
{ ?>
    <script>
        window.location = "<?php echo $url; ?>";
    </script>
    <?php
}


function getAlphabets()
{
    $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return str_split($string);
}

function downloadUrlById($attachment)
{
    return url('attachments/download/' . encryptIt($attachment));
}


function pd($var)
{
    print_r($var);
    die();
}

function ed($val)
{
    echo $val;
    die();
}

function firstOption($title = 'Select')
{
    return "<option value=''>" . $title . "</option>";
}

function rand_color()
{
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}

function secondsToHumanReadable(/*int*/
    $seconds)/*: string*/
{
    //if you dont need php5 support, just remove the is_int check and make the input argument type int.
    if (!\is_int($seconds)) {
        throw new \InvalidArgumentException('Argument 1 passed to secondsToHumanReadable() must be of the type int, ' . \gettype($seconds) . ' given');
    }
    $dtF = new \DateTime ('@0');
    $dtT = new \DateTime ("@$seconds");
    $ret = '';
    if ($seconds === 0) {
        // special case
        return '0 seconds';
    }
    $diff = $dtF->diff($dtT);
    foreach (array(
                 'y' => 'year',
                 'm' => 'month',
                 'd' => 'day',
                 'h' => 'hour',
                 'i' => 'minute',
                 's' => 'second'
             ) as $time => $timename) {
        if ($diff->$time !== 0) {
            $ret .= $diff->$time . ' ' . $timename;
            if ($diff->$time !== 1 && $diff->$time !== -1) {
                $ret .= 's';
            }
            $ret .= ' ';
        }
    }
    return substr($ret, 0, -1);
}

function createDateRangeArray($strDateFrom, $strDateTo)
{
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.

    // could test validity of dates here but I'm already doing
    // that in the main script

    $aryRange = array();

    $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
    $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

    if ($iDateTo >= $iDateFrom) {
        array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
        while ($iDateFrom < $iDateTo) {
            $iDateFrom += 86400; // add 24 hours
            array_push($aryRange, date('Y-m-d', $iDateFrom));
        }
    }
    return $aryRange;
}


// Function to calculate square of value - mean
function sd_square($x, $mean)
{
    return pow($x - $mean, 2);
}

// Function to calculate standard deviation (uses sd_square)
function sd($array)
{

// square root of sum of squares devided by N-1
    return sqrt(array_sum(array_map("sd_square", $array, array_fill(0, count($array), (array_sum($array) / count($array))))) / (count($array) - 1));
}

function filterColumnForUnit($column)
{
    switch ($column) {
        case 'mpn':
            return 'MPN %';
            break;

        case 'bvkmn':
            return 'BVKKMN %';
            break;

        case 'interests_amount':
            return 'Interest Amount (EUR)';
            break;
    }
    return $column;
}

function filterColumnForSubtitle($column)
{
    switch ($column) {
        case 'mpn':
            return 'MPN % per selected Credit and period';
            break;

        case 'bvkmn':
            return 'BVKKMN % per selected Credit and period';
            break;

        case 'interests_amount':
            return 'Interest Amount per selected Credit and period';
            break;
    }
    return $column;
}

function rawQ($string)
{
    return DB::raw($string);
}

function dummyUrl()
{
    return asset('assets/images/innerlogo.png');
}

function getTotalFromOrders(\Illuminate\Support\Collection $collection)
{
    $total = 0;
    foreach ($collection as $coln) {
        $total += $coln->getTotalPrice();
    }

    return $total;
}

if (!function_exists('btn')) {
    function btn($title = 'Save', $class = 'btn-primary')
    {
        return '<input type="submit" value="' . $title . '" class="btn ' . $class . ' submit-btn">';
    }
}


function EXPORT_TABLES($host, $user, $pass, $name, $tables = false, $backup_name = false)
{
    set_time_limit(3000);
    $mysqli = new mysqli($host, $user, $pass, $name);
    $mysqli->select_db($name);
    $mysqli->query("SET NAMES 'utf8'");
    $queryTables = $mysqli->query('SHOW TABLES');
    while ($row = $queryTables->fetch_row()) {
        $target_tables[] = $row[0];
    }
    if ($tables !== false) {
        $target_tables = array_intersect($target_tables, $tables);
    }
    $content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `" . $name . "`\r\n--\r\n\r\n\r\n";
    foreach ($target_tables as $table) {
        if (empty($table)) {
            continue;
        }
        $result = $mysqli->query('SELECT * FROM `' . $table . '`');
        $fields_amount = $result->field_count;
        $rows_num = $mysqli->affected_rows;
        $res = $mysqli->query('SHOW CREATE TABLE ' . $table);
        $TableMLine = $res->fetch_row();
        $content .= "\n\n" . $TableMLine[1] . ";\n\n";
        for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {
            while ($row = $result->fetch_row()) { //when started (and every after 100 command cycle):
                if ($st_counter % 100 == 0 || $st_counter == 0) {
                    $content .= "\nINSERT INTO " . $table . " VALUES";
                }
                $content .= "\n(";
                for ($j = 0; $j < $fields_amount; $j++) {
                    $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
                    if (isset($row[$j])) {
                        $content .= '"' . $row[$j] . '"';
                    } else {
                        $content .= '""';
                    }
                    if ($j < ($fields_amount - 1)) {
                        $content .= ',';
                    }
                }
                $content .= ")";
                //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
                    $content .= ";";
                } else {
                    $content .= ",";
                }
                $st_counter = $st_counter + 1;
            }
        }
        $content .= "\n\n\n";
    }
    $content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
    $backup_name = $backup_name ? $backup_name : $name . "___(" . date('H-i-s') . "_" . date('d-m-Y') . ")__rand" . rand(1, 11111111) . ".sql";
    ob_get_clean();
    /*header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=\"" . $backup_name . "\"");*/
    File::put(storage_path('backups/'.$backup_name), $content);
    return storage_path('backups/'.$backup_name);
    //exit;
}