<?php
include 'Resources/Php/ifLogedIn.php';
include 'Resources/Php/forIndex.php';
include 'header.php';
?>
    <div class="flex justify-center mt-10">
        <div class="w-2/3 myOrange flex justify-center py-3 rounded-md">
            <div class="p-5">
                <span class="text-xl text-green-700 w-full text-center">Choose City And Material for Search:</span><br/>
                <select id="city" class="rounded-md w-56 cursor-pointer">
                    <option value="0" >Choose City</option>
                    <?php
                    foreach ($cities as $city){
                        echo '<option value="'.$city['id'].'">'.$city['name'].'</option>';
                    }
                    ?>
                </select>

                    <?php
                    foreach ($materials as $material){
                        echo '  <label class="inline-flex items-center"><span class="ml-2 mr-1 text-green-700">'.$material['name'].'</span>
                                <input id="material" type="checkbox"  class="form-checkbox h-5 w-5 text-green-500" value="'.$material['id'].'">
                                </label>
                            ';
                    }
                    ?>
                <button id="search" name="search" class="bg-green-700 text-white w-24 h-8 rounded-md ml-5 cursor-pointer">Search</button>
            </div>
        </div>
    </div>
    <div id="error" class="text-center text-red-700 font-bold"></div>
    <div class="flex justify-center mt-3" >
        <button id="showNearestStation" off type="submit" name="search" value="Search" class="opacity-50 bg-green-700 text-white p-3 rounded-md ml-5">Click To Find Nearest Recycling Station</button>
    </div>
    <div class="p-10">
        <div id="mapid" class="shadow-lg border-4 border-green-700 rounded-lg"></div>
    </div>
<?php
include 'footer.php';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="Resources/Packages/leaflet/leaflet.js"></script>
<script type="text/javascript" src="Resources/Js/app.js"></script>
