<!DOCTYPE html>
<html>

<body>

    <h3>Dear
        <?php echo $name?>
    </h3>
    <br />
    <div>
        <h2 style="color:mediumslateblue;">Date Requested :</h2>
            <ul>
                <?php
                    foreach($date as $value){
                        echo "<li> " .$value." </li>";
                    }
                ?>
            </ul>
    </div>
    <br />

    <p>Best Regards, </p>
    <p>CP Fivestar</p>


</body>

</html>