<?php

echo <<< EOT
        <form method="get" action="">
            <fieldset>
                <legend>$label une série:</legend>
                $hidden_id
                <p>
                    <label for="id_title">Nom de la série</label> :
                    <input type="text" value="$t" name="title" id="id_title" autocomplete="off"/>
                </p>
                <input type="hidden" name="action" value="$act" />
                <input type="hidden" name="controller" value="series" />                
                <p>
                    <input type="submit" value="$submit" />
                </p>
            </fieldset>
        </form>
EOT;

