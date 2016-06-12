<?php $nav_en_cours = 'create'; 

echo <<< EOT
        <form method="get" action="">
            <fieldset class="form-group">
                <legend>$label une série:</legend>
                $hidden_id
                <div class="input-group">
                    <label for="id_title">Nom de la série</label> :
                    <input type="text" value="$t" name="title" id="id_title" autocomplete="off" autofocus/>
                </div>
                <input type="hidden" name="action" value="$act" />
                <input type="hidden" name="controller" value="series" />                
                    <input type="submit" value="$submit" />
            </fieldset>
        </form>
EOT;

?>