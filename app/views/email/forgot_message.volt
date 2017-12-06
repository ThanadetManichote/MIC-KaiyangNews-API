<!DOCTYPE html>
<html>

<body>

    <h3>Dear
        <?php echo $name?>
    </h3>
    <br />
    <p>Regarding your request for password retrieval, Your password reset code :
        <h2 style="color:mediumslateblue;">

            <ul>
                <?php echo $recovery_code?>
            </ul>
        </h2> Please input you reset code in the application.</p>
    <br />

    <p>Best Regards, </p>
    <p>CP Fivestar</p>


</body>

</html>