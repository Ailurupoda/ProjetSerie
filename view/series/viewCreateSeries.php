<?php
<<<<<<< HEAD

    echo <<< EOT
        <form method="get" action=".">
            <fieldset>
                <legend>$label une série</legend>
                 <p>
                    <label for="id_title">Title :</label>
                    <input type="text" value="$t" name="title" id="id_title" $r/>
                </p>
                <input type="hidden" name="action" value="$act" />
                <input type="hidden" name="controller" value="Series" />                
                <p>
                    <input type="submit" value="$submit" />
                </p>

            </fieldset>
EOT;
?>
=======
echo <<< EOT
        <form method="get" action="">
            <fieldset>
                <legend>$label une série:</legend>
                $hidden_id
                <p>
                    <label for="id_title">Nom de la série</label> :
                    <input type="text" value="$t" name="title" id="id_title"/>
                </p>
                <input type="hidden" name="action" value="$act" />
                <input type="hidden" name="controller" value="series" />                
                <p>
                    <input type="submit" value="$submit" />
                </p>
            </fieldset>
        </form>
EOT;
?>        
>>>>>>> e12fef31b36595fe53afa4af976b52d2a4ee40da
