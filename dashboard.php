<?php
include 'Resources/Php/ifLogedIn.php';
include 'Resources/Php/dashboard.php';
include 'header.php';
?>
<div class="flex justify-center p-8  overflow-auto h-5/6 ">
    <div>
        <table class="table-auto border-separate border border-green-800">
            <thead>
            <tr>
                <th colspan="6">List of Stations</th>
            </tr>
            <tr>
                <th>N0.</th>
                <th>City</th>
                <th>Area</th>
                <th>Address</th>
                <th>Lat</th>
                <th>Lng</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i=0;
            while ($station = mysqli_fetch_assoc($stations)){
                $i++;
                echo "
                <tr>
                    <td>".$i."</td>
                    <td>".$station['city']."</td>
                    <td>".$station['area']."</td>
                    <td>".$station['address']."</td>
                    <td>".$station['lat']."</td>
                    <td>".$station['lng']."</td>
                </tr>
                ";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php
include 'footer.php';
?>
