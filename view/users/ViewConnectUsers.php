<?php
echo <<< EOT
        <form method="post" action=".">
            <fieldset>
                <legend>$label </legend>
                <p>
                    <label for="id_mail">Mail :</label>
                    <input type="text" value="$mail" name="mail" id="mail" required/>
                </p>
                <p>
                    <label for="id_pw">Mot de passe :</label>
                    <input type="password" value="$ConnectPassword" name="ConnectPassword" id="id_pwd" required/>
                </p>
                
                <input type="hidden" name="action" value="$act" />
                <input type="hidden" name="controller" value="Users" />                
                
                <p>
                    <input type="submit" value="$submit" />
                </p>
        
            </fieldset>
        </form>
EOT;
?>