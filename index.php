<?php
require_once("config.php");
require_once("dbcontroller.php");
require_once("functions.php");

$dbController = new DBController($connector);
$mCommons = $dbController->getAllMCommon();
if (isset($_GET["search"]) && (!empty($_GET['keyword']) || !empty($_GET['frame_number']))) {
    $tCars = $dbController->searchTCars(htmlspecialchars($_GET["keyword"]), htmlspecialchars($_GET["frame_number"]));
} else {
    $tCars = $dbController->getAllTCars();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="content-language" content="ja">
    <meta http-equiv="content-style-type" content="text/css">
    <meta http-equiv="content-script-type" content="text/javascript">
    <meta http-equiv="imagetoolbar" content="no">
    <meta name="viewport" content="width=1024">
    <meta http-equiv="keywords" content="">
    <meta http-equiv="discription" content="">
    <title>車輌管理</title>
    <link rel="stylesheet" type="text/css" href="./css/styles.css" media="screen, print">
    <link rel="stylesheet" type="text/css" href="./css/jquery-ui.min.css" media="screen, print">
    <script type="text/javascript" src="./js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="./js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="./js/main.js"></script>
</head>

<body class="car">

    <div id="container">
        <div class="globalNav clearfix">
            <ul>
                <li class="slide">
                    <a href="./">トップページ</a>
                </li>
                <li class="slide">
                    <a href="./list.html">車輌管理</a>
                </li>
            </ul>
        </div><!-- End of.globalNav -->

        <div id="contents" class="clearfix">
            <form action="#" id="form1" method="get" accept-charset="utf-8">

                <div class="inner">
                    <h2>車輌管理</h2>

                    <div class="menuList clearfix">

                        <h3>検索</h3>
                        <div class="searchQBox">
                            <table class="tableTypeD">
                                <tbody>
                                    <tr>
                                        <th>キーワード</th>
                                        <td>
                                            <input type="text" name="keyword" class="input_item" value="<?php echo (isset($_GET["keyword"]) ? htmlspecialchars($_GET["keyword"]) : '') ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>車台番号</th>
                                        <td>
                                            <input type="text" name="frame_number" class="input_item" value="<?php echo (isset($_GET["frame_number"]) ? htmlspecialchars($_GET["frame_number"]) : '') ?>">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div style="text-align:center;">
                                <button type="submit" name="search" class="search-btn">　検索　</button>
                            </div>
                        </div>
                    </div>

                    <h3>車輌一覧</h3>
                    <div id="exhibit_bid_list_box">
                        <table class="tableTypeB" id="exhibit_bid_list" style="margin: 0px;">
                            <thead>
                                <tr>
                                    <th>メーカー名</th>
                                    <th>車名</th>
                                    <th>型式</th>
                                    <th>車台番号</th>
                                    <th>初年度登録</th>
                                    <th>走行距離</th>
                                    <th>外装色</th>
                                    <th>シフト</th>
                                    <th>小売価格</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($tCars as $car) {
                                ?>
                                    <tr>
                                        <td><?php
                                            echo htmlspecialchars($car['maker_name']);
                                            ?></td>
                                        <td><?php
                                            echo htmlspecialchars($car['car_name']);
                                            ?></td>
                                        <td><?php
                                            echo htmlspecialchars($car['car_type']);
                                            ?></td>
                                        <td><?php
                                            echo htmlspecialchars($car['frame_number']);
                                            ?></td>
                                        <td><?php
                                            echo toWareki(htmlspecialchars($car['first_entry_date']));
                                            ?></td>
                                        <td><?php
                                            $mileageUnitCode = htmlspecialchars($mCommons[2][$car['mileage_unit_cd']]);
                                            echo formattedMileage(htmlspecialchars($car['mileage']), $mileageUnitCode);
                                            ?></td>
                                        <td><?php
                                            echo formattedOutColor(htmlspecialchars($car['out_color_name']));
                                            ?></td>
                                        <td><?php
                                            $shiftCode = htmlspecialchars($mCommons[7][$car['shift_cd']]);
                                            $shiftPosition = htmlspecialchars($mCommons[6][$car['shift_posi_cd']]);
                                            $shiftCount = htmlspecialchars($car['shift_cnt']);
                                            echo formattedShift($shiftCode, $shiftCount, $shiftPosition);
                                            ?></td>
                                        <td><?php
                                            echo formattedSalePrice(htmlspecialchars($car['sale_price']));
                                            ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- End of.inner -->
            </form>
        </div><!-- End of#contents -->

        <div id="footer">
            <p>&#169; COPYLIGHT (C) 2011 GENIO CO.,LTD. ALL RIGHT RESERVED.</p>
        </div>

    </div><!-- End of#container -->

</body>

</html>