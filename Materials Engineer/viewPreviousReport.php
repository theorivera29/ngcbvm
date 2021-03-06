<?php
    include "../session.php";
    if (isset($_SESSION['lastmatinfo_month'])) {
        $projects_id = $_SESSION['projects_id'];
        $lastmatinfo_month = $_SESSION['lastmatinfo_month'];
        $lastmatinfo_year = $_SESSION['lastmatinfo_year'];
    } else {
        header("Location:http://www.ngcbdcinventorysystem.com/Materials%20Engineer/currentReport.php");  
    }
?>

<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="../Images/login2.png">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
<div id="content">
        <span class="slide">
            <a href="#" class="open" onclick="window.location.href='previousReportsPage.php'">
                <i class="fas fa-arrow-circle-left"></i>
            </a>
            <h4 class="title">NEW GOLDEN CITY BUILDERS AND DEVELOPMENT CORPORATION</h4>
            <div class="account-container">
                <?php 
                        $sql = "SELECT * FROM accounts WHERE accounts_id = '$accounts_id'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_row($result);
            ?>
                <h5 class="active-user">
                    <?php echo $row[1]." ".$row[2]; ?>
                </h5>
                <div class="btn-group dropdown-account">
                    <button type="button" class="btn dropdown-toggle dropdown-settings" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="account.php">Account Settings</a>
                        <a class="dropdown-item" href="../logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </span>
    </div>
    <button class="btn btn-warning" id="generate-report" type="button" onclick="window.location.href = 'prevGenerateReport.php'">Generate Report</button>
    <table class="table reportpage-table table-striped table-bordered">
        <thead>
            <tr>
                <th class="align-middle">Particulars</th>
                <th class="align-middle">Previous Material Stock</th>
                <th class="align-middle">Unit</th>
                <th class="align-middle">Delivered Material as of <?php echo date("F", mktime(0, 0, 0, $lastmatinfo_month, 10))." ".$lastmatinfo_year ;?></th>
                <th class="align-middle">Material Pulled Out as of <?php echo date("F", mktime(0, 0, 0, $lastmatinfo_month, 10))." ".$lastmatinfo_year ;?></th>
                <th class="align-middle">Unit</th>
                <th class="align-middle">Accumulated Materials Delivered</th>
                <th class="align-middle">Material on Site as of <?php echo date("F", mktime(0, 0, 0, $lastmatinfo_month, 10))." ".$lastmatinfo_year ;?></th>
                <th class="align-middle">Unit</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_categ = "SELECT DISTINCT
                            categories_name
                        FROM
                            lastmatinfo
                        INNER JOIN
                            categories ON categories.categories_id = lastmatinfo.lastmatinfo_categ
                        WHERE
                            lastmatinfo.lastmatinfo_project = $projects_id
                            AND
                                lastmatinfo.lastmatinfo_year = $lastmatinfo_year
                            AND
                                lastmatinfo.lastmatinfo_month = $lastmatinfo_month;";
            $result = mysqli_query($conn, $sql_categ);
            $categories = array();
            while($row_categ = mysqli_fetch_assoc($result)){
                $categories[] = $row_categ;
            }
            foreach($categories as $data) {
                $categ = $data['categories_name'];
            ?>
            <tr>
                <td><b> <?php echo $categ ;?> </b> </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php
                $sql = "SELECT
                            materials.mat_name,
                            lastmatinfo.lastmatinfo_prevStock,
                            unit.unit_name,
                            lastmatinfo.lastmatinfo_deliveredMat,
                            lastmatinfo.lastmatinfo_matPulledOut,
                            lastmatinfo.lastmatinfo_accumulatedMat,
                            lastmatinfo.lastmatinfo_matOnSite
                        FROM
                            lastmatinfo
                        INNER JOIN
                            materials ON lastmatinfo.lastmatinfo_matname = materials.mat_id
                        INNER JOIN
                            categories ON lastmatinfo.lastmatinfo_categ = categories.categories_id
                        INNER JOIN
                            unit ON lastmatinfo.lastmatinfo_unit = unit.unit_id
                        WHERE 
                            lastmatinfo.lastmatinfo_project = $projects_id 
                            AND
                                lastmatinfo.lastmatinfo_year = $lastmatinfo_year
                            AND
                                lastmatinfo.lastmatinfo_month = $lastmatinfo_month
                            AND
                                categories.categories_name = '$categ' 
                        ORDER BY 1;";

                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_row($result)) {
            ?>
            <tr>
                <td><?php echo $row[0];?></td>
                <td><?php echo $row[1];?></td>
                <td><?php echo $row[2];?></td>
                <td><?php echo $row[3];?></td>
                <td><?php echo $row[4];?></td>
                <td><?php echo $row[2];?></td>
                <td><?php echo $row[5];?></td>
                <td><?php echo $row[6];?></td>
                <td><?php echo $row[2];?></td>
            </tr>

            <?php
                }
            }
            ?>
        </tbody>
    </table>
</body>
<script type="text/javascript">
    function openSlideMenu() {
        document.getElementById('menu').style.width = '15%';
    }

    function closeSlideMenu() {
        document.getElementById('menu').style.width = '0';
        document.getElementById('content').style.marginLeft = '0';
    }

    $(document).ready(function () {

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

    });
</script>

</html>