<?php

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