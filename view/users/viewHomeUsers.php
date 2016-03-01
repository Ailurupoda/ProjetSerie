 <?php
        echo "<p>Bienvenu sur notre site NextWatch.</p>";
        
		if(empty($_SESSION['mail'])){
        	echo "Guest !";
        }
        else echo myGet('mail');

        ?>