<?php

class AboutUsPage
{
    public function render()
    {
?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>About Us - Ceres Liner</title>
            <link rel="stylesheet" href="../css/aboutus.css"> <!-- Link to the CSS file -->
            <style>
                .back-button {
                    color: #FF6B00;
                    font-family: Poppins;
                    font-size: 40px;
                    font-style: normal;
                    font-weight: 600;
                    line-height: normal;
                    display: flex;
                    width: 172px;
                    height: 54px;
                    padding: 0px 20px;
                    justify-content: center;
                    align-items: center;
                    gap: 10px;
                    flex-shrink: 0;
                    border-radius: 30px;
                    border: 3px solid #FF6B00;
                    background: #FAFF00;
                    position: absolute;
                    top: 20px;
                    right: 20px;
                    text-decoration: none;
                }
            </style>
        </head>

        <body>
            <a href="login.php" class="back-button">BACK</a>
        </body>

        </html>
<?php
    }
}

?>