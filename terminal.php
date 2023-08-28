<?php
    if(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') == 'xmlhttprequest')
    {    
        $result = $_POST["value"];

        $result = shell_exec($result);
        
        echo $result;
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/node_modules/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <title>Local Terminal</title>
    <script>
        $(function(){
            $("input[type=text]").on("keydown", function(e){
                if(e.which != 13)
                    return

                    $.ajax({
                        url: "/terminal.php",
                        method: "post",
                        data: {value: $(this).val()},
                        success: function(result){
                            $(".result").append(result);
                        } 

                    });
            });
        })
    </script>
</head>
<body>
    <?php 
        session_start();
        if(!isset($_SESSION["user"]))
            die("ßßßßßß!!!");
    ?>

    <input type="text" autofocus="true">
    <pre class="result"></pre>
</body>
</html>